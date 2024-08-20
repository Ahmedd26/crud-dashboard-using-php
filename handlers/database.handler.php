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
//* DATA BASE AS A GLOBAL VARIABLE
//* Closing connection might make conflict
//* make sure to close DB connection after each DB request
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

function deleteUserFromDB($userId)
{
    try {
        $db = connectToDB('dashboard_app', '127.0.0.1', '3306', 'root', '');

        $query = "DELETE FROM users WHERE id = ?;";
        $stmt = $db->prepare($query);
        $stmt->execute([$userId]);
        return true;
    } catch (PDOException $e) {
        return $e->getMessage();
    }
}

// UPDATE
function updateUserInDB($id, $fullName = "", $profilePicture = "", $password = "")
{
    try {
        $db = connectToDB('dashboard_app', '127.0.0.1', '3306', 'root', '');

        $fieldsToUpdate = [];
        $params = [':id' => $id];

        if (!empty($fullName)) {
            $fieldsToUpdate[] = "full_name = :full_name";
            $params[':full_name'] = $fullName;
        }

        if (!empty($profilePicture)) {
            $fieldsToUpdate[] = "profile_picture = :profile_picture";
            $params[':profile_picture'] = $profilePicture;
        }

        if (!empty($password)) {
            $fieldsToUpdate[] = "password = :password";
            $params[':password'] = password_hash($password, PASSWORD_BCRYPT);
        }

        if (!empty($fieldsToUpdate)) {
            $sql = "UPDATE users SET " . implode(", ", $fieldsToUpdate) . " WHERE id = :id";
            $stmt = $db->prepare($sql);
            $stmt->execute($params);
        }

        return getSingleUser($id);
    } catch (PDOException $e) {
        return $e->getMessage();
    }
}

/*
UPDATE table_name
SET column1 = value1, column2 = value2, ...
WHERE condition;
*/
/*
    function updateUserByEmail($email, $name = "", $image = "", $password = "")
    {
        global $dbh;
        if (isset($name) && strlen(trim($name)) > 0) {
            $statement = $dbh->prepare("update users set name = :name where email = :email");
            $statement->bindParam(':name', $name);
            $statement->bindParam(':email', $email);
            $statement->execute();
        }
        if (isset($image) && strlen(trim($image)) > 0) {
            $statement = $dbh->prepare("update users set image = :image where email = :email");
            $statement->bindParam(':image', $image);
            $statement->bindParam(':email', $email);
            $statement->execute();
        }

        if (isset($password) && strlen(trim($password)) > 0) {
            $statement = $dbh->prepare("update users set password = :password where email = :email");
            $statement->bindParam(':password', $password);
            $statement->bindParam(':email', $email);
            $statement->execute();
        }
        return getUserByEmail($email);
    }

    function updateUserInDB($id, $name = "", $image = "", $password = "")
    {
        global $dbh;
        if (isset($name) && strlen(trim($name)) > 0) {
            $statement = $dbh->prepare("update users set name = :name where id = :id");
            $statement->bindParam(':name', $name);
            $statement->bindParam(':id', $id);
            $statement->execute();
        }
        if (isset($image) && strlen(trim($image)) > 0) {
            $statement = $dbh->prepare("update users set image = :image where id = :id");
            $statement->bindParam(':image', $image);
            $statement->bindParam(':id', $id);
            $statement->execute();
        }

        if (isset($password) && strlen(trim($password)) > 0) {
            $statement = $dbh->prepare("update users set password = :password where id = :id");
            $statement->bindParam(':password', $password);
            $statement->bindParam(':id', $id);
            $statement->execute();
        }
        return getUserById($id);
    }
*/