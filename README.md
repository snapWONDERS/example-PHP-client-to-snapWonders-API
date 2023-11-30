<p align="center">
    <a href="https://www.snapwonders.com/" target="_blank">
        <img src="https://snapwonders.com/img/logo/snap-wonders-logo-big.png" width="172" alt="snapWONDERS" />
    </a>
</p>

snapWonders — Deep digital media analysis, format conversions, steganography, scrubbing and regeneration. Providing digital media solutions


# Example PHP client to snapWonders API
The objective of this repository is to provide a PHP client example to snapWONDERS API. This includes a step-by-step
guide how to set up your development environment, the example source code and instructions on how to test and run.

Through the example source, you will be able to:
* Upload digital media (using resumable uploading following the Tus.io protocol)
* Perform deep digital media analysis, reveal hidden metadata, hidden metadata, copyrights, steganography and private information leakage
* Display the results from the analysis (in which you can extract and make use as needed)


# Installation and setup

## Development environment
For the development environment you will need:
* Install Visual Studio Code. You can download and install from [visual code studio](https://code.visualstudio.com/download)
* Composer if you don't have it installed. To install and to set up you can follow these instructions from [Install Composer](https://getcomposer.org/download/)
* Ensure that PHP is up and running in your development environment and in the path
* Install all the vendor packages via `php.exe composer.phar install`
* Update all your details in the Visual Code `settings.json` file to allow Visual Code to debug PHP and run it. You will need to
set up your PHP paths etc. Currently, for PHP development I have a WAMP setup, but this may vary for your development environment and you can adjust as needed
* Depending on your PHP setup for development, it may be possible you will get cURL certificate issues when running and you will need to set SSL up:
1. You can set up the SSL for cURL and update your php.ini as needed;
2. Disable SSL verification (NOT FOR PRODUCTION USE) by updating the constant `DISABLE_SSL` to `true` in the `src/constants/Helper.php` file
* Install the plugins into Visual Studio Code". See image below for details:
<img src="https://storage.snapwonders.com/cache/1/oO0hdjIRtHGUglJdEGZ32T38AbtRMaO4.png?mark=snap-wonders-logo.png&markpos=bottom&marky=30&markalpha=30&s=a4c6178b107cfd9e7fd43113a8e675d7" alt="PHP plugin 1" />
<img src="https://storage.snapwonders.com/cache/1/zS5ugUUshpT3gvqSKgbrOSKgoPY7LcZ5.png?mark=snap-wonders-logo.png&markpos=bottom&marky=30&markalpha=30&s=7dfc5f9a9cab2bbd0ab12ffbcdeaede8" alt="PHP plugin 2" />
<img src="https://storage.snapwonders.com/cache/1/3ZvayrOslOtgl3Zy8h9Fe734C_o1PE_P.png?mark=snap-wonders-logo.png&markpos=bottom&marky=30&markalpha=30&s=349ba617c8c2fa522169d156e25b79f0" alt="PHP plugin 3" />

## snapWONDERS API Key
You will need the snapWONDERS API Key before you can get started:
* Signup and create an account at snapWONDERS at [signup](https://snapwonders.com/sign-up). If you wish to create account via Tor or I2P then you can do so by accessing snapWONDERS via the Tor or I2P portals. For the dark web links visit [browsing safely](https://snapwonders.com/browsing-safely)
* Under your account settings, scroll to the bottom under the section "API Settings" and click the button to generate your Auth API key
* Copy this key directly into the `src/constants/Helper.php` file under the constant `SNAPWONDERS_API_KEY`


# Running the PHP example
Once everything above is setup you should be able to simply open the workspace folder with Visual Studio Code and run or debug it. Simply hit the default hot keys `F5` to start debugging or to run directly use `Ctrl+F5`.
<img src="https://storage.snapwonders.com/cache/1/n37XqQA4CsJmh-fnE0LlQlB0QOnxWYqd.png?mark=snap-wonders-logo.png&markpos=bottom&marky=30&markalpha=30&s=3badf97c1e460f1b23139842b6984909" alt="Visual Code IDE" />

If you wish, you can change and provide your own digital media to upload (images and/or videos) and change the `MEDIA_PATH_FILENAME` constant contained in the `src/constants/Helper.php` file. Otherwise the sample image provided is just a photo of me that I use on my social media accounts.

If all is well, then you should see the standard output to be something like below:
<img src="https://storage.snapwonders.com/cache/1/88POwr1GGHUVHLbJiAEptWKrwguDjZxa.png?mark=snap-wonders-logo.png&markpos=bottom&marky=30&markalpha=30&s=468d104174de055126453e8c370d4266" alt="Example for standard output display for PHP client to snapWONDERS API" />

Which provides similar information as per the analyse results via the snapWONDERS website:
<img src="https://storage.snapwonders.com/cache/1/wEqYS8DopFx1zqoFfAaAa12-58Eh6OCj.png?mark=snap-wonders-logo.png&markpos=bottom&marky=30&markalpha=30&s=9599795d1494b2bac7e4a2dc09a47967" alt="Results sample as showing on the snapWONDERS website" />

# Documentation
Useful documentation can be found at:
* For endpoint, swagger UI and other source code examples can be found at [snapWONDERS developers documentation](https://snapwonders.com/snapwonders-openapi-specification)
* The actual snapWONDERS OpenAPI Specification can be found at [snapWONDERS OpenAPI Specification](https://api.snapwonders.com/site/docs)
* If you're wanting the actual JSON Schema details for the purpose of auto generating source from the schema you can use [snapWONDERS OpenAPI Specification JSON Schema](https://api.snapwonders.com/site/json-schema)
* This README.md and its content is mostly duplicated at [How to create a PHP client to integrate with the snapWONDERS API](https://snapwonders.com/resources/how-to-create-a-PHP-client-to-integrate-with-the-snapwonders-api)


# Contact

## For security concerns
If you have spotted any security concerns then please reach out via [contacting snapWONDERS](https://snapwonders.com/contact) and set the subject to **"SECURITY CONCERNS"** and provide the information about your concerns. If you wish to contact via Tor or I2P then you can do so by accessing snapWONDERS via the Tor or I2P portals. For the dark web links visit [browsing safely](https://snapwonders.com/browsing-safely)

## For FAQ and questions
It may be possible that your questions are already answered in the [FAQ](https://snapwonders.com/faq). Be sure to check out the FAQ content first. Otherwise you may reach out via [contacting snapWONDERS](https://snapwonders.com/contact). If you wish to contact via Tor or I2P then you can do so by accessing snapWONDERS via the Tor or I2P portals. For the dark web links visit [browsing safely](https://snapwonders.com/browsing-safely)

# For contacting the author
Use this link to contact the author [Kenneth Springer](https://kennethbspringer.au/)
