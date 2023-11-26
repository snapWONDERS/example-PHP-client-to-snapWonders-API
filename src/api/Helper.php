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


use GuzzleHttp\Client;
use constants\Helper as ConstHelper;


class Helper
{

    //  The API URLs
    public const URL_SNAPWONDERS_API         = "https://api.snapwonders.com/v1/";
    public const URL_UPLOAD_CREATE_MEDIA_URL = "upload/create-media-url";
    public const URL_JOB_CREATE_ANALYSE      = "job/analyse";

    //  Status codes
    public const STATUS_OK      = 200;
    public const STATUS_CREATED = 201;

	//  Job status
	public const JOB_STATUS_WAITING    = "WAITING";
	public const JOB_STATUS_PROCESSING = "PROCESSING";
	public const JOB_STATUS_COMPLETED  = "COMPLETED";
    public const JOB_STATUS_UNKNOWN    = "UNKNOWN";


    /**
     *  Access single client session
     */
    public static ?Client $m_oClient = null;

    public static function getClient(): Client
    {
        if (self::$m_oClient === null)
        {
            self::$m_oClient = new Client([
                'headers' => [
                    'api_key' => \constants\Helper::SNAPWONDERS_API_KEY,
                ]
            ]);
        }
        return self::$m_oClient;
    }


    /**
     * Set up the API options
     */
    public static function setupApiOptions(array $oArrOptions = []): array
    {
        if (\constants\Helper::DISABLE_SSL)
        {
            $oArrOptions['verify'] = false;
        }

        return $oArrOptions;
    }


    /**
     * Dumps API error and exit
     */
    public static function dumpApiError(string $sWhat, $oResp)
    {
        $nResStatus = $oResp->getStatusCode();

        $oJsonRes = json_decode($oResp->getBody(), true);
        $sResMessage =  $oJsonRes['message'] ?? 'Unknown error';

        echo "ERROR: $sWhat:[$sResMessage], status:[$nResStatus]";
        die;
    }
}


}