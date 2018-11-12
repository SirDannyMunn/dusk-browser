<?php

namespace Tpccdaniel\DuskSecure\Console;

use Illuminate\Console\Command;

class InstallCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'dusksecure:install';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Install Dusk into the application';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {
        if (! is_dir(base_path('dusk/Browser/Pages'))) {
            mkdir(base_path('dusk/Browser/Pages'), 0755, true);
        }

        if (! is_dir(base_path('dusk/Browser/Components'))) {
            mkdir(base_path('dusk/Browser/Components'), 0755, true);
        }

        if (! is_dir(base_path('dusk/Browser/screenshots'))) {
            $this->createScreenshotsDirectory();
        }

        if (! is_dir(base_path('dusk/Browser/console'))) {
            $this->createConsoleDirectory();
        }

        $stubs = [
            'ExampleTest.stub' => base_path('dusk/Browser/ExampleTest.php'),
            'HomePage.stub' => base_path('dusk/Browser/Pages/HomePage.php'),
            'DuskTestCase.stub' => base_path('dusk/DuskTestCase.php'),
            'Page.stub' => base_path('dusk/Browser/Pages/Page.php'),
            'Browser.stub' => base_path('app/Browser/Browser.php')
        ];

        foreach ($stubs as $stub => $file) {
            if (! is_file($file)) {
                copy(__DIR__.'/../../stubs/'.$stub, $file);
            }
        }

        $this->info('Dusk scaffolding installed successfully.');
    }

    /**
     * Create the screenshots directory.
     *
     * @return void
     */
    protected function createScreenshotsDirectory()
    {
        mkdir(base_path('storage/app/dusk/screenshots'), 0755, true);

        file_put_contents(base_path('storage/app/dusk/screenshots/.gitignore'), '*!.gitignore');
    }

    /**
     * Create the console directory.
     *
     * @return void
     */
    protected function createConsoleDirectory()
    {
        mkdir(base_path('dusk/Browser/console'), 0777, true);

        file_put_contents(base_path('dusk/Browser/console/.gitignore'), '*
!.gitignore
');
    }
}
