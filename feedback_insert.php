<?php
session_start();
include 'db.php';

// Feedback form insert code

if (isset($_POST['feedback_submit']) && $_SERVER['REQUEST_METHOD'] === 'POST') {
    $name = trim($_POST['name']);
    $email = trim($_POST['email']);
    $message = trim($_POST['message']);
    $rating = intval($_POST['rating']);

    $errors = [];

    // ✅ Name validation
    if (empty($name)) {
        $errors[] = "Name is required.";
    } elseif (!preg_match("/^[a-zA-Z]{1,15}$/", $name)) {
        $errors[] = "Name must contain only letters and spaces, max 15 characters.";
    }

    // ✅ Email validation
    if (empty($email)) {
        $errors[] = "Email is required.";
    } elseif (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $errors[] = "Invalid email format.";
    }

    // ✅ Message validation (max 100 words)
    if (empty($message)) {
        $errors[] = "Message is required.";
    } else {
        $wordCount = str_word_count($message);
        if ($wordCount > 100) {
            $errors[] = "Message cannot exceed 100 words. Currently: $wordCount words.";
        }
    }

    // ✅ Rating validation
    if ($rating <= 0 || $rating > 5) {
        $errors[] = "Rating must be between 1 and 5.";
    }

    // ✅ If no errors → insert into DB
    if (empty($errors)) {
        $insert = $pdo->prepare("INSERT INTO feedback (name, email, message, rating, created_at) 
                                 VALUES (?, ?, ?, ?, NOW())");
        $insert->execute([$name, $email, $message, $rating]);

        $_SESSION["success"] = "Feedback submitted successfully!";
        header("Location: index.php?feedback=success");
    } else {
        // Show all errors in alert
        $errorMessage = implode("\\n", $errors);
        $_SESSION["error"] = $errorMessage;
        header("Location: index.php?feedback=error");

    }
}