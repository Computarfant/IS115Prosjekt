<?php

function validateFirstName($name) {
    if (empty($name)) {
        return "Missing First Name.";
    } elseif (!preg_match("/^[A-Za-z]*$/", $name)) {
        return "Only letters are allowed in First Name.";
    }
    return null;
}

function validateLastName($lastname) {
    if (empty($lastname)) {
        return "Missing Last Name.";
    } elseif (!preg_match("/^[A-Za-z]*$/", $lastname)) {
        return "Only letters are allowed in Last Name.";
    }
    return null;
}

function validateEmail($email) {
    if (empty($email)) {
        return "Missing Email.";
    } elseif (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        return "Invalid email format.";
    }
    return null;
}

function validatePassword($password) {
    if (empty($password)) {
        return "Missing Password.";
    } elseif (!preg_match("/^(?=.*[a-zA-Z])(?=.*\d).{10,}$/", $password)) {
        return "Password must contain minimum 10 characters, one letter and one number.";
    }
    return null;
}

function validateAdresse($adresse) {
    if (empty($adresse)) {
        return "Missing Adresse.";
    }
    return null;
}

function validateMobilnummer($phone) {
    $phone = trim($phone);
    if (empty($phone)) {
        return "Missing Phone Number.";
    }
    // Allows optional +, country code, and digits with optional spaces or dashes
    $pattern = "/^\+?[0-9]{1,3}?[- ]?\(?[0-9]{1,4}?\)?[- ]?[0-9]{1,4}[- ]?[0-9]{1,9}$/";
    if (!preg_match($pattern, $phone)) {
        return "Invalid phone number format.";
    }
    return null;
}
