<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * @author bane
 */
date_default_timezone_set('Europe/Belgrade');

// TODO: check include path
ini_set('include_path',ini_get('include_path').':/var/www/cargo-media');
//
//// put your code here
function autoloader($className) {
    /*** do logic to set path of file for the class ***/
    //$classPath = "/var/www/cargo-media/" . $className.".php";
    require_once($className.".php");
}

spl_autoload_register('autoloader');
?>
