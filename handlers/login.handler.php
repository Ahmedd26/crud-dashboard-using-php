<?php
require_once "handlers/database.handler.php";

session_start();

if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['login'])) {
    $email = $_POST['email'];
    $password = $_POST['password'];
    $auth = authUser($email, $password);
    if ($auth) {
        $_SESSION['loggedInUser'] = $auth;
        header("Location: ?page=home");
    } else {
        return $error = "Invalid login";
    }
}
