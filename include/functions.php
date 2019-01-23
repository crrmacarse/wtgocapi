<?php

    /*
        spl_autoload_register()

        definition:

            load a class into a file automatically by only including functions.php

        use:

            require_once('functions.php');
            $api = new Api; (translates to api.php then looks up for the Api class inside)

    */

    spl_autoload_register(function($className){
        $path = dirname(__DIR__).'/'.'classes/' . strtolower($className) . '.php';
        if(file_exists($path)) {
            require_once($path);
        } else {
            die("File $path is not found.");   
        }
    })

?>