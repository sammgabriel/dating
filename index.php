<?php
/**
 *
 * Author Name: Samantha Gabriel
 * Date: January 18, 2019
 * File Name: index.php
 *
 * Setting up Fat-Free and URL Routing
 *
 * References:
 *
 * Shared ideas with Jake
 * https://gist.github.com/maxrice/2776900
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

    // Sets radio button options array
    $f3->set('gender', array("Male", "Female"));

    // When the user clicks the submit button
    if (isset($_POST['submit'])) {

        // Post variables
        $firstName = $_POST['fname'];
        $lastName = $_POST['lname'];
        $age = $_POST['age'];
        $phone = $_POST['phone'];
        $gender = $_POST['gender'];

        // Session variable for gender
        $_SESSION['gender'] = $gender;

        // Variable used to check which gender option was selected
        $f3->set('genderChoice', $_POST['gender']);

        // Checks if a first name was entered
        if (isset($_POST['fname'])) {

            // validates first name
            if (validName($firstName)) {

                // creates a session variable if entry is valid
                $_SESSION['fname'] = $firstName;

            } else {

                // otherwise, displays an error
                $f3->set("errors['fname']", "Please enter a valid first name");
            }
        }

        // Checks if a last name was entered
        if (isset($_POST['lname'])) {

            // validates last name
            if (validName($lastName)) {

                // creates a session variable if entry is valid
                $_SESSION['lname'] = $lastName;

            } else {

                // otherwise, displays an error
                $f3->set("errors['lname']", "Please enter a last name");
            }
        }

        // Checks if an age was entered
        if (isset($_POST['age'])) {

            // validates age
            if (validAge($age)) {

                // creates a session variable if entry is valid
                $_SESSION['age'] = $age;

            } else {

                // otherwise, displays an error
                $f3->set("errors['age']", "Please enter a valid age (Note: You must be 18 years old or older to use this website.)");
            }
        }

        // Checks if a phone number was entered
        if (isset($_POST['phone'])) {

            // validates phone number
            if (validPhone($phone)) {

                // creates a session variable if entry is valid
                $_SESSION['phone'] = $phone;

            } else {

                // otherwise, displays an error
                $f3->set("errors['phone']", "Please enter a valid phone number.");
            }
        }

        // Redirects the user to the next page if all entries are valid
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

    // variables for displaying the "seeking" options and
    // checking which one has been chosen
    $f3->set('seeking', array("Male", "Female"));
    $f3->set('seekingChoice', $_POST['seeking']);

    // array of states
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

    // variable used to check which state was chosen
    $f3->set('stateChoice', $_POST['state']);

    // Creates new session variables and redirects
    // the user to the next page when he or she clicks
    // the next button
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

        // session variables
        $_SESSION['indoor'] = array();
        $_SESSION['outdoor'] = array();

        // arrays
        $indoor = array("tv", "puzzles", "movies", "reading",
            "cooking", "playing cards", "board games",
            "video games");

        $outdoor = array("hiking", "walking", "biking", "climbing",
            "swimming", "collecting");

        // variables
        $f3->set('indoor', $indoor);
        $f3->set('outdoor', $outdoor);

        // post variables
        $outdoorHobbies = $_POST['outdoor'];
        $indoorHobbies = $_POST['indoor'];

        // variables
        $hobby = "";
        $activity = "";

        // when the user submits the form
        if (isset($_POST['submit'])) {

            // if the user picks indoor interests
            if (isset($_POST['indoor'])) {

                // validates the user's choices
                foreach ($indoorHobbies as $hobby) {

                    if (validIndoor($hobby)) {

                        $_SESSION['indoor'] = $_POST['indoor'];
                        //array_push($_SESSION['indoor'], $hobby);

                    } else {

                        // Otherwise, displays an error
                        $f3->set("errors['indoor']", "Please pick a valid indoor activity.");
                    }
                }

            }

            // if the user picks outdoor interests
            if (isset($_POST['outdoor'])) {

                // validates the user's choices
                foreach ($outdoorHobbies as $activity) {

                    if (validOutdoor($activity)) {

                        $_SESSION['outdoor'] = $_POST['outdoor'];
                        //array_push($_SESSION['outdoor'], $hobby);

                    } else {

                        // Otherwise, displays an error
                        $f3->set("errors['outdoor']", "Please pick a valid outdoor activity.");
                    }
                }

            }

            // if all entries are valid, redirect the user to the next page
            if (validIndoor($hobby) && validOutdoor($activity)) {

                $f3->reroute('/summary');
            }

            // if no interests were selected redirect the user to the next page
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