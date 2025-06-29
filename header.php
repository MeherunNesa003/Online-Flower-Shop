<?php
include 'connection.php';

// Check if user is logged in and set $user_id
if (isset($_SESSION['user_id'])) {
    $user_id = $_SESSION['user_id'];
} else {
    $user_id = null; // or handle as guest user
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.2/font/bootstrap-icons.css" />
    <link rel="stylesheet" type="text/css" href="css/main.css" />
    <title>Flower shop</title>
</head>
<body>
<header class="header">
    <div class="flex">
        <a href="index.php" class="logo">
            The Ethereal<br />
            <span style="display: block; text-align: center;"><i class="bi bi-flower2"></i>Petals</span>
        </a>

        <nav class="navbar">
            <a href="index.php">Home</a>
            <a href="shop.php">shop</a>
            <a href="order.php">orders</a>
            <a href="about.php">about us</a>
            <a href="contact.php">contact</a>
        </nav>
        <div class="icons">
            <form action="search.php" method="get" class="search-form">
                <input type="text" name="query" placeholder="Search products..." required>
                <button type="submit"><i class="bi bi-search"></i></button>
            </form>

            <i class="bi bi-person" id="user-btn"></i> 
            <div class="user-box">
                <p>username: <span><?php echo isset($_SESSION['user_name']) ? htmlspecialchars($_SESSION['user_name']) : 'Guest'; ?></span></p>
                <p>email: <span><?php echo isset($_SESSION['user_email']) ? htmlspecialchars($_SESSION['user_email']) : '-'; ?></span></p>
                <?php if (isset($_SESSION['user_id'])): ?>
                    <form method="post" action="logout.php" class="logout">
                        <button type="submit" name="logout" class="logout-btn">LOG OUT</button>
                    </form>
                <?php else: ?>
                    <a href="login.php" class="logout-btn">LOG IN</a>
                <?php endif; ?>
            </div>

            <?php
            if ($user_id) {
                $select_wishlist = mysqli_query($conn, "SELECT * FROM wishlist WHERE user_id = '$user_id'") or die('query failed');
                $wishlist_num_rows = mysqli_num_rows($select_wishlist);

                $select_cart = mysqli_query($conn, "SELECT * FROM cart WHERE user_id = '$user_id'") or die('query failed');
                $cart_num_rows = mysqli_num_rows($select_cart);
            } else {
                $wishlist_num_rows = 0;
                $cart_num_rows = 0;
            }
            ?>
            
            <a href="wishlist.php"><i class="bi bi-heart"></i><span>(<?php echo $wishlist_num_rows; ?>)</span></a>
            <a href="cart.php"><i class="bi bi-cart"></i><span>(<?php echo $cart_num_rows; ?>)</span></a>
            <i class="bi bi-list" id="menu-btn"></i>
        </div>
    </div>  
</header>
<script type="text/javascript" src="js/script.js"></script>
</body>
</html>
