<?php
include 'connection.php';

if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

$user_id = isset($_SESSION['user_id']) ? $_SESSION['user_id'] : 0;

// Logout 
if (isset($_POST['logout'])) {
    session_destroy();
    header('location:login.php');
    exit();
}

/*------ Add to Wishlist ------*/
if (isset($_POST['add_to_wishlist'])) {
    if ($user_id == 0) {
        $message[] = 'Please login to add items to wishlist.';
    } else {
        $product_id = $_POST['product_id'];
        $product_name = $_POST['product_name'];
        $product_price = $_POST['product_price'];
        $product_image = $_POST['product_image'];

        $wishlist_number = mysqli_query($conn, "SELECT * FROM wishlist WHERE name ='$product_name' AND user_id='$user_id'") or die('query failed');
        $cart_number = mysqli_query($conn, "SELECT * FROM cart WHERE name ='$product_name' AND user_id='$user_id'") or die('query failed');

        if (mysqli_num_rows($wishlist_number) > 0) {
            $message[] = 'Product already exists in wishlist';
        } elseif (mysqli_num_rows($cart_number) > 0) {
            $message[] = 'Product already exists in cart';
        } else {
            mysqli_query($conn, "INSERT INTO wishlist(user_id, pid, name, price, image) 
                VALUES('$user_id', '$product_id', '$product_name', '$product_price', '$product_image')");
            $message[] = 'Product successfully added to wishlist';
            header("Location: " . $_SERVER['PHP_SELF']);
            exit();
        }
    }
}

/*------ Add to Cart ------*/
if (isset($_POST['add_to_cart'])) {
    if ($user_id == 0) {
        $message[] = 'Please login to add items to cart.';
    } else {
        $product_id = $_POST['product_id'];
        $product_name = $_POST['product_name'];
        $product_price = $_POST['product_price'];
        $product_image = $_POST['product_image'];
        $product_quantity = $_POST['product_quantity'];

        $cart_number = mysqli_query($conn, "SELECT * FROM cart WHERE name ='$product_name' AND user_id='$user_id'") or die('query failed');

        if (mysqli_num_rows($cart_number) > 0) {
            $message[] = 'Product already exists in cart';
        } else {
            mysqli_query($conn, "INSERT INTO cart(user_id, pid, name, price, quantity, image) 
                VALUES('$user_id', '$product_id', '$product_name', '$product_price', '$product_quantity', '$product_image')");
            $message[] = 'Product successfully added to cart';
            header("Location: " . $_SERVER['PHP_SELF']);
            exit();
        }
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Flower Shop</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.2/font/bootstrap-icons.css">
    <link rel="stylesheet" href="css/main.css">
</head>
<body>

<?php include 'header.php'; ?>

<div class="slider-section">
    <div class="slide-show-container">
        <div class="wraper wraper-one">
            <div class="wraper-text">"Inspired by nature, bringing you the freshest blooms straight from the garden."</div>
        </div>
        <div class="wraper wraper-two">
            <div class="wraper-text">"Let nature's beauty brighten your space with vibrant flowers."</div>
        </div>
        <div class="wraper wraper-three">
            <div class="wraper-text">"Fresh flowers for you, making every moment blossom with joy."</div>
        </div>
    </div>
</div>

<div class="row">
    <div class="card"><div class="detail"><span>30% OFF TODAY</span><h1>simple & elegant</h1><a href="shop.php">shop now</a></div></div>
    <div class="card"><div class="detail"><span>30% OFF TODAY</span><h1>simple & elegant</h1><a href="shop.php">shop now</a></div></div>
    <div class="card"><div class="detail"><span>30% OFF TODAY</span><h1>simple & elegant</h1><a href="shop.php">shop now</a></div></div>
</div>

<div class="categories">
    <h1 class="title">TOP CATEGORIES</h1>
    <div class="box-container">
        <div class="box"><img src="image/categ3.jpeg"><span>birthday</span></div>
        <div class="box"><img src="image/categ4.jpeg"><span>best day</span></div>
        <div class="box"><img src="image/categ1.jpeg"><span>Special</span></div>
        <div class="box"><img src="image/categ2.jpeg"><span>wedding</span></div>
        <div class="box"><img src="image/categ5.jpeg"><span>sympathy</span></div>
    </div>
</div>

<div class="banner">
    <div class="detail">
        <span>BETTER THAN CAKE</span>
        <h1>BIRTHDAY BOUQS <i class="bi bi-balloon-heart"></i></h1>
        <p class="bi bi-heart">Celebrate with party-ready blooms! <i class="bi bi-heart"></i></p>
        <a href="shop.php">explore <i class="bi bi-bag-heart"></i> <i class="bi bi-arrow-right"></i></a>
    </div>
</div>

<div class="shop">
    <h1 class="title">shop best sellers</h1>

    <?php
    if (isset($message)) {
        foreach ($message as $msg) {
            echo '<div class="message"><span>' . $msg . '</span><i class="bi bi-x-circle" onclick="this.parentElement.remove()"></i></div>';
        }
    }
    ?>

    <div class="box-container">
        <?php
        $select_products = mysqli_query($conn, "SELECT * FROM products") or die('query failed');
        if (mysqli_num_rows($select_products) > 0) {
            while ($fetch_products = mysqli_fetch_assoc($select_products)) {
        ?>
        <form action="" method="post" class="box">
            <img src="image/<?php echo $fetch_products['image']; ?>" alt="">
            <div class="price"><?php echo $fetch_products['price']; ?>/-</div>
            <div class="name"><?php echo $fetch_products['name']; ?></div>

            <input type="hidden" name="product_id" value="<?php echo $fetch_products['id']; ?>">
            <input type="hidden" name="product_name" value="<?php echo $fetch_products['name']; ?>">
            <input type="hidden" name="product_price" value="<?php echo $fetch_products['price']; ?>">
            <input type="hidden" name="product_quantity" value="1">
            <input type="hidden" name="product_image" value="<?php echo $fetch_products['image']; ?>">

            <div class="icon">
                <a href="view_page.php?pid=<?php echo $fetch_products['id']; ?>" class="bi bi-eye-fill"></a>
                <?php if ($user_id == 0): ?>
                    <button type="button" onclick="alert('Please login to add to wishlist');" class="bi bi-heart"></button>
                    <button type="button" onclick="alert('Please login to add to cart');" class="bi bi-cart"></button>
                <?php else: ?>
                    <button type="submit" name="add_to_wishlist" class="bi bi-heart"></button>
                    <button type="submit" name="add_to_cart" class="bi bi-cart"></button>
                <?php endif; ?>
            </div>
        </form>
        <?php
            }
        } else {
            echo '<p class="empty">No products added yet!</p>';
        }
        ?>
    </div>

    <div class="more">
        <a href="shop.php"><i class="bi bi-arrow-down"></i></a>
    </div>
</div>

<?php include 'footer.php'; ?>
<script src="js/script.js"></script>
</body>
</html>
