<?php

namespace Tpccdaniel\DuskSecure\Selenium;

use Symfony\Component\Process\Process;
use Symfony\Component\Process\ProcessBuilder;
use Tpccdaniel\DuskSecure\Concerns\ProvidesBrowser;

trait StartsXvfb
{
    /**
     * The xvfb process instance.
     *
     * @var Process
     */
    protected static $xvfbProcess;
    /**
     * Start the xvfb process.
     *
     * @return void
     */
    public static function startXvfb()
    {
        static::$xvfbProcess = static::buildXvfbProcess();
        static::$xvfbProcess->start();
        ProvidesBrowser::afterClass(function () {
            static::stopXvfb();
        });
    }
    /**
     * Stop the xvfb process.
     *
     * @return void
     */
    public static function stopXvfb()
    {
        if (static::$xvfbProcess) {
            static::$xvfbProcess->stop();
        }
    }
    /**
     * Build the process to run the xvfb.
     *
     * @return Process
     */
    protected static function buildXvfbProcess()
    {
        return (new Process([
            'Xvfb',
            ':10',
            '-ac'
        ]));
    }
}
