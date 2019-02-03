<?php
/**
 *
 * Author Name: Samantha Gabriel
 * Date: February 2, 2019
 * File Name: validation-functions.php
 *
 * References:
 *
 * http://php.net/manual/en/function.ctype-alpha.php
 * Shared ideas with Ean
 *
 */

/**
 *
 * Validates name
 * Checks if the entry is alphabetic
 *
 * Referred to the PHP documentation to determine how to validate
 * if an entry is alphabetic
 *
 * @param $name
 * @return bool
 *
 */
function validName($name) {

    return ctype_alpha($name);
}

/**
 *
 * Validates age
 * Checks if the entry is numeric and over 18
 *
 * @param $age
 * @return bool
 *
 */
function validAge($age) {

    return (is_numeric($age) && $age > 18);
}

/**
 *
 * Validates phone number
 *
 * Shared ideas with Ean regarding how to accomplish this
 *
 * @param $phone
 * @return bool
 *
 */
function validPhone($phone) {

    return (is_numeric($phone) && (strlen($phone) == 10));
}

/**
 *
 * Validates indoor interests options
 * Checks for spoofing
 *
 * @param $indoorActivity
 * @return bool
 *
 */
function validIndoor($indoorActivity) {

    global $f3;
    return in_array($indoorActivity, $f3->get('indoor'));
}

/**
 *
 * Validates indoor interests options
 * Checks for spoofing
 *
 * @param $outdoorActivity
 * @return bool
 *
 */
function validOutdoor($outdoorActivity) {

    global $f3;
    return in_array($outdoorActivity, $f3->get('outdoor'));
}