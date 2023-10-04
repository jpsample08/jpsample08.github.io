<?php
// Initialize variables to store validation errors
$errors = array();

// Check if the form is submitted
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Validate username
    $username = $_POST['username'];
    if (empty($username)) {
        $errors['username'] = 'Username is required.';
    } elseif (strlen($username) < 3) {
        $errors['username'] = 'Username must be at least 3 characters.';
    }

    // Validate email
    $email = $_POST['email'];
    if (empty($email)) {
        $errors['email'] = 'Email is required.';
    } elseif (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $errors['email'] = 'Invalid email format.';
    }

    // Validate password
    $password = $_POST['password'];
    if (empty($password)) {
        $errors['password'] = 'Password is required.';
    } elseif (strlen($password) < 6) {
        $errors['password'] = 'Password must be at least 6 characters.';
    }

    // If there are no validation errors, proceed with registration
    if (empty($errors)) {
        // Your registration logic goes here
        // Insert data into the database, send confirmation email, etc.
        // If successful, redirect or show a success message
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Registration Form</title>
</head>
<body>
    <h2>Registration Form</h2>
    <form method="post">
        <div>
            <label for="username">Username:</label>
            <input type="text" name="username" required>
            <?php if (isset($errors['username'])) echo '<span>' . $errors['username'] . '</span>'; ?>
        </div>

        <div>
            <label for="email">Email:</label>
            <input type="email" name="email" required>
            <?php if (isset($errors['email'])) echo '<span>' . $errors['email'] . '</span>'; ?>
        </div>

        <div>
            <label for="password">Password:</label>
            <input type="password" name="password" required>
            <?php if (isset($errors['password'])) echo '<span>' . $errors['password'] . '</span>'; ?>
        </div>

        <input type="submit" value="Register">
    </form>
</body>
</html>
