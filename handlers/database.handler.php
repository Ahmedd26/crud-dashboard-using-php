<?php

//* Establish DB Connection 

function connectToDB($dbname, $hostname, $port, $username, $password)
{
    try {
        $db = new PDO("mysql:dbname=$dbname;host=$hostname;port=$port;", $username, $password);
        // echo 'Connection successful!' . PHP_EOL;
        return $db;
    } catch (PDOException $e) {
        echo 'Connection failed: ' . $e->getMessage();
    }
}

function getAllUsers()
{
    $db = connectToDB('dashboard_app', '127.0.0.1', '3306', 'root', '');

    $query = "SELECT * FROM users;";
    $stmt = $db->prepare($query);
    $stmt->execute();
    $result = $stmt->fetchAll(PDO::FETCH_ASSOC);
    return $result;
}

function authUser($email, $password)
{
    $db = connectToDB('dashboard_app', '127.0.0.1', '3306', 'root', '');

    $query = "SELECT * FROM users WHERE email = ? AND password = ?;";
    $stmt = $db->prepare($query);
    $stmt->execute([$email, $password]);
    $result = $stmt->fetchAll(PDO::FETCH_ASSOC);
    return $result[0];
}



