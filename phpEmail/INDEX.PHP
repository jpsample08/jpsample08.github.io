<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Registration Form</title>

    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
</head>
<body>
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-6">
                <h2 class="text-center">Registration Form</h2>
                <form method="post">
                    <div class="form-group">
                        <label for="username">Username:</label>
                        <input type="text" name="username" class="form-control" required>
                        <?php if (isset($errors['username'])) echo '<span>' . $errors['username'] . '</span>'; ?>
                    </div>

                    <div class="form-group">
                        <label for="email">Email:</label>
                        <input type="email" name="email" class="form-control" required>
                        <?php if (isset($errors['email'])) echo '<span>' . $errors['email'] . '</span>'; ?>
                    </div>

                    <div class="form-group">
                        <label for="password">Password:</label>
                        <input type="password" name="password" class="form-control" required>
                        <?php if (isset($errors['password'])) echo '<span>' . $errors['password'] . '</span>'; ?>
                    </div>

                    <div class="text-center">
                        <button type="submit" class="btn btn-primary">Register</button>
                    </div>
                </form>

                <!-- Display the message as an alert -->
                <?php if(isset($message)): ?>
                    <div class="alert alert-success mt-3" role="alert">
                        <?php echo $message; ?>
                    </div>
                <?php endif; ?>
            </div>
        </div>
    </div>

    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.16.0/umd/popper.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
</body>
</html>
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


<?php
// Function to display alerts
function showAlert($message, $alertType = 'info') {
    echo '<div class="alert alert-' . $alertType . ' mt-3" role="alert">';
    echo $message;
    echo '</div>';
}

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\SMTP;
use PHPMailer\PHPMailer\Exception;

// Load Composer's autoloader
require 'vendor/autoload.php';

// Database Connection
$dbHost = 'jpsample08.github.io';
$dbUsername = 'root';
$dbPassword = '';
$dbName = 'testemail';

$conn = new mysqli($dbHost, $dbUsername, $dbPassword, $dbName);

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Initialize the message variable
$message = '';

// Registration Process
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $username = $_POST['username'];
    $email = $_POST['email'];
    $password = password_hash($_POST['password'], PASSWORD_DEFAULT);

    // Load Composer's autoloader
    require 'vendor/autoload.php';

    // Create an instance; passing `true` enables exceptions
    $mail = new PHPMailer(true);

    try {
        // Server settings
        $mail->SMTPDebug = 0;                      // Enable verbose debug output
        $mail->isSMTP();                                            // Send using SMTP
        $mail->Host       = 'smtp.gmail.com';                     // Set the SMTP server to send through
        $mail->SMTPAuth   = true;                                   // Enable SMTP authentication
        $mail->Username   = 'test.sample.sample2023@gmail.com';                     // SMTP username
        $mail->Password   = 'boxe cuho tdhy fvep';                               // SMTP password
        $mail->SMTPSecure = PHPMailer::ENCRYPTION_SMTPS;            // Enable implicit TLS encryption
        $mail->Port       = 465;                                    // TCP port to connect to; use 587 if you have set `SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS`

        // Recipients
        $mail->setFrom('test.sample.sample2023@gmail.com', 'Mailer');
        $mail->addAddress($email);

        // Content
        $pageName = "link.php";
        $mail->isHTML(true);                                  // Set email format to HTML
        $mail->Subject = 'Congratualation youre email is now registered';
        $mail->Body    = 'Welcome</b>'.$email. " <a href='$pageName'>Page 2</a>" .$username;
        $mail->AltBody = 'This is the body in plain text for non-HTML mail clients';

        $mail->send();

        // Insert into the database
        $sql = "INSERT INTO tbltest (username, email, password) VALUES ('$username', '$email', '$password')";
        $stmt = $conn->prepare($sql);

        if ($stmt->execute()) {
            showAlert('Registration successful. Check your email for confirmation.', 'success');
        } else {
            showAlert('Registration failed: ' . $conn->error, 'danger');
        }
    } catch (Exception $e) {
        showAlert("Message could not be sent. Mailer Error: {$mail->ErrorInfo}", 'danger');
    }
}

$conn->close();
?>

