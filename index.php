<?php
$whitelistedPages = ["register", "login"];

if ($_SERVER["REQUEST_METHOD"] == "GET" && isset($_GET['page'])) {
    $page = $_GET['page'];

    if (in_array($page, $whitelistedPages)) {
        switch ($page) {
            case "register":
                require_once "views/register.view.php";
                break;
            case "login":
                require_once "views/login.view.php";
                break;
            default:
                echo "<h1>Page not found.</h1><a href='index.php'>Home</a>";
                break;
        }
    } else {
        echo "<h1>Page not found.</h1><a href='index.php'>Home</a>";
    }
} else {
    header("Location: index.php?page=login");
    exit();
}

// Check if the user is logged in, if true we make the default redirect to the dashboard page, if not we redirect him to the login page
/* TODO
function isLoggedIn()
{
    // Assuming you have a session variable to store the user's login status
    if (isset($_SESSION['logged_in']) && $_SESSION['logged_in'] === true) {
        header('Location: dashboard.php');
        exit;k
    } else {
        header('Location: login.php');
        exit;
    }
}
*/