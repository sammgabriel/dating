<?php
/**
 *
 * Author Name: Samantha Gabriel
 * Date: January 18, 2019
 * File Name: index.php
 *
 * Setting up Fat-Free and URL Routing
 *
 */

//turn on error reporting
ini_set('display_errors',1);
error_reporting(E_ALL);

//require autoload
require_once('vendor/autoload.php');

//create and instance of the Base class
$f3 = Base::instance();
//turn on fat free error reporting
$f3->set('DEBUG',3);

//define a default route
$f3->route('GET /', function(){
    $template = new Template();
    echo $template->render('views/home.html');
});

//define a personal information route
$f3->route('GET /personal-information', function(){
    $template = new Template();
    echo $template->render('views/personal-information.html');
});

//define a profile route
$f3->route('POST /profile', function(){
    $template = new Template();
    echo $template->render('views/profile.html');
});

//define a interests route
$f3->route('POST /interests', function(){
    $template = new Template();
    echo $template->render('views/interests.html');
});

//run fat free
$f3->run();