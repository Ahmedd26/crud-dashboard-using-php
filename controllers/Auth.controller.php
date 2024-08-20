<?php
// require_once 'models/Database.model.php';
// require_once 'models/Validator.model.php';

// session_start();
// $db = new Database();
// $validator = new Validator();
// $errors = [];

// // ** ** ** ** ** ** ** ** ** ** ** ** ** // 
// // ** ** ** ** ** REGISTER ** ** ** ** ** // 
// // ** ** ** ** ** ** ** ** ** ** ** ** ** // 

// if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['register'])) {
//     $errors = $validator->validateRegister($_POST['name'], $_POST['email'], $_POST['password'], $_POST['confirmPassword'], $_FILES['profilePicture']);

//     if (empty($errors)) {
//         // * Construct profile picture name
//         $profilePictureName = time() . "-" . $_FILES['profilePicture']['name'];
//         // * Try to Register
//         $auth = $db->registerUser($_POST['name'], $_POST['email'], $_POST['password'], $profilePictureName);

//         if ($auth === 'email_exists') {
//             $errors['email'] = 'Email already exists';
//         } else if ($auth === 'db_error') {
//             $errors['internal_error'] = "We're sorry, something went wrong. Please try again later.";
//         } else {
//             // * Save session
//             $_SESSION['user'] = $auth;
//             // * Save image locally
//             $dest = "public/uploads/" . $profilePictureName;
//             move_uploaded_file($_FILES['profilePicture']['tmp_name'], $dest);
//             // * Redirect to Home page
//             header('Location: ?page=home');
//         }
//     }
// }

// // ** ** ** ** ** ** ** ** ** ** ** ** // 
// // ** ** ** ** ** LOGIN ** ** ** ** ** // 
// // ** ** ** ** ** ** ** ** ** ** ** ** // 


// if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['login'])) {
//     $errors = $validator->validateLogin($_POST['email'], $_POST['password']);
//     if (empty($errors)) {
//         // * Try to Login
//         $auth = $db->authUser($_POST['email'], $_POST['password']);
//         if ($auth) {
//             // * Save session
//             $_SESSION['user'] = $auth;
//             // * Redirect to Home page
//             header('Location: ?page=home');
//         } else {
//             $errors['invalid'] = 'Invalid email or password';
//         }
//     }
// }

require_once 'models/Database.model.php';
require_once 'models/Validator.model.php';

session_start();

class AuthController
{
    private $db;
    private $validator;
    private $errors = [];

    public function __construct()
    {
        $this->db = new Database();
        $this->validator = new Validator();
    }

    public function handleRequest()
    {
        if ($_SERVER["REQUEST_METHOD"] == "POST") {
            if (isset($_POST['register'])) {
                $this->register();
            } elseif (isset($_POST['login'])) {
                $this->login();
            }
        }
    }

    private function register()
    {
        $this->errors = $this->validator->validateRegister(
            $_POST['name'],
            $_POST['email'],
            $_POST['password'],
            $_POST['confirmPassword'],
            $_FILES['profilePicture']
        );

        if (empty($this->errors)) {
            $profilePictureName = $this->generateProfilePictureName($_FILES['profilePicture']['name']);
            $auth = $this->db->registerUser(
                $_POST['name'],
                $_POST['email'],
                $_POST['password'],
                $profilePictureName
            );

            $this->handleRegisterResult($auth, $profilePictureName);
        }
    }

    private function login()
    {
        $this->errors = $this->validator->validateLogin($_POST['email'], $_POST['password']);
        // if (!empty($this->errors)) {
        //     print_r($this->errors);
        //     exit; // Prevent further code execution for debugging
        // }
        if (empty($this->errors)) {
            $auth = $this->db->authUser($_POST['email'], $_POST['password']);
            $this->handleLoginResult($auth);
        }
    }

    private function generateProfilePictureName($originalName)
    {
        return time() . "-" . basename($originalName);
    }

    private function handleRegisterResult($auth, $profilePictureName)
    {
        if ($auth === 'email_exists') {
            $this->errors['email'] = 'Email already exists';
        } elseif ($auth === 'db_error') {
            $this->errors['internal_error'] = "We're sorry, something went wrong. Please try again later.";
        } else {
            $_SESSION['loggedInUser'] = $auth;
            $this->saveProfilePicture($profilePictureName);
            $this->redirectToHome();
        }
    }

    private function handleLoginResult($auth)
    {
        if ($auth) {
            $_SESSION['loggedInUser'] = $auth;
            $this->redirectToHome();
        } else {
            $this->errors['invalid'] = 'Invalid email or password';
        }
    }

    private function saveProfilePicture($profilePictureName)
    {
        $destination = "public/uploads/" . $profilePictureName;
        move_uploaded_file($_FILES['profilePicture']['tmp_name'], $destination);
    }

    private function redirectToHome()
    {
        header('Location: ?page=home');
        exit();
    }

    public function getErrors()
    {
        return $this->errors;
    }
}

$authController = new AuthController();
$authController->handleRequest();
$errors = [];
// $errors = $authController->getErrors();
$_SESSION['errors'] = $authController->getErrors();
