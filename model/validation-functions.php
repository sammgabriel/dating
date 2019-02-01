<?php
/**
 * Created by PhpStorm.
 * User: sammgabriel
 * Date: 2019-01-31
 * Time: 17:14
 *
 * http://php.net/manual/en/function.ctype-alpha.php
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


//function validPhone($phone) {


//}

//validIndoor

//validOutdoor