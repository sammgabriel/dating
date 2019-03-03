<?php
/*
 *
 * Author Name: Samantha Gabriel
 * Date: March 2, 2019
 * File Name: database.php
 *
 * Database functionality of the dating website
 *
 * References:
 *
 * https://www.w3schools.com/sql/sql_create_table.asp
 *
 *
 */

require("/home/sgabriel/config.php");

/*
    CREATE TABLE statement

    Referred to w3schools regarding the syntax of this statement

    CREATE TABLE members (

        member_id int AUTO_INCREMENT NOT NULL PRIMARY KEY,
        fname VARCHAR(30) NOT NULL,
        lname VARCHAR(30) NOT NULL,
        age int(11) NOT NULL,
        gender VARCHAR(9),
        phone VARCHAR(10),
        email VARCHAR (40),
        state VARCHAR(30),
        seeking VARCHAR(9),
        bio VARCHAR(255),
        premium TINYINT,
        image VARCHAR(10),
        interests VARCHAR(80)
    );
*/

/**
 *
 * Connect to database
 *
 * @return PDO|void PDO object
 *
 */
function connect()
{

    try {

        // Instantiate a database object
        $dbh = new PDO(DB_DSN, DB_USERNAME,
            DB_PASSWORD);
        //echo "Connected to database!!!";
        return $dbh;

    } catch (PDOException $e) {

        // Otherwise throw an exception
        echo $e->getMessage();
        return;
    }
}

/**
 *
 * Get all registered members of the website
 *
 * @return array array of rows from the database
 *
 */
function getMembers()
{

    global $dbh;

    // Define the query
    $sql = "SELECT * FROM members ORDER BY lname, fname";

    // Prepare the statement
    $statement = $dbh->prepare($sql);

    // Execute the statement
    $statement->execute();

    // Return the result
    $result = $statement->fetchAll(PDO::FETCH_ASSOC);

    return $result;
}

/**
 *
 * Add a newly registered member to the database
 *
 * @param $fname
 * @param $lname
 * @param $age
 * @param $gender
 * @param $phone
 * @param $email
 * @param $state
 * @param $seeking
 * @param $bio
 * @param $premium
 * @param $image
 * @param $interests
 * @return bool
 *
 */
function insertMember($fname, $lname, $age, $gender, $phone, $email,
            $state, $seeking, $bio, $premium, $image, $interests)
{

    global $dbh;

    // Define the query
    $sql = "INSERT INTO members (fname, lname, age, gender, phone, email, state, seeking, 
            bio, premium, image, interests) VALUES (:first, :last, :age, :gender, :phone, 
            :email, :state, :seeking, :bio, :premium, :image, :interests)";

    // Prepare the statement
    $statement = $dbh->prepare($sql);

    // Bind parameters
    $statement->bindParam(':first', $fname, PDO::PARAM_STR);
    $statement->bindParam(':last', $lname, PDO::PARAM_STR);
    $statement->bindParam(':age', $age, PDO::PARAM_STR);
    $statement->bindParam(':gender', $gender, PDO::PARAM_STR);
    $statement->bindParam(':phone', $phone, PDO::PARAM_STR);
    $statement->bindParam(':email', $email, PDO::PARAM_STR);
    $statement->bindParam(':state', $state, PDO::PARAM_STR);
    $statement->bindParam(':seeking', $seeking, PDO::PARAM_STR);
    $statement->bindParam(':bio', $bio, PDO::PARAM_STR);
    $statement->bindParam(':premium', $premium, PDO::PARAM_STR);
    $statement->bindParam(':image', $image, PDO::PARAM_STR);
    $statement->bindParam(':interests', $interests, PDO::PARAM_STR);

    // Execute the statement
    $success = $statement->execute();

    // Return the result
    return $success;
}

/**
 *
 * Get a specific member from the database
 *
 * @param $id
 * @return mixed
 *
 */
function getMember($id)
{

    global $dbh;

    // Define query
    $sql = "SELECT * FROM members WHERE member_id = :id";

    // Prepare statement
    $statement = $dbh->prepare($sql);

    // Bind parameters
    $statement->bindParam(':id', $id, PDO::PARAM_STR);

    // Execute
    $statement->execute();

    // Process the result
    $row = $statement->fetch(PDO::FETCH_ASSOC);

    return $row;
}