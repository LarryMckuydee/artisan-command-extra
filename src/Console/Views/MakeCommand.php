<?php

namespace ArtisanCommandExtra\Console\Views;

use Illuminate\Console\Command;

class MakeCommand extends Command {


    /**
     * @var string The artisan command name.
     */
     protected $name = 'generate:views {model}';

    /**
     * @var string The artisan command description
     */
     protected $description = 'Create view files for model';

    /**
     * @var string The artisan command signature
     */
     protected $signature = 'generate:views {model}';


    public function __construct()
    {
        parent::__construct();
    }

    public function handle()
    {
        $this->createViews();
    }

    public function createViews()
    {
        $modelName = $this->argument('model');
        $viewsPath = $this->views_path();
        $resourceFiles = array(
            'index.blade.php',
            'edit.blade.php',
            'show.blade.php',
            'new.blade.php',
            '_form.blade.php'
        );

        foreach($resourceFiles as $resourceFile)
        {
            $fullPath = $viewsPath.$modelName.'/'.$resourceFile;
            $resourceDir = $viewsPath.$modelName;

            if (file_exists($fullPath)) {
                // ask if want to create 
                if ($this->confirm('Creating '.$resourceFile.' for model '.$modelName.' will replace existing file, are you sure you want to continue? (y/yes to continue, n/no to skip)')) { 
                    // if confirm then create file
                    $this->createFile($fullPath);
                }
            } else {
                //create file
                if (is_dir($resourceDir)) {
                    $this->createFile($fullPath);
                } else {
                    $this->createDirectory($resourceDir);
                    $this->createFile($fullPath);
                }
            }

            $this->info(sprintf($fullPath.' successfully created.'));
        }
    }

    public function createFile($path) {
        return fopen($path,'w') or die('Failed to create file');
    }

    public function createDirectory($path) {
        return mkdir($path) or die('Failed to create Directory');
    }

    public function views_path() {
        return base_path().'/resources/views/'; 
    }
}

?>
