<?php
    include 'connection.php';
    session_start();

    $user_id = isset($_SESSION['user_id']) ? $_SESSION['user_id'] : null;
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.2/font/bootstrap-icons.css">
    <link rel="stylesheet" type="text/css" href="css/main.css">
    <title>about</title>
</head>
<body>
<?php include 'header.php';?>
<div class="bannerm">
    <h1>about us</h1>
    <p>We are a passionate flower shop dedicated to bringing joy through fresh, handpicked blooms and beautifully crafted arrangements.</p>
</div>
<div class="about">
    <div class="row">
        <div class="detail">
            <h1>visit our beautiful showroom</h1>
            <p>Step into a world of color, fragrance, and elegance at our flower showroom.
               Discover hand-picked fresh blooms, beautifully curated arrangements, and seasonal 
               favorites—all crafted with love and creativity. Whether you're celebrating a special 
               moment or just brightening your day, our showroom is your perfect floral destination.</p>
            <a href="shop.php" class="btn2">shop now</a>

        </div>
        <div class="img-box">
            <img src="image/img1.jpeg">

        </div>
    </div>
</div>
<div class="banner-2">
    <h1>Let Us Make Your Wedding Flawless</h1>
    <a href="shop.php" class="btn2">shop now</a>
</div>
<div class="services">
    <h1 class="title">our services</h1>
    <div class="box-container">
      <div class="box">
        <i class="bi bi-percent"></i>
        <h3>30% DISCOUNT + FREE SHIPPING</h3>
        <p>Enjoy 30% off on selected flowers with free delivery across Bangladesh.</p>
      </div>
      <div class="box">
        <i class="bi bi-asterisk"></i>
        <h3>EXCLUSIVE FLOWER COLLECTION</h3>
        <p>Discover rare and seasonal blooms sourced locally and internationally.</p>
      </div>
      <div class="box">
        <i class="bi bi-alarm"></i>
        <h3>FAST DELIVERY SERVICE</h3>
        <p>We offer same-day flower delivery in Dhaka and nearby cities.</p>
       </div>
    </div>
</div>
<div class="stylist">
    <h1 class="title">Florial stylist</h1>
    <p>Meet the Team that makes miracles happen</p>
    <div class="box-container">
        <div class="box">
            <div class="img-box">
                <img src="image/st1.jpeg" >
                <div class="social-links">
                    <i class="bi bi-instagram"></i>
                    <i class="bi bi-youtube"></i>
                    <i class="bi bi-twitter"></i>
                    <i class="bi bi-whatsapp"></i>
                    <i class="bi bi-pinterest"></i>
                </div>
            </div>
            <h3>Labiba Rahman</h3>
            <p>Creative Director</p>
        </div>
        <div class="box">
            <div class="img-box">
                <img src="image/st2.jpeg" >
                <div class="social-links">
                    <i class="bi bi-instagram"></i>
                    <i class="bi bi-youtube"></i>
                    <i class="bi bi-twitter"></i>
                    <i class="bi bi-whatsapp"></i>
                    <i class="bi bi-pinterest"></i>
                </div>
            </div>
            <h3> Sayma Khanom</h3>
            <p> Lead Floral Stylist</p>
        </div>
        <div class="box">
            <div class="img-box">
                <img src="image/st3.jpeg" >
                <div class="social-links">
                    <i class="bi bi-instagram"></i>
                    <i class="bi bi-youtube"></i>
                    <i class="bi bi-twitter"></i>
                    <i class="bi bi-whatsapp"></i>
                    <i class="bi bi-pinterest"></i>
                </div>
            </div>
            <h3>Saifa Aroshi</h3>
            <p>Senior Artisan</p>
        </div>
    </div>
    <div class="testimonial-container">
        <h1 class="title"> what people say</h1>
        <div class="container">
            <div class="testimonial-item active">
                <img src="image/ano.jpeg">
                <h3>Rina Ahmed</h3>
                <p>"Absolutely beautiful flowers! They made my sister's wedding extra special.
                 I'll definitely order again!"</p>
            </div>
             <div class="testimonial-item">
                <img src="image/ano.jpeg">
                <h3>Farhan Chowdhury</h3>
                <p>"The bouquet was delivered on time and looked even better than the photos. 
                Great service and quality!"</p>
            </div>
             <div class="testimonial-item">
                <img src="image/ano.jpeg">
                <h3>Nusrat Jahan</h3>
                <p>"I'm impressed by the creativity and freshness of their arrangements.
                 The floral stylist understood exactly what I wanted."</p>
            </div>
            <div class="left-arrow" onclick="nextSlide()"><i class="bi bi-arrow-left"></i></div>
            <div class="right-arrow" onclick="prevSlide()"><i class="bi bi-arrow-right"></i></div>
        </div>

    </div>
</div>

<?php include 'footer.php';?>
<script type="text/javascript" src="js/script.js"></script>
</body>
</html>