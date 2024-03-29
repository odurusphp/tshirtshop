<?php

// Including the configuration file
require_once 'config/config.php';
require_once 'config/config_env.php';

// Load everything we require via composer
require('../vendor/autoload.php');

/*
 * Autoload Core Libraries
 *
 * Note: We are not using namespaces, so this will
 * blow up in our faces if we have any duplicate class
 * names! TODO: consider using namespaces!
 */
spl_autoload_register(function($class){

    $pathContorllers = APPROOT . '/controllers/' . $class . '.php';
    $pathLibs = APPROOT . '/libraries/' . $class . '.php';
    $pathModels = APPROOT . '/models/' . $class . '.php';
    $pathServices = APPROOT . '/service/' . $class . '.php';

    if (file_exists($pathContorllers)) {
        require_once $pathContorllers;
    } elseif (file_exists($pathLibs)) {
        require_once $pathLibs;
    } elseif (file_exists($pathModels )) {
        require_once $pathModels ;
    } elseif (file_exists($pathServices )) {
        require_once $pathServices ;

    }

});

/**
 * We are always going to need the database, so we are going to
 * create our database object here. It can then be referenced
 * in class member functions as "global $connectedDb"
 */

$connectedDb = new Database();
//$client = new Google_Client();

// provide a catch all exception handler...
/**
 * @param $exception
 */
function pokemon($exception){
    $errordata = [
        'exceptiondata' => $exception,
        'errormessage' => $exception->getMessage()
    ];

    $errordisplaycontroller = new Controller();
    $errordisplaycontroller->view("pages/errorpage", $errordata);

    exit();
}

// Gotta catch 'em all!
set_exception_handler('pokemon');

// We also always need the session object, and need to create it before any output.
session_start();

?>
