<?php
include 'connection.php';

$message = [];

if (isset($_POST['submit-btn'])) {
    $name = mysqli_real_escape_string($conn, trim($_POST['name']));
    $email = mysqli_real_escape_string($conn, trim($_POST['email']));
    $password = mysqli_real_escape_string($conn, trim($_POST['password']));
    $cpassword = mysqli_real_escape_string($conn, trim($_POST['cpassword']));

    // Check if user already exists
    $select_user = mysqli_query($conn, "SELECT * FROM users WHERE email = '$email'") or die('Query failed');

    if (mysqli_num_rows($select_user) > 0) {
        $message[] = 'User already exists';
    } elseif ($password !== $cpassword) {
        $message[] = 'Passwords do not match';
    } else {
        $insert = mysqli_query($conn, "INSERT INTO users (name, email, password) VALUES ('$name', '$email', '$password')") or die('Query failed');

        if ($insert) {
            $message[] = 'Registered successfully';
            header('Location: login.php');
            exit();
        } else {
            $message[] = 'Registration failed. Please try again.';
        }
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" type="text/css" href="css/style.css">
    <title>Registration page</title>
</head>
<body>
    <?php
        if(isset($message)){
            foreach($message as $message){
                echo'
                <div class ="message">
                <span>'.$message.'</span>
                <i class="bi bi-x-circle" onclick="this.parentElement.remove()"></i>
                </div>
                ';
            }
        }
?>

    <section class="form-container">
<form id="registerForm" action="" method="post" onsubmit="return validateForm()">
    <h3>Register now</h3>
    <input type="text" id="name" name="name" placeholder="Enter your name" required>
    <input type="email" name="email" placeholder="Enter your email" required>
    <input type="password" id="password" name="password" placeholder="Enter your password" required>
    <input type="password" id="cpassword" name="cpassword" placeholder="Re-enter your password" required>
    <div id="errorMessages" class="message" style="display: none;"></div>
    <input type="submit" name="submit-btn" class="btn" value="Register now">
    <p>Already have an account? <a href="login.php">Login now</a></p>
</form>

    </section>
<script type="text/javascript" src="js/script.js"></script>
    
</body>
</html>