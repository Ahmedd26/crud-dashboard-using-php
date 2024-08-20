<?php

require_once "controllers/Auth.controller.php";
require_once "controllers/User.controller.php";

session_start();

$whitelistedPages = ["register", "login", "home"];

if (isset($_GET['page'])) {
    $page = $_GET['page'];
    if (in_array($page, $whitelistedPages)) {
        switch ($page) {
            case "register":
                if (isset($_SESSION['loggedInUser'])) {
                    header("Location: ?page=home");
                } else {
                    require_once "views/register.view.php";
                }
                break;
            case "login":
                if (isset($_SESSION['loggedInUser'])) {
                    header("Location: ?page=home");
                } else {
                    require_once "views/login.view.php";
                }
                break;
            case "home":
                if (!isset($_SESSION['loggedInUser'])) {
                    header('Location: ?page=login');
                } else {
                    require_once "views/home.view.php";
                }
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
    echo "<h1>Page not found. RR</h1><a href='index.php'>Home</a>";
    exit();
}



// require_once "controllers/Auth.controller.php";
// require_once "controllers/User.controller.php";

// session_start();

// $whitelistedPages = ["register", "login", "home"];

// if (isset($_GET['page'])) {
//     $page = filter_var($_GET['page'], FILTER_SANITIZE_STRING);

//     // If the page is whitelisted
//     if (in_array($page, $whitelistedPages)) {

//         // Redirect to home if already logged in
//         if (in_array($page, ["register", "login"]) && isset($_SESSION['loggedInUser'])) {
//             header("Location: ?page=home");
//             exit();
//         }

//         // Redirect to login if not logged in and trying to access home
//         if ($page === "home" && !isset($_SESSION['loggedInUser'])) {
//             header('Location: ?page=login');
//             exit();
//         }

//         // Include the view for the requested page
//         require_once "views/{$page}.view.php";

//     } else {
//         // Page not found error handling
//         echo "<h1>Page not found.</h1><a href='index.php'>Home</a>";
//     }
// } else {
//     // Default redirect to login if no page is set
//     header("Location: ?page=login");
//     exit();
// }

