<?php

/*
 * snapWONDERS OpenAPI Specification
 * API version: 1.0
 *
 * Copyright (c) snapWONDERS.com, All rights reserved 2023
 *
 * Author: Kenneth Springer (https://kennethbspringer.au)
 *
 * All the snapWONDERS API services is available over the Clearnet / **Web** and Dark Web **Tor** and **I2P**
 * Read details: https://snapwonders.com/snapwonders-openapi-specification
 *
 */


namespace api
{


use GuzzleHttp\Client;


class Jobs
{

    /**
     *  Create an analyse job and display results
     */
    public static function analyseJob(string $sPathFileName): void
    {
        //  Create upload media url and upload file in data chunks
        $sUrlUploadMedia = Upload::createUploadMediaUrl($sPathFileName);
        Upload::uploadMedia($sUrlUploadMedia, $sPathFileName);

        //  Create an analyse job url
        $sUrlJobStatus = self::createAnalyseJob($sUrlUploadMedia);

        //  Track the job status, wait until analyse job is completed
        $oJsonJobStatus = [];
        while (true)
        {
            $oJsonJobStatus = self::getJobStatus($sUrlJobStatus);

            //  Wait for the job to be completed
            $sStatus = $oJsonJobStatus['status'] ?? Helper::JOB_STATUS_UNKNOWN;
            if (($sStatus == Helper::JOB_STATUS_WAITING) || ($sStatus == Helper::JOB_STATUS_PROCESSING))
            {
                echo "INFO: Sleeping for a few seconds...\n";
                sleep(5);
            }

            //  If completed we break out
            else if ($sStatus == Helper::JOB_STATUS_COMPLETED)
            {
                break;
            }

            //  Some unknown state?
            else
            {
                $sMessage = $oJsonJobStatus['message'];
                echo "ERROR: Analyse job failed with status:[$sStatus], message:[$sMessage]";
                die;
            }
        }

        //  Get and display results
        $oDataResults = self::getJobResults($oJsonJobStatus['resultUrl'] ?? '?');
        print_r(json_encode(json_decode($oDataResults), JSON_PRETTY_PRINT));
    }


    /**
     *  Create an analyse job
     */
    private static function createAnalyseJob(string $sUrlUploadMedia): string
    {
        echo "CALL: createAnalyseJob()\n";

        //  Build up Json Analyse Job
        $oArrJobAnalyse = [
            'key' => basename($sUrlUploadMedia),
            'enableTips' => true,
            'enableExtraAnalysis' => true
        ];

        //  Call API to create an analyse job
        $oClient = Helper::getClient();
        $oResp = $oClient->post(Helper::URL_SNAPWONDERS_API . Helper::URL_JOB_CREATE_ANALYSE,
                                Helper::setupApiOptions([
                                    'json' => $oArrJobAnalyse
                                ]));

        //  Check POST status for errors
        if ($oResp->getStatusCode() != Helper::STATUS_OK)
        {
            Helper::dumpApiError('Create analyse job failed', $oResp);
        }

        //  Success - Extract the job url
        $sUrlJobAnalyse = $oResp->getHeaderLine('Location');
        echo "SUCCESS: Created analyse job located at url:[$sUrlJobAnalyse]\n";
        return $sUrlJobAnalyse;
    }


    /**
     *  Gets the job status
     */
    private static function getJobStatus(string $sUrlJobStatus): array
    {
        echo "CALL: getJobStatus()\n";

        //  Call API to get job status
        $oClient = Helper::getClient();
        $oResp = $oClient->post($sUrlJobStatus,
                                Helper::setupApiOptions());

        //  Check POST status for errors
        if ($oResp->getStatusCode() != Helper::STATUS_OK)
        {
            Helper::dumpApiError('Get job results failed', $oResp);
        }

        //  Success - Extract the media url
        $oJsonJobStatus = json_decode($oResp->getBody(), true);
        $sStatus = $oJsonJobStatus['status'] ?? Helper::JOB_STATUS_UNKNOWN;
        echo "SUCCESS: Have job status:[$sStatus]\n";
        return $oJsonJobStatus;
    }


    /**
     *  Gets the job results (this can be a JSON or image content)
     */
    private static function getJobResults(string $sUrlJobResults): string
    {
        echo "CALL: getJobResults()\n";

        //  Call API to get job results
        $oClient = Helper::getClient();
        $oResp = $oClient->get($sUrlJobResults,
                               Helper::setupApiOptions());

        //  Check GET status for errors
        if ($oResp->getStatusCode() != Helper::STATUS_OK)
        {
            Helper::dumpApiError('Get job results failed', $oResp);
        }

        //  Success - Extract the media url
        $sResBody = $oResp->getBody();
        $nResBody = strlen($sResBody);
        echo "SUCCESS: Have results with data size:[$nResBody]\n";
        return $sResBody;
    }
}


}
