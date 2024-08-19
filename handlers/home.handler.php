<?php
require_once "handlers/database.handler.php";
session_start();

// * Redirect unauthenticated users to login page
if (!isset($_SESSION["loggedInUser"])) {
    header("Location: ?page=login");
}
// * FUNCTIONS

// * Logout 
function logout()
{
    unset($_SESSION["loggedInUser"]);
    session_destroy();
    header("Location: ?page=login");
    exit();
}
// * Delete User
function deleteUser($userId)
{
    $delete = deleteUserFromDB($userId);
    if ($delete) {
        header("Location: " . $_SERVER['PHP_SELF']);
        exit;
    } else {
        print_r($delete);
    }
}
function deleteSelf($userId)
{
    $delete = deleteUserFromDB($userId);
    if ($delete) {
        logout();
        exit();
    } else {
        print_r($delete);
    }
}

// * Requests
$users = getAllUsers();
$loggedInUser = $_SESSION['loggedInUser'];

// Logout Request
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['logout'])) {
    logout();
}

// Delete User request 
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['deleteUser'])) {
    deleteUser($_POST['deleteUser']);
}
// Delete Self request 
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['deleteSelf'])) {
    deleteSelf($_POST['deleteSelf']);
}