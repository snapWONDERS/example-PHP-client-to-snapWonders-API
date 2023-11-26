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


require 'vendor/autoload.php';


use api\Jobs;
use constants\Helper;

echo <<<CData
snapWONDERS Client OpenAPI v3 PHP Example!
You must set your API key and media path/filename in your "./constants/Helper.php" file

CData;


//  Create an analyse job and display results
Jobs::analyseJob(Helper::MEDIA_PATH_FILENAME);