<?php
/**
 *
 * Author Name: Samantha Gabriel
 * Date: January 18, 2019
 * File Name: index.php
 *
 * Setting up Fat-Free and URL Routing
 *
 * https://www.w3schools.com/php/php_arrays_sort.asp
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
$f3->route('GET|POST /personal-information',

    function($f3){

    if (isset($_POST['submit'])) {

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

            $_SESSION['gender'] = $_POST['gender'];
            $_SESSION['phone'] = $_POST['phone'];
            $f3->reroute('/profile');
        }
    }

    $template = new Template();
    echo $template->render('views/personal-information.html');
});

//define a profile route
$f3->route('GET|POST /profile',

    function($f3){

    $f3->set('states', array("Washington" => "WASHINGTON", "Oregon" => "OREGON", "California" => "CALIFORNIA", 'Alabama' => 'ALABAMA',
        "Nevada"=>"NEVADA", "Idaho"=>"IDAHO", "Utah"=>"UTAH",
        "Arizona"=>"ARIZONA", "Alaska"=>"ALASKA", "Hawaii"=>"HAWAII", "Montana"=>"MONTANA",
        "Wyoming"=>"WYOMING", "Colorado"=>"COLORADO", "New Mexico"=>"NEW MEXICO",
        "North Dakota"=>"NORTH DAKOTA", "South Dakota"=>"SOUTH DAKOTA", "Nebraska"=>"NEBRASKA",
        "Kansas"=>"KANSAS", "Oklahoma"=>"OKLAHOMA", "Texas"=>"TEXAS", "Minnesota"=>"MINNESOTA",
        "Iowa"=>"IOWA", "Missouri"=>"MISSOURI", "Arkansas"=>"ARKANSAS", "Louisiana"=>"LOUISIANA",
        "Wisconsin"=>"WISCONSIN", "Illinois"=>"ILLINOIS", "Mississippi"=>"MISSISSIPPI",
        "Michigan"=>"MICHIGAN", "Indiana"=>"INDIANA", "Kentucky"=>"KENTUCKY",
        "Tennessee"=>"TENNESSEE", "Ohio"=>"OHIO", "West Virginia"=>"WEST VIRGINIA",
        "Virginia"=>"VIRGINIA", "North Carolina"=>"NORTH CAROLINA", "South Carolina"=>"SOUTH CAROLINA",
        "Georgia"=>"GEORGIA", "Florida"=>"FLORIDA", "Maine"=>"MAINE", "New Hampshire"=>"NEW HAMPSHIRE",
        "Vermont"=>"VERMONT", "Massachusetts"=>"MASSACHUSETTS", "New York"=>"NEW YORK",
        "Pennsylvania"=>"PENNSYLVANIA", "Rhode Island"=>"RHODE ISLAND", "Connecticut"=>"CONNECTICUT",
        "New Jersey"=>"NEW JERSEY", "Delaware"=>"DELAWARE", "Maryland"=>"MARYLAND",
        "Washington DC"=>"WASHINGTON D.C."));

    if (isset($_POST['submit'])) {

        $_SESSION['email'] = $_POST['email'];
        $_SESSION['state'] = $_POST['state'];
        $_SESSION['seeking'] = $_POST['seeking'];
        $_SESSION['bio'] = $_POST['bio'];
        $f3->reroute('/interests');
    }

    $template = new Template();
    echo $template->render('views/profile.html');
});

//define an interests route
$f3->route('GET|POST /interests',

    function($f3){


        $indoor = array("tv", "puzzles", "movies", "reading",
            "cooking", "playing cards", "board games",
            "video games");

        $outdoor = array("hiking", "walking", "biking", "climbing",
            "swimming", "collecting");

        $f3->set('indoor', $indoor);

        $f3->set('outdoor', $outdoor);

        $outdoorHobbies = $_POST['outdoor'];
        $indoorHobbies = $_POST['indoor'];
        $hobby = null;
        $activity = null;
        $activities = [];

        if (isset($_POST['submit'])) {

            if (isset($_POST['indoor'])) {


                foreach ($indoorHobbies as $hobby) {

                    if (validIndoor($hobby)) {

                        array_push($activities, $hobby);


                    } else {

                        $f3->set("errors['indoor']", "Please pick a valid indoor activity.");
                    }
                }
            }

            if (isset($_POST['outdoor'])) {

                foreach ($outdoorHobbies as $activity) {

                    if (validOutdoor($activity)) {

                        array_push($activities, $activity);


                    } else {

                        $f3->set("errors['outdoor']", "Please pick a valid outdoor activity.");
                    }
                }
            }

            if (validIndoor($hobby) && validOutdoor($activity)) {

                $activities = implode(" ", $activities);
                $_SESSION['interests'] = $activities;
                $f3->reroute('/summary');
            }
        }

    $template = new Template();
    echo $template->render('views/interests.html');
});

//define a summary route
$f3->route('GET|POST /summary', function(){

    $template = new Template();
    echo $template->render('views/summary.html');
});

//run fat free
$f3->run();