<?php
require_once "handlers/database.handler.php";
session_start();
// * Redirect unauthenticated users to login page
if (!isset($_SESSION["loggedInUser"])) {
    header("Location: ?page=login");
}
// * Logout 
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['logout'])) {
    session_destroy();
    header("Location: ?page=login");
}
