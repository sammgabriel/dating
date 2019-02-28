<?php
/**
 * Created by PhpStorm.
 * User: sammgabriel
 * Date: 2019-02-28
 * Time: 12:47
 */

require("/home/sgabriel/config.php");

function connect() {

    try {

        //Instantiate a database object
        $dbh = new PDO(DB_DSN, DB_USERNAME,
            DB_PASSWORD);
        //echo "Connected to database!!!";
        return $dbh;

    } catch (PDOException $e) {

        echo $e->getMessage();
        return;
    }
}

function getMembers() {

}

function insertMember() {


}

function getMember($id) {


}