<?php 

    /*
        
        READ ABOUT PHP Autoloading here: http://php.net/manual/en/language.oop5.autoload.php
        READ ABOUT PHP Namespace here: http://php.net/manual/en/language.namespaces.php
       
        The System handles namespace as its path to the specified class:

            Notice how we have a class named clsAccountUser with corresponding filename clsaccountuser(all in 
            low caps). It is because we are translating the passed className into the spl_autoload_register 
            to a low caps. it then proceeds to search for that specific file and includes it in the file.

            > accepts Classes\Diday\clsAccountUser
            > converts to classes\diday\clsaccountuser.php
            > added with relative path <relative path>\classes\diday\clsaccountuser.php
            > require(<the fullpath goes here>)
            > tadaa! now we can use the namespace equivalent of it!
            
    */

    spl_autoload_register(function($className){

        /* 
            $cleanedClassName:
            
            This due to php namespace and linux interaction as it tries to use "\" instead of readablee 
            directory seperator "/" of linux.
        */
        
        $cleanedClassName = str_replace('\\', DIRECTORY_SEPARATOR, $className);
        $path = dirname(__DIR__).'/'. strtolower($cleanedClassName) . '.php';

        if(file_exists($path)) {
            require($path);
        } else {
            die("System PSR-4 error: File $path is not found."); 
        }

    });



?>