<?php
/**
 *
 * Author Name: Samantha Gabriel
 * Date: January 18, 2019
 * File Name: index.php
 *
 * Setting up Fat-Free and URL Routing
 *
 * https://www.w3schools.com/php/func_string_implode.asp
 * https://www.w3schools.com/php/php_ref_array.asp
 * https://stackoverflow.com/questions/21565164/format-phone-number-in-php
 *
 */

//TODO make fields sticky

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

    $f3->set('gender', array("Male", "Female"));

    if (isset($_POST['submit'])) {

        $firstName = $_POST['fname'];
        $lastName = $_POST['lname'];
        $age = $_POST['age'];
        $phone = $_POST['phone'];
        $gender = $_POST['gender'];
        $_SESSION['gender'] = $gender;

        $f3->set('genderChoice', $_POST['gender']);


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

        if (isset($_POST['phone'])) {


            if (validPhone($phone)) {

                $_SESSION['phone'] = $phone;

            } else {

                $f3->set("errors['phone']", "Please enter a valid phone number with 
                    no characters (i.e. 5551234567).");
            }
        }

        if (validName($firstName) && validName($lastName) && validAge($age) && validPhone($phone)) {

            $f3->reroute('/profile');
        }

    }

    $template = new Template();
    echo $template->render('views/personal-information.html');
});

//define a profile route
$f3->route('GET|POST /profile',

    function($f3){

    $f3->set('seeking', array("Male", "Female"));
    $f3->set('seekingChoice', $_POST['seeking']);

    $f3->set('states', array(

        'Alabama' => 'ALABAMA',
        "Alaska"=>"ALASKA",
        "Arizona"=>"ARIZONA",
        "Arkansas"=>"ARKANSAS",
        "California" => "CALIFORNIA",
        "Colorado"=>"COLORADO",
        "Connecticut"=>"CONNECTICUT",
        "Delaware"=>"DELAWARE",
        "Washington DC"=>"DISTRICT OF COLUMBIA",
        "Florida"=>"FLORIDA",
        "Georgia"=>"GEORGIA",
        "Hawaii"=>"HAWAII",
        "Idaho"=>"IDAHO",
        "Illinois"=>"ILLINOIS",
        "Indiana"=>"INDIANA",
        "Iowa"=>"IOWA",
        "Kansas"=>"KANSAS",
        "Kentucky"=>"KENTUCKY",
        "Louisiana"=>"LOUISIANA",
        "Maine"=>"MAINE",
        "Maryland"=>"MARYLAND",
        "Massachusetts"=>"MASSACHUSETTS",
        "Michigan"=>"MICHIGAN",
        "Minnesota"=>"MINNESOTA",
        "Mississippi"=>"MISSISSIPPI",
        "Missouri"=>"MISSOURI",
        "Montana"=>"MONTANA",
        "Nebraska"=>"NEBRASKA",
        "Nevada"=>"NEVADA",
        "New Hampshire"=>"NEW HAMPSHIRE",
        "New Jersey"=>"NEW JERSEY",
        "New Mexico"=>"NEW MEXICO",
        "New York"=>"NEW YORK",
        "North Carolina"=>"NORTH CAROLINA",
        "North Dakota"=>"NORTH DAKOTA",
        "Ohio"=>"OHIO",
        "Oklahoma"=>"OKLAHOMA",
        "Oregon" => "OREGON",
        "Pennsylvania"=>"PENNSYLVANIA",
        "Rhode Island"=>"RHODE ISLAND",
        "South Carolina"=>"SOUTH CAROLINA",
        "South Dakota"=>"SOUTH DAKOTA",
        "Tennessee"=>"TENNESSEE",
        "Texas"=>"TEXAS",
        "Utah"=>"UTAH",
        "Vermont"=>"VERMONT",
        "Virginia"=>"VIRGINIA",
        "Washington" => "WASHINGTON",
        "West Virginia"=>"WEST VIRGINIA",
        "Wisconsin"=>"WISCONSIN",
        "Wyoming"=>"WYOMING",
    ));

    $f3->set('stateChoice', $_POST['state']);

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
        $f3->set('indoorHobbies', $indoorHobbies);
        $f3->set('outdoorHobbies', $outdoorHobbies);
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

            if (!isset($_POST['indoor']) && !isset($_POST['outdoor'])) {

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