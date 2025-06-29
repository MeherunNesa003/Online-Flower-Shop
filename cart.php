<?php
include 'connection.php';
session_start();

$user_id = $_SESSION['user_id'];
if (!isset($user_id)) {
    header('location:login.php');
}

/*------update products to cart------*/
if (isset($_POST['update_quantity_btn'])) {
    $update_quantity_id = $_POST['update_quantity_id'];
    $update_value = $_POST['update_quantity'];

    $update_query = mysqli_query($conn, "UPDATE cart SET quantity='$update_value' WHERE id = '$update_quantity_id'") or die('query failed');
    if ($update_query) {
        header('location:cart.php');
    }
}

/*------delete product from cart------*/
if (isset($_GET['delete'])) {
    $delete_id = $_GET['delete'];
    mysqli_query($conn, "DELETE FROM cart WHERE id = '$delete_id'") or die('query failed');
    header('location: cart.php');
}

/*------delete all products from cart------*/
if (isset($_GET['delete_all'])) {
    mysqli_query($conn, "DELETE FROM cart WHERE user_id = '$user_id'") or die('query failed');
    header('location: cart.php');
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
    <h1>my cart</h1>
    <p>Delight in your chosen flowers—edit or add more joy before you check out!</p>
</div>

<div class="shop">
    <h1 class="title">products added in the cart</h1>

    <?php
    if (isset($_SESSION['message'])) {
        echo '
        <div class="message">
            <span>' . $_SESSION['message'] . '</span>
            <i class="bi bi-x-circle" onclick="this.parentElement.remove()"></i>
        </div>';
        unset($_SESSION['message']);
    }
    ?>

    <div class="box-container">
        <?php
        $grand_total = 0;
        $select_cart = mysqli_query($conn, "SELECT * FROM cart WHERE user_id='$user_id'") or die('query failed');
        if (mysqli_num_rows($select_cart) > 0) {
            while ($fetch_cart = mysqli_fetch_assoc($select_cart)) {
                $price = (float)$fetch_cart['price'];
                $quantity = (int)$fetch_cart['quantity'];
                $item_total = $price * $quantity;
                $grand_total += $item_total;
        ?>
        <div class="box">
            <div class="icon">
                <a href="cart.php?delete=<?php echo $fetch_cart['id']; ?>" class="bi bi-x"></a>
                <a href="view_page.php?pid=<?php echo $fetch_cart['pid']; ?>" class="bi bi-eye-fill"></a>
            </div>
            <img src="image/<?php echo $fetch_cart['image']; ?>" alt="">
            <div class="price"><?php echo $fetch_cart['price']; ?>/-</div>
            <div class="name"><?php echo $fetch_cart['name']; ?></div>
            <form method="post">
                <input type="hidden" name="update_quantity_id" value="<?php echo $fetch_cart['id']; ?>">
                <div class="qty">
                    <input type="number" min="1" name="update_quantity" value="<?php echo $fetch_cart['quantity']; ?>">
                    <input type="submit" name="update_quantity_btn" value="update">
                </div>
            </form>
            <div class="total_amt">
                Total Amount : <span><?php echo $item_total; ?>/-</span>
            </div>
        </div>
        <?php
            }
        } else {
            echo '
            <div class="empty">
                <img src="image/empty.jpeg">
                <p>no product in your cart</p>
            </div>';
        }
        ?>

        <div class="wishlist_total">
            <p>total amount payable : <span>Tk <?php echo $grand_total; ?>/-</span></p>
            <a href="shop.php" class="btn2">continue shopping</a>
            <a href="checkout.php" class="btn2">checkout</a>
            <div>
            <a href="cart.php?delete_all" class="btn2 <?php echo ($grand_total > 1) ? '' : 'disabled'; ?>" onclick="return confirm('do you want to delete all from cart')">delete all</a>
            </div>
        </div>
    </div>
</div>

<?php include 'footer.php'; ?>
<script type="text/javascript" src="js/script.js"></script>
</body>
</html>
