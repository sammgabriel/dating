<?php
/**
 * Author Name: Samantha Gabriel
 * Date: February 16, 2019
 */

class Member {

    private $_fname;
    private $_lname;
    private $_age;
    private $_gender;
    private $_phone;
    private $_email;
    private $_state;
    private $_seeking;
    private $_bio;

    function __construct($fname, $lname, $age, $gender, $phone) {

        $this->_fname = $fname;
        $this->_lname = $lname;
        $this->_age = $age;
        $this->_gender = $gender;
        $this->_phone = $phone;
    }

    function getFirstName() {

        return $this->_fname;
    }

    function setFirstName($fname) {

        $this->_fname = $fname;
    }

    function getLastName() {

        return $this->_lname;
    }

    function setLastName($lname) {

        $this->_lname = $lname;
    }

    function getAge() {

        return $this->_age;
    }

    function setAge($age) {

        $this->_age = $age;
    }

    function getLastName() {

        return $this->_lname;
    }

    function setLastName($lname) {

        $this->_lname = $lname;
    }

}