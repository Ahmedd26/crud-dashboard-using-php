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
// * Delete Image
function deleteImage($profilePicture)
{
    $file = 'uploads/' . $profilePicture;
    echo "Attempting to delete: $file"; // Debugging line

    if (file_exists($file)) {
        if (unlink($file)) {
            echo "File '$file' has been deleted.";
        } else {
            echo "Error: Could not delete the file '$file'.";
        }
    } else {
        echo "Error: File '$file' does not exist.";
    }
}

// * Delete User
function deleteUser($userId, $profilePicture)
{
    $delete = deleteUserFromDB($userId);
    if ($delete) {
        deleteImage($profilePicture);
        header("Location: " . $_SERVER['PHP_SELF']);
        exit;
    } else {
        print_r($delete);
    }
}
function deleteSelf($userId, $profilePicture)
{
    $delete = deleteUserFromDB($userId);
    if ($delete) {
        deleteImage($profilePicture);
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
    deleteUser($_POST['deleteUser'], $_POST['imageToDelete']);
}
// Delete Self request 
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['deleteSelf'])) {
    deleteSelf($_POST['deleteSelf'], $_POST['imageToDelete']);
}
$test = null;
// $test = true;
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['closeModal'])) {
    $test = false;
}

$errors = [];
$inputs = [];
//** UPDATE LOGIC
if ($_SERVER["REQUEST_METHOD"] == "POST" && (isset($_POST['editUser']) || isset($_POST['editSelf']))) {

    if (isset($_POST['editUser'])) {
        $userId = $_POST['editUser'];
        $oldProfilePicture = $_POST['removeOldImage'];
    }

    if (isset($_POST['editSelf'])) {
        $userId = $_POST['editSelf'];
        $oldProfilePicture = $_SESSION['loggedInUser']['profile_picture'];

    }

    // $userId = $_POST['editUser'];
    $fullName = $_POST['name'];
    $password = $_POST['password'];
    $confirmPassword = $_POST['confirmPassword'];
    $profilePicture = $_POST['newProfilePicture'];


    // Password Validation
    if (!empty($password)) {
        if ((!preg_match('/^[a-z0-9_]{8,}$/', $password) || preg_match('/[A-Z]/', $password))) {
            $errors['password'] = "Password must be at least 8 characters long, contain only lowercase letters, numbers, and underscores, and must not contain uppercase letters.";
        }
        // Confirm Password Validation
        if (!empty($password) && $password !== $confirmPassword) {
            $errors['confirmPassword'] = "Password and Confirm Password must match.";
        }
    }
    // Profile Picture Validation
    if (isset($_FILES['newProfilePicture']) && $_FILES['newProfilePicture']['error'] !== 4) {
        $fileType = $_FILES['newProfilePicture']['type'];
        $fileSize = $_FILES['newProfilePicture']['size'];
        $allowedTypes = ['image/jpeg', 'image/png', 'image/gif', 'image/webp'];
        if (!in_array($fileType, $allowedTypes) || $fileSize > 5_000_000) {
            // 5MB limit
            $errors['newProfilePicture'] = "Invalid profile picture. Only JPEG, PNG, and GIF formats are allowed and size must be less than 5MB.";
        } else {
            function storeImageLocally()
            {
                $profilePicture = $_FILES['newProfilePicture']['name'];
                $dest = "uploads/" . time() . "-" . $profilePicture;
                move_uploaded_file($_FILES['newProfilePicture']['tmp_name'], $dest);
            }
            $profilePicture = time() . "-" . $_FILES['newProfilePicture']['name'];

        }
    }

    if (!empty($errors)) {
        $test = true;
    }
    if (empty($errors)) {
        $test = false;
        $update = updateUserInDB($userId, $fullName, $profilePicture, $password);

        if ($update) {
            if (isset($_POST['editSelf'])) {
                $_SESSION['loggedInUser'] = $update;
            }
            deleteImage($oldProfilePicture);
            storeImageLocally();
            header("Location: ?page=home");
            exit;
        } else {
            print_r($update);
            print_r($errors);
            $errors['invalid'] = 'An unexpected error occurred. Please try again.';
        }
    }



}

