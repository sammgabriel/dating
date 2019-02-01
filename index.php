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

//require form validation
require_once('model/validation-functions.php');

session_start();

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
$f3->route('GET|POST /personal-information', function($f3){

    $_SESSION = array();

    $firstName = $_POST['fname'];
    $lastName = $_POST['lname'];
    $age = $_POST['age'];

    if (isset($_POST['fname'])) {


        if (validName($firstName)) {

            $_SESSION['fname'] = $firstName;

        } else {

            $f3->set("errors['fname']", "Please enter a first name");


        }
    }

    if (isset($_POST['lname'])) {


        if (validName($lastName)) {

            $_SESSION['lname'] = $lastName;


        } else {

            $f3->set("errors['lname']", "Please enter a last name");
        }
    }

    if (isset($_POST['age'])) {


        if (validAge($age)) {

            $_SESSION['age'] = $age;


        } else {

            $f3->set("errors['age']", "Please enter a valid age (Note: You must be 18 years old or older to use this website.)");
        }

    }

    if (validName($firstName) && validName($lastName) && validAge($age)) {

        $f3->reroute('/profile');
    }

    $template = new Template();
    echo $template->render('views/personal-information.html');
});

//define a profile route
$f3->route('GET|POST /profile', function(){
    $template = new Template();
    echo $template->render('views/profile.html');
});

//define an interests route
$f3->route('POST /interests', function(){
    $template = new Template();
    echo $template->render('views/interests.html');
});

//define a summary route
$f3->route('POST /summary', function(){
    $template = new Template();
    echo $template->render('views/summary.html');
});

//run fat free
$f3->run();