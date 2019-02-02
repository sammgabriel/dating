<?php
/**
 * Created by PhpStorm.
 * User: sammgabriel
 * Date: 2019-01-31
 * Time: 17:14
 *
 * http://php.net/manual/en/function.ctype-alpha.php
 * Shared ideas with Ean
 */

/**
 * @param $name
 * @return bool
 */
function validName($name) {

    return ctype_alpha($name);
}

/**
 * @param $age
 * @return bool
 */
function validAge($age) {

    return (is_numeric($age) && $age > 18);
}

/**
 *
 * Shared ideas with Ean
 *
 * @param $phone
 * @return bool
 *
 */
function validPhone($phone) {

    return (is_numeric($phone) && (strlen($phone) == 10));
}

function validIndoor($indoorActivity) {

    global $f3;
    return in_array($indoorActivity, $f3->get('indoor'));
}

function validOutdoor($outdoorActivity) {

    global $f3;
    return in_array($outdoorActivity, $f3->get('outdoor'));
}