<?php

namespace Tpccdaniel\DuskSecure\Concerns;

use Tpccdaniel\DuskSecure\Browser;

trait InteractsWithJavascript
{
    /**
     * Execute JavaScript within the browser.
     *
     * @param  string|array $scripts
     * @return array
     */
    public function script($scripts)
    {
        if ( ! $this->jqueryAvailable()) {
            $this->driver->executeScript(file_get_contents(__DIR__.'/../../bin/jquery.js'));
        }

        \Log::info($this->jqueryAvailable());

        return collect((array) $scripts)->map(function ($script) {
            return $this->driver->executeScript($script);
        })->all();
    }

    public function jqueryAvailable($inject=false)
    {
        $available = $this->driver->executeScript("return window.jQuery != null");
        \Log::info($available ? 'Available' : 'Unavailable');
        return $available;
    }

    public function html($selector)
    {
        return $this->script("return $('".$selector."').html()");
    }

    public function scroll($x, $y)
    {
        $this->script("window.scrollTo($x, $y);");

        return $this;
    }

    public function captcha()
    {
        $iframe = $this->script("return $('iframe').first().html()")[0];

        if (str_contains($iframe, "Request unsuccessful")) {
            return substr($iframe, strpos($iframe, "ID:") + 4);
        }

        return false;
    }
}
