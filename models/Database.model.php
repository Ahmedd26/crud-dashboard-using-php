<?php


class Database
{
    private $dbname = 'dashboard_app';
    private $hostname = '127.0.0.1';
    private $port = '3306';
    private $username = 'root';
    private $password = '';

    public static function connectToDB()
    {
        try {
            $db = new PDO("mysql:dbname=dashboard_app;host=127.0.0.1;port=3306;", 'root', '');
            return $db;
        } catch (PDOException $e) {
            error_log('Connection failed: ' . $e->getMessage());
            echo 'Connection failed: ' . $e->getMessage();
            return null;
        }
    }


    public static function getAllUsers()
    {
        $query = "SELECT id, full_name, email, profile_picture FROM users;";
        $db = self::connectToDB();
        $stmt = $db->prepare($query);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
    public static function getEmails()
    {
        $query = "SELECT email FROM users;";
        $db = self::connectToDB();
        $stmt = $db->prepare($query);
        $stmt->execute();
        // var_dump($stmt->fetchAll(PDO::FETCH_ASSOC));
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public static function getSingleUser($id)
    {
        $query = "SELECT id, full_name, email, profile_picture FROM users WHERE id = ?;";
        $db = self::connectToDB();

        $stmt = $db->prepare($query);
        $stmt->execute([$id]);
        $result = $stmt->fetchAll(PDO::FETCH_ASSOC);
        return $result[0] ?? null;
    }

    public static function authUser($email, $password)
    {
        $query = "SELECT id, email, password FROM users WHERE email = ?;";
        $db = self::connectToDB();
        $stmt = $db->prepare($query);
        $stmt->execute([$email]);
        $result = $stmt->fetch(PDO::FETCH_ASSOC);

        if ($result && password_verify($password, $result['password'])) {
            return self::getSingleUser($result['id']);
        } else {
            return false;
        }
    }

    public static function registerUser($fullName, $email, $password, $profilePicture)
    {
        try {
            $hashedPassword = password_hash($password, PASSWORD_BCRYPT);

            $query = "INSERT INTO users (full_name, email, password, profile_picture) VALUES (?, ?, ?, ?);";
            $db = self::connectToDB();
            $stmt = $db->prepare($query);
            $stmt->execute([$fullName, $email, $hashedPassword, $profilePicture]);

            $id = $db->lastInsertId();
            return self::getSingleUser($id);
        } catch (PDOException $e) {
            if ($e->getCode() == 23000 && $e->errorInfo[1] == 1062) {
                return 'email_exists';
            } else {
                return 'db_error';
            }
        }
    }

    public static function deleteUserFromDB($userId)
    {
        try {
            $query = "DELETE FROM users WHERE id = ?;";
            $db = self::connectToDB();

            $stmt = $db->prepare($query);
            $stmt->execute([$userId]);
            return true;
        } catch (PDOException $e) {
            return $e->getMessage();
        }
    }

    public static function updateUserInDB($id, $fullName = "", $profilePicture = "", $password = "")
    {
        try {
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
                $db = self::connectToDB();
                $stmt = $db->prepare($sql);
                $stmt->execute($params);
            }

            return self::getSingleUser($id);
        } catch (PDOException $e) {
            return $e->getMessage();
        }
    }
}