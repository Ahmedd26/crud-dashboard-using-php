<?php
require_once "Database.model.php";

class Validator
{
    // * Empty Field Validator
    public function validateEmpty($input)
    {
        if (empty($input)) {
            return true;
        }
        return null;
    }

    // * Email Validations
    public function validateEmail($email)
    {
        if ($this->validateEmpty($email)) {
            return 'Email should not be empty!';
        }
        if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
            return 'Invalid email address!';
        }
        $currentEmails = Database::getEmails();
        foreach ($currentEmails as $currentEmail) {
            if ($currentEmail['email'] === $email) {
                return 'Email already exists!';
            }
        }
        return null;
    }
    // * Password Validations
    public function validatePassword($password)
    {
        if ($this->validateEmpty($password)) {
            return 'Password should not be empty!';
        }
        if (strlen($password) < 8) {
            return 'Password must be at least 8 characters long!';
        }
        if (!preg_match('/^[a-z0-9_]+$/', $password)) {
            return "Password must contain only lowercase letters, numbers, and underscores.";
        }
        if (preg_match('/[A-Z]/', $password)) {
            return "Password must not contain uppercase letters.";
        }
        return null;
    }

    // * Password Confirmation Validation
    public function validatePasswordConfirmation($password, $confirmPassword)
    {
        if ($this->validateEmpty($confirmPassword)) {
            return 'Confirm password should not be empty!';
        }
        if ($password !== $confirmPassword) {
            return 'Passwords do not match!';
        }
        return null;
    }
    // * Profile Picture Validation
    public function validateProfilePicture($file)
    {

        $allowedTypes = ['image/jpeg', 'image/jpg', 'image/png', 'image/gif', 'image/webp'];
        if ($file['error'] === 4) {
            return "No file uploaded.";
        }
        if ($file['error'] === 1 || $file['size'] > 5_000_000) { // 5MB limit
            return "Profile picture size must be less than 5MB.";
        }
        if (!in_array($file['type'], $allowedTypes)) {
            return "Invalid profile picture format. Only JPEG, PNG, GIF, and WEBP formats are allowed.";
        }
        return null;
    }

    public function validateRegister($username, $email, $password, $confirmPassword, $profilePicture)
    {
        $errors = [];
        $usernameError = self::validateEmpty($username);
        if ($usernameError) {
            $errors['name'] = 'This field is required!';
        }
        $emailError = self::validateEmail($email);
        if ($emailError) {
            $errors['email'] = $emailError;
        }
        $passwordError = self::validatePassword($password);
        if ($passwordError) {
            $errors['password'] = $passwordError;
        }
        $confirmPasswordError = self::validatePasswordConfirmation($password, $confirmPassword);
        if ($confirmPasswordError) {
            $errors['confirmPassword'] = $confirmPasswordError;
        }
        $profilePictureError = self::validateProfilePicture($profilePicture);
        if ($profilePictureError) {
            $errors['profilePicture'] = $profilePictureError;
        }
        return $errors;
    }

    public function validateLogin($email, $password)
    {
        $errors = [];
        $emailError = self::validateEmpty($email);
        if ($emailError) {
            $errors['email'] = 'Email is required!';
        }
        $passwordError = self::validateEmpty($password);
        if ($passwordError) {
            $errors['password'] = 'Password is required!';
        }
        return $errors;
    }

}



