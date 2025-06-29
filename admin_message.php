<?php
    include 'connection.php';
    session_start();

    $admin_id = $_SESSION['admin_id'];
    if(!isset($admin_id)){
        header('location:login.php');
    }
    if(isset($_POST['logout'])){
        session_destroy();
        header('location:login.php');
    }
    /*------deleting order detail from database------*/
    if (isset($_GET['delete'])) {
        $delete_id = $_GET['delete'];
       
        mysqli_query($conn, "DELETE FROM message WHERE id = '$delete_id'") or die('query failed');
        header('location: admin_user.php');
    }
    
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.2/font/bootstrap-icons.css">
    <link rel="stylesheet" type="text/css" href="css/style.css?v=<?php echo time(); ?>">
    <title>admin message</title>
</head>
<body>
<?php include 'admin_header.php';?>
<?php

    if (isset($message)) {
        foreach ($message as $message) {
            echo '
            <div class="message">
                <span>'.$message.'</span>
                <i class="bi bi-x-circle" onclick="this.parentElement.remove()"></i>
            </div>
            ';
        }
    }
?>

<section class="user-container">
    <h1 class="title">Message</h1>
    <div class="message-container">
    <?php
        $select_message = mysqli_query($conn, "SELECT * FROM message") or die('query failed');
        if (mysqli_num_rows($select_message) > 0) {
            while ($fetch_users = mysqli_fetch_assoc($select_message)) {
        ?>
        <div class="box">
            <p>user id: <span><?php echo $fetch_users['user_id']; ?></span></p>
            <p>user name: <span><?php echo $fetch_users['name']; ?></span></p>
            <p>email: <span><?php echo $fetch_users['email']; ?></span></p>
            <p>message: <?php echo $fetch_users['message']; ?></p>

            <a href="admin_message.php?delete=<?php echo $fetch_users['id']; ?>" class="delete" onclick="return confirm('Delete this message?')">Delete</a>
        </div>
         <?php
            }
            }else{
                echo "<p class='empty'>No message yet</p>";
        }
        ?>
       
    </div>
 
</section>

<script type="text/javascript" src="js/script.js"></script>
    
</body>
</html>