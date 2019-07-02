<?php

namespace App\Console\Views;

use Illuminate\Console\Command;

class DeleteCommand extends Command {


    /**
     * @var string The artisan command name.
     */
     protected $name = 'delete:views {model}';

    /**
     * @var string The artisan command description
     */
     protected $description = 'Create view files for model';

    /**
     * @var string The artisan command signature
     */
     protected $signature = 'delete:views {model}';


    public function __construct()
    {
        parent::__construct();
    }

    public function handle()
    {
        $this->deleteViews();
    }

    public function deleteViews()
    {
        $modelName = $this->argument('model');
        $viewsPath = $this->views_path();
        $resourceDir = $viewsPath.$modelName;

        if (is_dir($resourceDir)) {
           $this->recursivelyRemove($resourceDir); 
        }

        $this->info(sprintf('All views files for '.$modelName.' successfully deleted.'));
    }

    public function recursivelyRemove($path)
    {
        $dir = opendir($path);
        while(false !== ( $file = readdir($dir)) ) {
            if (( $file != '.' ) && ( $file != '..' )) {
                $full = $path . '/' . $file;
                if ( is_dir($full) ) {
                    rrmdir($full);
                }
                else {
                    unlink($full);
                }
            }
        }
        closedir($dir);
        rmdir($path);
    }


    public function views_path() {
        return base_path().'/resources/views/'; 
    }
}

?>
