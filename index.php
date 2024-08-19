<?php

$whitelistedPages = ["register", "login", "home"];

if (isset($_GET['page'])) {
    $page = $_GET['page'];
    // connectToDB('dashboard_app', '127.0.0.1', '3306', 'root', '');
    if (in_array($page, $whitelistedPages)) {
        switch ($page) {
            case "register":
                require_once "handlers/register.handler.php";
                require_once "views/register.view.php";
                break;
            case "login":
                require_once "handlers/login.handler.php";
                require_once "views/login.view.php";
                break;
            case "home":
                require "handlers/home.handler.php";
                require_once "views/home.view.php";
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

