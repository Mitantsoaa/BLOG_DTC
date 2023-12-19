
<?php
spl_autoload_register(function($class){
    $paths = array(
        join(DIRECTORY_SEPARATOR, [__DIR__]),
        join(DIRECTORY_SEPARATOR, [__DIR__.'/models']),

    );

    foreach($paths as $path){
        $file = join(DIRECTORY_SEPARATOR, [$path, $class.'.php']) ;
        if(file_exists($file))
            return require_once $file;
    }
});