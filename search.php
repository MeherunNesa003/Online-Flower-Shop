<?php
include 'connection.php';
session_start();

$user_id = $_SESSION['user_id'] ?? null;

$query = '';
$result = false;

if (isset($_GET['query']) && !empty(trim($_GET['query']))) {
    $query = mysqli_real_escape_string($conn, $_GET['query']);
    $result = mysqli_query($conn, "SELECT * FROM products WHERE name LIKE '%$query%' OR product_details LIKE '%$query%'") or die('Search query failed');
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Search Results</title>
    <link rel="stylesheet" href="css/main.css">
</head>
<body>
<?php include 'header.php'; ?>

<div>
    <h1>Search results for: <span><?= htmlspecialchars($query) ?></span></h1>
    <p>Browse through products that match your search.</p>
</div>

<div class="product-container">
    <?php
    if ($result && mysqli_num_rows($result) > 0) {
        while ($product = mysqli_fetch_assoc($result)) {
            ?>
            <div class="product-box">
                <img src="image/<?= $product['image']; ?>" alt="<?= $product['name']; ?>">
                <h3><?= $product['name']; ?></h3>
                <p>TK<?= $product['price']; ?></p>
                <a href="view_page.php?pid=<?php echo $product['id']; ?>" class="btn">View</a>
            </div>
            <?php
        }
    } elseif ($query != '') {
        echo '<p class="empty">No products found!</p>';
    } else {
        echo '<p class="empty">Please enter a search term.</p>';
    }
    ?>
</div>

<?php include 'footer.php'; ?>
<script src="js/script.js"></script>
</body>
</html>
