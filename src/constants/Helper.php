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


namespace constants
{


class Helper
{

    //  Do not set for production environments, but if you cannot get your cURL SSL setup to work then you can disable it
    public const DISABLE_SSL = false;


    //  NOTE: YOU MUST SET YOUR SNAPWONDERS API KEY BEFORE START (visit https://snapwonders.com for details)
    public const SNAPWONDERS_API_KEY = "<put-your-api-key-here>";

    //  Full path/filename to your media (this can be an image or video)
    public const MEDIA_PATH_FILENAME = "./Data/Images/me-mountain.jpg";

    //  Uploads are done via resumable uploading in chunks (this must be less than 5MB)
    public const DATA_CHUNK_SIZE = 400000;
}


}