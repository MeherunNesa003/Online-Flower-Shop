<?php
    include 'connection.php';
    session_start();

    $user_id = $_SESSION['user_id'];
    if(!isset($user_id)){
        header('location:login.php');
    }
      /*------adding products to wishlist------*/
   
    /*------adding products to cart------*/
    if(isset($_POST['add_to_cart'])){

      $product_id = $_POST['product_id'];
      $product_name = $_POST['product_name'];
      $product_price = $_POST['product_price'];
      $product_image = $_POST['product_image'];
      $quantity = 1;

      $cart_number = mysqli_query($conn, "SELECT * FROM cart WHERE name ='$product_name' AND user_id='$user_id'") or die('query failed');

      if(mysqli_num_rows($cart_number)>0){
          $message[] = 'product already exist in cart';
      }else{
          $insert_product = mysqli_query($conn, "INSERT INTO cart(user_id,pid,name,price,quantity,image) 
          VALUES('$user_id','$product_id','$product_name', '$product_price','$quantity', '$product_image')");
          $_SESSION['message'] = 'product successfully added in cart';
          header("Location: ".$_SERVER['PHP_SELF']);
          exit();

      }
  }
  /*------delete product from wishlist------*/
   if (isset($_GET['delete'])) {
        $delete_id = $_GET['delete'];
       
        mysqli_query($conn, "DELETE FROM wishlist WHERE id = '$delete_id'") or die('query failed');
        header('location: wishlist.php');
    }
     /*------deleting all products from wishlist------*/
   if (isset($_GET['delete_all'])) {
       
        mysqli_query($conn, "DELETE FROM wishlist WHERE user_id = '$user_id'") or die('query failed');
        header('location: wishlist.php');
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
<?php include 'header.php';?>
<div class="bannerm">
    <h1>my wishlist</h1>
    <p>Saved with love—come back anytime to make them yours!</p>

</div>
<div class="shop">
  <h1 class="title">products added in the wishlist</h1>

  <?php
  if (isset($_SESSION['message'])) {
    echo '
    <div class="message">
        <span>' . $_SESSION['message'] . '</span>
        <i class="bi bi-x-circle" onclick="this.parentElement.remove()"></i>
    </div>
    ';
    unset($_SESSION['message']);
}
  ?>

  <div class="box-container">
    <?php
    $grand_total=0;
    $select_wishlist = mysqli_query($conn, "SELECT * FROM wishlist WHERE user_id='$user_id'") or die('query failed');
    if (mysqli_num_rows($select_wishlist) > 0) {
        while ($fetch_wishlist = mysqli_fetch_assoc($select_wishlist)) {
    ?>
        <form action="" method="post" class="box">
            <div class="icon">
                <a href="wishlist.php?delete=<?php echo $fetch_wishlist['id']; ?>" class="bi bi-x"></a>
                <a href="view_page.php?pid=<?php echo $fetch_wishlist['pid']; ?>" class="bi bi-eye-fill"></a>

            </div>
          <img src="image/<?php echo $fetch_wishlist['image']; ?>" alt="">
          <div class="price"><?php echo $fetch_wishlist['price']; ?>/-</div>
          <div class="name"><?php echo $fetch_wishlist['name']; ?></div>

          <input type="hidden" name="product_id" value="<?php echo $fetch_wishlist['id']; ?>">
          <input type="hidden" name="product_name" value="<?php echo $fetch_wishlist['name']; ?>">
          <input type="hidden" name="product_price" value="<?php echo $fetch_wishlist['price']; ?>">
          <input type="hidden" name="product_image" value="<?php echo $fetch_wishlist['image']; ?>">
          <button type="submit" name="add_to_cart" class="btn2">add to cart<i class="bi bi-cart"></i></button>
        </form>
    <?php   
        $grand_total+= $fetch_wishlist['price'];
        }
    } else {
        echo '<div class="empty">
                <img src="image/empty.jpeg" >
                <p>no product in your wishlist</p>
              </div>';
    }
    ?>
  <div class="wishlist_total">
        <p>total amount payable : <span>Tk <?php echo $grand_total ?>/-</span></p>
        <a href="shop.php">continue shopping</a>
        <a href="wishlist.php?delete_all" class="btn2 <?php echo ($grand_total >1)?'':'disabled' ?>" onclick="return 
        confirm('do you want to delete all from wishlist')">delete all</a>
  </div>
  </div>

</div>


<?php include 'footer.php';?>
<script type="text/javascript" src="js/script.js"></script>
</body>
</html>