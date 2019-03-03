<?php
/**
 * Created by PhpStorm.
 * User: sammgabriel
 * Date: 2019-02-28
 * Time: 12:47
 */

require("/home/sgabriel/config.php");

/*
    CREATE TABLE statement

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

function connect()
{

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

function getMembers()
{

    global $dbh;

    //1. define the query
    $sql = "SELECT * FROM members ORDER BY lname, fname";

    //2. prepare the statement
    $statement = $dbh->prepare($sql);

    //3. bind parameters

    //4. execute the statement
    $statement->execute();

    //5. return the result
    $result = $statement->fetchAll(PDO::FETCH_ASSOC);
    //print_r($result);
    return $result;

}

function insertMember($fname, $lname, $age, $gender, $phone, $email,
            $state, $seeking, $bio, $premium, $image, $interests)
{

    global $dbh;

    //1. define the query
    $sql = "INSERT INTO members (fname, lname, age, gender, phone, email, state, seeking, 
            bio, premium, image, interests) VALUES (:first, :last, :age, :gender, :phone, 
            :email, :state, :seeking, :bio, :premium, :image, :interests)";

    //2. prepare the statement
    $statement = $dbh->prepare($sql);

    //3. bind parameters
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

    //4. execute the statement
    $success = $statement->execute();

    //5. return the result
    return $success;
}

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