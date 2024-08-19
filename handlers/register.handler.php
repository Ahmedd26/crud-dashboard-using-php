<?php
require_once 'database.handler.php';
session_start();
$errors = [];
$inputs = [];

if (isset($_SESSION['loggedInUser'])) {
    header("Location: ?page=home");
    exit();
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    foreach ($_POST as $key => $value) {
        if (is_string($value)) {
            if (empty(trim($value))) {
                if ($key === 'confirmPassword') {
                    $errors[$key] = "Confirm password is required";
                } else {
                    $errors[$key] = ucfirst($key) . " cannot be empty.";
                }
            } else {
                $inputs[$key] = trim($value);
            }
        }
    }

    if (!empty($inputs['email']) && !filter_var($inputs['email'], FILTER_VALIDATE_EMAIL)) {
        $errors['email'] = "Invalid email format.";
    }

    if (!empty($inputs['password']) && (!preg_match('/^[a-z0-9_]{8,}$/', $inputs['password']) || preg_match('/[A-Z]/', $inputs['password']))) {
        $errors['password'] = "Password must be at least 8 characters long, contain only lowercase letters, numbers, and underscores, and must not contain uppercase letters.";
    }


    if (!empty($inputs['password']) && $inputs['password'] !== $inputs['confirmPassword']) {
        $errors['confirmPassword'] = "Password and Confirm Password must match.";
    }
    // echo "<pre>";
    // var_export($_FILES['profilePicture']);
    // echo "</pre>";
    if (isset($_FILES['profilePicture']) && $_FILES['profilePicture']['error'] !== 4) {
        $fileType = $_FILES['profilePicture']['type'];
        $fileSize = $_FILES['profilePicture']['size'];
        $allowedTypes = ['image/jpeg', 'image/png', 'image/gif', 'image/webp'];
        if (!in_array($fileType, $allowedTypes) || $fileSize > 5_000_000) {
            // 5MB limit
            $errors['profilePicture'] = "Invalid profile picture. Only JPEG, PNG, and GIF formats are allowed and size must be less than 5MB.";
        } else {
            function storeImageLocally()
            {
                // ? Explanation: we will be storing the image only if the data was saved to the database; because when DB error occurs, the image for un-registered user would be already saved locally.
                $inputs['profilePicture'] = $_FILES['profilePicture']['name'];
                $dest = "uploads/" . time() . "-" . $inputs['profilePicture'];
                move_uploaded_file($_FILES['profilePicture']['tmp_name'], $dest);
            }
            // $inputs['profilePicture'] = $_FILES['profilePicture']['name'];
            $inputs['profilePicture'] = time() . "-" . $_FILES['profilePicture']['name'];

        }
    } else {
        $errors['profilePicture'] = "Profile picture is required.";
    }



    // echo "<pre class='text-2xl text-white'>";
    // echo $inputs['profilePicture'];
    // echo '</pre>';
    if (empty($errors)) {
        $auth = registerUser($inputs['name'], $inputs['email'], $inputs['password'], $inputs['profilePicture']);

        if (is_array($auth)) {
            storeImageLocally();
            $_SESSION['loggedInUser'] = $auth;
            header("Location: ?page=home");
            exit;
        } elseif ($auth === 'email_exists') {
            $errors['email_exists'] = 'The email address is already registered.';
        } elseif ($auth === 'db_error') {
            $errors['database'] = 'A database error occurred. Please try again later.';
        } else {
            $errors['invalid'] = 'An unexpected error occurred. Please try again.';
        }
    }

}

