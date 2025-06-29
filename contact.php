<?php
include 'connection.php';
session_start();

$user_id = isset($_SESSION['user_id']) ? $_SESSION['user_id'] : null;
/**----------send message-------**/
if (isset($_POST['submit-btn'])) {
        // Check if user is logged in
    if (!$user_id) {
        // Redirect guests trying to send message to login page
        header('Location: login.php');
        exit();
    }
    $name = mysqli_real_escape_string($conn, $_POST['name']);
    $email = mysqli_real_escape_string($conn, $_POST['email']);
    $number = mysqli_real_escape_string($conn, $_POST['number']);
    $message = mysqli_real_escape_string($conn, $_POST['message']);
    $select_message = mysqli_query($conn, "SELECT * FROM message WHERE name = '$name' AND email='$email' AND number= '$number' AND message='$message'") or die('query failed');

if (mysqli_num_rows($select_message)>0) {
    echo 'message already sent';
}else{
    mysqli_query($conn, "INSERT INTO message (user_id, name, email, number, message) VALUES ('$user_id','$name', '$email', '$number', '$message')") or die('query failed');
}
}

?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.2/font/bootstrap-icons.css">
    <link rel="stylesheet" type="text/css" href="css/main.css">
    <title>flower shop</title>
</head>
<body>
<?php include 'header.php'; ?>
<div class="bannerm">
    <h1>contact us</h1>
    <p>We're here to help! Get in touch with us for any inquiries or support regarding your flower orders.</p>
</div>

<div class="help">
    <h1 class="title">need help</h1>
    <div class="box-container">
        <div class="box">
            <div>
                <img src="image/icon1.jpeg">
                <h2>address</h2>
            </div>
            <p>Narayanganj, Dhaka</p>
        </div>
        <div class="box">
            <div>
                <img src="image/icon2.jpeg">
                <h2>opening</h2>
            </div>
            <p>Open daily from 9:00 AM to 9:00 PM.</p>
        </div>
        <div class="box">
            <div>
                <img src="image/icon3.jpeg">
                <h2>our contact</h2>
            </div>
            <p>Call or WhatsApp us at: +8801760528951</p>
        </div>
        <div class="box">
            <div>
                <img src="image/icon4.jpeg">
                <h2>special offer</h2>
            </div>
            <p>Get extra 10% off on your first order. use code: BLOOM10</p>
        </div>
    </div>
</div>
<div class="form-container">
    <div class="form-section">
        <form method="post">
            <h1>sent your question!</h1>
            <p>we'll get back to you within two days.</p>
            <div class="input-field">
                <label>your name</label>
                <input type="text" name="name">
            </div>
             <div class="input-field">
                <label>your email</label>
                <input type="text" name="email">
            </div>
             <div class="input-field">
                <label>your number</label>
                <input type="number" name="number">
            </div>
             <div class="input-field">
                <label>message</label>
                <textarea name="message"></textarea>
            </div>
            <input type="submit" name="submit-btn" class="btn" value="send message">
        </form>
    </div>
</div>

<?php include 'footer.php'; ?>
<script type="text/javascript" src="js/script.js"></script>
</body>
</html>
