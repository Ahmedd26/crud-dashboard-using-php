<?php
require_once "models/Database.model.php";
require_once "models/Validator.model.php";

session_start();

class UserController
{
    private $db;
    private $validator;
    private $errors = [];
    private $persistModal = null;

    public function __construct()
    {
        $this->db = new Database();
        $this->validator = new Validator();
    }

    public function logout()
    {
        unset($_SESSION["loggedInUser"]);
        session_destroy();
        header("Location: ?page=login");
        exit();
    }

    public function deleteUser($userId, $imageToDelete, $whoIsBeingDeleted)
    {
        $delete = $this->db->deleteUserFromDB($userId);
        if ($delete) {
            $this->deleteImage($imageToDelete);
            if ($whoIsBeingDeleted === 'self') {
                $this->logout();
            } elseif ($whoIsBeingDeleted === 'otherUser') {
                header("Location: " . $_SERVER['PHP_SELF']);
                exit();
            }
        } else {
            echo "Error deleting user: " . print_r($delete, true);
        }
    }

    private function deleteImage($profilePicture)
    {
        $filePath = "public/uploads/$profilePicture";
        if (file_exists($filePath)) {
            if (unlink($filePath)) {
                echo "File '$filePath' has been deleted.";
            } else {
                echo "Error: Could not delete the file '$filePath'.";
            }
        } else {
            echo "Error: File '$filePath' does not exist.";
        }
    }

    public function getAllUsers()
    {
        return $this->db->getAllUsers();
    }

    public function getLoggedInUser()
    {
        return $_SESSION['loggedInUser'] ?? null;
    }

    public function handleUpdate($postData, $fileData)
    {
        $userId = $postData['editId'];
        $fullName = $postData['name'];
        $password = $postData['password'];
        $confirmPassword = $postData['confirmPassword'];
        $oldProfilePicture = $postData['removeOldImage'];

        $this->validatePassword($password, $confirmPassword);

        $profilePicture = $this->validateProfilePicture($fileData['newProfilePicture']);

        if (empty($this->errors)) {
            $this->persistModal = false;
            $update = $this->db->updateUserInDB($userId, $fullName, $profilePicture, $password);

            if ($update) {
                if ($postData['isEditing'] === 'selfEdit') {
                    $_SESSION['loggedInUser'] = $update;
                }
                $this->deleteImage($oldProfilePicture);
                $this->storeImageLocally($fileData['newProfilePicture']);
                header("Location: ?page=home");
                exit();
            } else {
                $this->errors['invalid'] = 'An unexpected error occurred. Please try again.';
            }
        } else {
            $this->persistModal = true;
        }
    }

    private function validatePassword($password, $confirmPassword)
    {
        if (!empty($password)) {
            $passwordError = $this->validator->validatePassword($password);
            if ($passwordError) {
                $this->errors['password'] = $passwordError;
            }

            $confirmPasswordError = $this->validator->validatePasswordConfirmation($password, $confirmPassword);
            if ($confirmPasswordError) {
                $this->errors['confirmPassword'] = $confirmPasswordError;
            }
        }
    }

    private function validateProfilePicture($profilePictureFile)
    {
        if (isset($profilePictureFile) && $profilePictureFile['error'] !== 4) {
            $profilePictureError = $this->validator->validateProfilePicture($profilePictureFile);
            if ($profilePictureError) {
                $this->errors['profilePicture'] = $profilePictureError;
            } else {
                return time() . "-" . $profilePictureFile['name'];
            }
        }

        return null;
    }

    private function storeImageLocally($profilePictureFile)
    {
        $profilePicture = time() . "-" . $profilePictureFile['name'];
        $dest = "public/uploads/" . $profilePicture;
        move_uploaded_file($profilePictureFile['tmp_name'], $dest);
    }

    public function getErrors()
    {
        return $this->errors;
    }

    public function shouldPersistModal()
    {
        return $this->persistModal;
    }
}


$userController = new UserController();

if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['logout'])) {
    $userController->logout();
}

if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['idToDelete'])) {
    $userController->deleteUser($_POST['idToDelete'], $_POST['imageToDelete'], $_POST['whoIsBeingDeleted']);
}

if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['editId'])) {
    $userController->handleUpdate($_POST, $_FILES);
}

$users = $userController->getAllUsers();
$loggedInUser = $userController->getLoggedInUser();
$errors = $userController->getErrors();
$persistModal = $userController->shouldPersistModal();

