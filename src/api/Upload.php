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


require_once dirname(__FILE__) . './../constants/Helper.php';


use constants\Helper as ConstHelper;


class Upload
{

    //  Fix up path slashes based on OS
    private static function fixupPathSlashes(string $sPath): string
    {
        return str_replace(['/', '\\'], DIRECTORY_SEPARATOR, $sPath);
    }


    //  Resolve media path to the data storage location
    private static function getFullMediaPathFileName(string $sMediaPathFileName): string
    {
        $sPath = realpath(self::fixupPathSlashes(dirname(__FILE__) . '/../../'));
        return $sPath . DIRECTORY_SEPARATOR . self::fixupPathSlashes(ltrim($sMediaPathFileName, "./"));
    }


    /**
     *  Create an upload media URL
     */
    public static function createUploadMediaUrl(string $sMediaPathFileName): string
    {
        echo "CALL: createUploadMediaUrl()\n";

        //  Build up Json File Metadata
        $sFullMediaPathFileName = self::getFullMediaPathFileName($sMediaPathFileName);

        $oArrFileMetadata = [
            'name' => basename($sFullMediaPathFileName),
            'size' => filesize($sFullMediaPathFileName),
        ];

        //  Call API to create the media url for uploading
        $oClient = Helper::getClient();
        $oResp = $oClient->post(Helper::URL_SNAPWONDERS_API . Helper::URL_UPLOAD_CREATE_MEDIA_URL,
                                Helper::setupApiOptions([
                                    'json' => $oArrFileMetadata
                                ]));

        //  Check POST status for errors
        if ($oResp->getStatusCode() != Helper::STATUS_CREATED)
        {
            Helper::dumpApiError('Create media url failed', $oResp);
        }

        //  Success - Extract the media url
        $sUrlCreateMedia = $oResp->getHeaderLine('Location');
        echo "SUCCESS: Created resumable uploading media url:[$sUrlCreateMedia]\n";
        return $sUrlCreateMedia;
    }


    /**
     *  Uploads a data chunk
     */
    private static function uploadDataChunk(string $sUrlUploadMedia, int $nOffset, $sDataChunk): int
    {

        //  Build the multipart form data for uploading
        $oArrMultipartData = [
            [
                'name'     => 'offset',
                'contents' => $nOffset
            ],
            [
                'name'     => 'file',
                'contents' => $sDataChunk
            ]
        ];

        //  Patch the data chunk for uploading to given media url
        $oClient = Helper::getClient();
        $oResp = $oClient->patch($sUrlUploadMedia,
                                 Helper::setupApiOptions([
                                     'multipart' => $oArrMultipartData
                                 ]));

        //  Check PATCH status for errors
        if ($oResp->getStatusCode() != Helper::STATUS_OK)
        {
            Helper::dumpApiError('Send PATCH request failed', $oResp);
        }

        //  Check for upload errors.
        //  Note: If an upload failed, you can retry uploading from the last offset. Call the HEAD request to determine
        //  the last offset position if you are not sure what that is. Uploading is resumable and can be continued
        //  at a later time (which is useful if there is a network outage or connectivity issue)
        //  snapWONDERS uploading follows the Tus.io protocol
        $nUploadOffset = intval($oResp->getHeaderLine('Upload-Offset'));
        if ($nUploadOffset <= 0)
        {
            echo 'ERROR: New `offset` extraction failed';
            die;

        }
        else if ($nUploadOffset != ($nOffset + strlen($sDataChunk)))
        {
            echo 'ERROR: Uploading data chunk failed! TODO: You can retry uploading the last data chunk or' .
                "resume uploading at a later point in time\n";
            die;
        }

        //  Success - Uploaded the data chunk
        echo "INFO: Uploaded data chunk starting at offset:[$nOffset], newOffset:[$nUploadOffset]\n";
        return $nUploadOffset;
    }


    /**
     *  Uploads file to given media url
     */
    public static function uploadMedia(string $sUrlUploadMedia, string $sMediaPathFileName)
    {
        echo "CALL: uploadMedia()\n";

        //  Open file
        $sFullMediaPathFileName = self::getFullMediaPathFileName($sMediaPathFileName);
        $nFileSize = filesize($sFullMediaPathFileName);
        $hFile = fopen($sFullMediaPathFileName, 'rb');
        if (false === $hFile)
        {
            echo "ERROR: Open file failed:[$sFullMediaPathFileName]\n";
            die;
        }

        //  Set up to read chunks
        $nOffset = 0;
        while ($nOffset < $nFileSize)
        {
            $sFileData = fread($hFile, ConstHelper::DATA_CHUNK_SIZE);
            if (false === $sFileData)
            {
                echo "ERROR: Read file failed at offset:[$nOffset]\n";
                die;
            }

            $nOffset = self::uploadDataChunk($sUrlUploadMedia, $nOffset, $sFileData);
        }
        fclose($hFile);

        echo "SUCCESS: Uploaded file:[$sFullMediaPathFileName] to media url:[$sUrlUploadMedia]\n";
    }
}


}
