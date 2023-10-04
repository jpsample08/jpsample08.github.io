<?php
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\SMTP;
use PHPMailer\PHPMailer\Exception;

//Load Composer's autoloader
require 'vendor/autoload.php';

// Database Connection
$dbHost = 'localhost';
$dbUsername = 'root';
$dbPassword = '';
$dbName = 'testemail';

$conn = new mysqli($dbHost, $dbUsername, $dbPassword, $dbName);

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Registration Process
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $username = $_POST['username'];
    $email = $_POST['email'];
    $password = password_hash($_POST['password'], PASSWORD_DEFAULT);

    $sql = "INSERT INTO tbltest (username, email, password) VALUES ('$username', '$email', '$password')";
    $stmt = $conn->prepare($sql);
   
    if ($stmt->execute()) {
        // Send Confirmation Email
        require 'vendor/autoload.php';
        $mail = new PHPMailer\PHPMailer\PHPMailer(true);
        $mail->isSMTP();
        $mail->Host = 'smtp.gmail.com';
        $mail->SMTPAuth = true;
        $mail->Username = 'test.sample.sample@gmail.com';
        $mail->Password = 'eogl owlj pkjp ovoh';
        $mail->SMTPSecure = 'tls';
        $mail->Port = 587;

        $mail->setFrom('test.sample.sample@gmail.com', 'GIEEE');
        $mail->addAddress($email);

        $mail->isHTML(true);
        $mail->Subject = 'Registration Confirmation';
        $mail->Body = 'Thank you for registering!';

        if ($mail->send()) {
            echo 'Registration successful. Check your email for confirmation.';
        } else {
            echo 'Registration successful, but there was an issue sending the confirmation email.';
        }
    } else {
        echo 'Registration failed.';
    }

    $stmt->close();
}

$conn->close();
?>
