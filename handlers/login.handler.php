<?php
require_once "handlers/database.handler.php";

session_start();
$inputs = [];
$errors = [];

if (isset($_SESSION['loggedInUser'])) {
    header("Location: ?page=home");
    exit();
}

if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['login'])) {
    foreach ($_POST as $key => $value) {
        if (is_string($value)) {
            if (empty(trim($value))) {
                $errors[$key] = ucfirst($key) . " is required!";
            } else {
                $inputs[$key] = trim($value);
            }
        }
    }

    if (isset($inputs['email']) && isset($inputs['password'])) {
        $auth = authUser($inputs['email'], $inputs['password']);
        if ($auth) {
            $_SESSION['loggedInUser'] = $auth;
            header("Location: ?page=home");
            exit();
        } else {
            $errors['invalid'] = 'Email or password are invalid';
        }
    }
}
