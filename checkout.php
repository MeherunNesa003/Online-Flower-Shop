<?php
include 'connection.php';
date_default_timezone_set('Asia/Dhaka');
session_start();

$user_id = $_SESSION['user_id'];
if (!isset($user_id)) {
    header('location:login.php');
} 
/*------------order placed-----------*/
if(isset($_POST['order-btn'])) {
    $name = mysqli_real_escape_string($conn, $_POST['name']);
    $number = mysqli_real_escape_string($conn, $_POST['number']);
    $email = mysqli_real_escape_string($conn, $_POST['email']);
    $method = mysqli_real_escape_string($conn, $_POST['method']);
    $address = mysqli_real_escape_string($conn, $_POST['region'] . ',' . $_POST['city'] . ',' . $_POST['district'] . ',' . $_POST['code']);
    $placed_on = date('Y-m-d H:i:s');

    $cart_total = 0;
    $cart_products = array(); 
    $cart_query = mysqli_query($conn, "SELECT * FROM cart WHERE user_id = '$user_id'") or die('query failed');

    if(mysqli_num_rows($cart_query) > 0) {
        while($cart_item = mysqli_fetch_assoc($cart_query)) {
            $cart_products[] = $cart_item['name'] . ' (' . $cart_item['quantity'] . ')';
            $sub_total = $cart_item['price'] * $cart_item['quantity'];
            $cart_total += $sub_total;
        }

        $total_products = implode(', ', $cart_products);

        mysqli_query($conn, "INSERT INTO orders (user_id, name, number, email, method, address, total_products, total_price, placed_on) 
        VALUES ('$user_id', '$name', '$number', '$email', '$method', '$address', '$total_products', '$cart_total', '$placed_on')") or die('Order insert failed');

        // Clear cart
        mysqli_query($conn, "DELETE FROM cart WHERE user_id = '$user_id'") or die('Cart clear failed');

        $message[] = 'Order placed successfully';
        header('Location: checkout.php');
        exit();
    } else {
        $message[] = 'Your cart is empty. Cannot place order.';
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
    <h1>checkout page</h1>
    <p>Securely complete your purchase and get ready to receive your beautiful blooms on time.</p>
</div>
<div class="checkout-form">
    <h1 class="title">payment process</h1>
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
    <div class="display-order">
        <?php
        $select_cart = mysqli_query($conn, "SELECT * FROM cart WHERE user_id='$user_id'") or die('query failed');
        $total=0;
        $grand_total=0;
        if (mysqli_num_rows($select_cart)>0) {
            while($fetch_cart=mysqli_fetch_assoc($select_cart)){
                $total_price =($fetch_cart['price'] * $fetch_cart['quantity']);
                $grand_total = $total += $total_price;
        ?>
        <div class="order-item"><?= $fetch_cart['name']; ?> (<?= $fetch_cart['quantity']; ?>)</div>
        <?php
            }
        };
        ?>
    <div class="grand_total">Total Amount Payable: TK <?= $grand_total; ?>/-</div>
    </div>
    <form method="post">
        <div class="input-field">
                <label>your name</label>
                <input type="text" name="name" placeholder="enter your name">
            </div>
             <div class="input-field">
                <label>your number</label>
                <input type="number" name="number" placeholder="enter your number">
            </div>
             <div class="input-field">
                <label>your email</label>
                <input type="text" name="email" placeholder="enter your email">
            </div>
             <div class="input-field">
                <label>select payment method</label>
                <select name="method">
                    <option selected disabled>select payment method</option>
                    <option class="cash on delivery">cash on delivery</option>
                    <option class="credit card">credit card</option>
                    <option class="Bkash">Bkash</option>
                    <option class="Nagad">Nagad</option>
                </select>
            </div>
            <div class="input-field">
                <label>Region</label>
                <input type="text" name="region" placeholder="e.g Dhaka">
            </div>
            <div class="input-field">
                <label>City</label>
                <input type="text" name="city" placeholder="e.g Narayanganj">
            </div>
            <div class="input-field">
                <label>District</label>
                <input type="text" name="district" placeholder="e.g Nobiganj">
            </div>
            <div class="input-field">
                <label>Address</label>
                <input type="text" name="address" placeholder="House no./building/street/area">
            </div>
            <div class="input-field">
                <label>Postal code</label>
                <input type="text" name="code" placeholder="e.g 1412">
            </div>
            <input type="submit" name="order-btn" class="btn" value="order now">
            
    </form>

</div>

<?php include 'footer.php'; ?>
<script type="text/javascript" src="js/script.js"></script>
</body>
</html>