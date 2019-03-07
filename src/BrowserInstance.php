<?php
/**
 * Created by PhpStorm.
 * User: danie
 * Date: 07/12/2018
 * Time: 20:10
 */

namespace Tpccdaniel\DuskSecure;

use Tpccdaniel\DuskSecure\Chrome\SupportsChrome;
use Tpccdaniel\DuskSecure\Selenium\StartsSelenium;
use Tpccdaniel\DuskSecure\Selenium\StartsXvfb;

abstract class BrowserInstance
{
    use Concerns\ProvidesBrowser,
//        StartsSelenium,
//        StartsXvfb,
        SupportsChrome;

    protected $browser;

    /**
     * Register the base URL with Dusk.
     *
     * @return void
     */
    protected function setUp()
    {
        Browser::$baseUrl = $this->baseUrl();
        Browser::$storeScreenshotsAt = base_path('tests/Browser/screenshots');
        Browser::$storeConsoleLogAt = base_path('tests/Browser/console');
        Browser::$userResolver = function () {
            return $this->user();
        };
    }


}