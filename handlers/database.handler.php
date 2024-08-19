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

    $query = "SELECT id, full_name, email, profile_picture FROM users;";
    $stmt = $db->prepare($query);
    $stmt->execute();
    $result = $stmt->fetchAll(PDO::FETCH_ASSOC);
    return $result;
}
function getSingleUser($id)
{
    $db = connectToDB('dashboard_app', '127.0.0.1', '3306', 'root', '');
    $query = "SELECT id, full_name, email, profile_picture FROM users WHERE id = ?;";
    $stmt = $db->prepare($query);
    $stmt->execute([$id]);
    $result = $stmt->fetchAll(PDO::FETCH_ASSOC);
    return $result[0];
}

function authUser($email, $password)
{
    $db = connectToDB('dashboard_app', '127.0.0.1', '3306', 'root', '');
    $query = "SELECT id, email, password FROM users WHERE email = ?;";
    $stmt = $db->prepare($query);
    $stmt->execute([$email]);
    $result = $stmt->fetch(PDO::FETCH_ASSOC);

    if ($result && password_verify($password, $result['password'])) {
        $authUser = getSingleUser($result['id']);
        return $authUser;
    } else {
        return false;
    }
}

function registerUser($fullName, $email, $password, $profilePicture)
{
    try {
        $db = connectToDB('dashboard_app', '127.0.0.1', '3306', 'root', '');

        $hashedPassword = password_hash($password, PASSWORD_BCRYPT);

        $query = "INSERT INTO users (full_name, email, password, profile_picture) VALUES (?, ?, ?, ?);";
        $stmt = $db->prepare($query);
        $stmt->execute([$fullName, $email, $hashedPassword, $profilePicture]);

        $id = $db->lastInsertId();
        return getSingleUser($id);

    } catch (PDOException $e) {
        // echo "<pre class='text-2xl text-white'>";
        // print_r($e->errorInfo[0] === 23000 ? 'false' : 'true');
        // echo ($e->getCode() == 23000 ? 'true' : 'false');
        // echo ($e->errorInfo[1] == 1062 ? 'true' : 'false');
        // echo "</pre>";
        // Handle duplicate email error
        if ($e->getCode() == 23000 && $e->errorInfo[1] == 1062) {
            return 'email_exists';
        } else {
            // Handle any other database-related error
            return 'db_error';
        }
    }
}
