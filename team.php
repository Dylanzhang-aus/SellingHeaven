<?php
  session_start();
  require 'vendor/autoload.php';
  date_default_timezone_set('UTC');
  use Aws\DynamoDb\DynamoDbClient;
  session_start();
  $Dbclient = new DynamoDbClient([
    'region' => 'us-east-1',
    'version' => 'latest',
    'credentials' => [
           'key' => '******',
           'secret' => '*****'
    ],
 ]);
?>
<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="utf-8">
  <meta content="width=device-width, initial-scale=1.0" name="viewport">

  <title>Team - SellingHeaven</title>
  <meta content="" name="description">
  <meta content="" name="keywords">

  <link rel="icon" type="image/png" href="images/icons/favicon.ico"/>

  <link href="https://fonts.googleapis.com/css?family=Open+Sans:300,300i,400,400i,600,600i,700,700i|Roboto:300,300i,400,400i,500,500i,600,600i,700,700i|Poppins:300,300i,400,400i,500,500i,600,600i,700,700i" rel="stylesheet">

  <link href="assets/vendor/animate.css/animate.min.css" rel="stylesheet">
  <link href="assets/vendor/aos/aos.css" rel="stylesheet">
  <link href="assets/vendor/bootstrap/css/bootstrap.min.css" rel="stylesheet">
  <link href="assets/vendor/bootstrap-icons/bootstrap-icons.css" rel="stylesheet">
  <link href="assets/vendor/boxicons/css/boxicons.min.css" rel="stylesheet">
  <link href="assets/vendor/glightbox/css/glightbox.min.css" rel="stylesheet">
  <link href="assets/vendor/remixicon/remixicon.css" rel="stylesheet">
  <link href="assets/vendor/swiper/swiper-bundle.min.css" rel="stylesheet">

  <link href="assets/css/style.css" rel="stylesheet">
 
</head>

<body>

  <header id="header" class="fixed-top">
    <div class="container d-flex align-items-center">

      <h1 class="logo me-auto"><a href="home.php"><span>Selling</span>Heaven</a></h1>

      <nav id="navbar" class="navbar order-last order-lg-0">
        <ul>
          <li><a href="home.php">Home</a></li>

          <li class="dropdown"><a class="active" href="#"><span>About</span> <i class="bi bi-chevron-down"></i></a>
            <ul>
              <li><a href="team.php" class="active">Team</a></li> 
            </ul>
          </li>

          <li><a href="products.php">Products</a></li>
          <?php 
             if($_SESSION['useremail'] == null){    
          ?>
          <li><a href="login.php">Login</a></li>
          <li><a href="register.php">Sign up</a></li>
          <?php
             }
             else
             {
          ?>
           <li><a href="orders.php">Orders</a></li>
            <li><a href="logout.php">Logout</a></li>
            <li><a href="#"><?php echo $_SESSION['user_name']; ?></a></li>
            <li><a></a></li>
            <?php
             }
           ?>
        </ul>
        <i class="bi bi-list mobile-nav-toggle"></i>
      </nav>
       
      <?php if($_SESSION['useremail'] != null){ 
        echo "<div class='header-social d-flex'>";
         echo   "<img src='".$_SESSION['user_image']."' class='avatar' alt='user image'>";
        echo "</div>";
      }?>

    </div>
  </header>

  <main id="main">

    <section id="breadcrumbs" class="breadcrumbs">
      <div class="container">

        <div class="d-flex justify-content-between align-items-center">
          <h2>Team</h2>
          <ol>
            <li><a href="home.php">Home</a></li>
            <li>Team</li>
          </ol>
        </div>

      </div>
    </section>

<section id="team" class="team section-bg">
  <div class="container">

    <div class="section-title" data-aos="fade-up">
      <h2>Our <strong>Team</strong></h2>
      <p>Currently we only have two developers on the project, so if you want to join us, please contact us using the contact information at the bottom left corner of the website.</p>
    </div>

    <div class="row">

      <div class="col-lg-3 col-md-6 d-flex align-items-stretch">
        <div class="member" data-aos="fade-up">
          <div class="member-img">
            <img src="https://a3-team-image.s3.amazonaws.com/Han.jpg" class="img-fluid" alt="">
          </div>
          <div class="member-info">
            <h4>Hanyuan Zhang</h4>
            <span>System architect</span>
          </div>
        </div>
      </div>

      <div class="col-lg-3 col-md-6 d-flex align-items-stretch">
        <div class="member" data-aos="fade-up" data-aos-delay="100">
          <div class="member-img">
            <img src="https://a3-team-image.s3.amazonaws.com/Nam.jpg" class="img-fluid" alt="">
          </div>
          <div class="member-info">
            <h4>Vu Nam Bui</h4>
            <span>System developer</span>
          </div>
        </div>
      </div>

    </div>

  </div>
</section>

</main>

<footer id="footer">

<div class="footer-top">
  <div class="container">
    <div class="row">

      <div class="col-lg-3 col-md-6 footer-contact">
        <h3>SELLING HEAVEN</h3>
        <p>
          124 La Trobe Street <br>
          Melbourne, VIC 3000<br>
          Australia <br><br>
          <strong>Phone:</strong> +61 0123 4567 89<br>
          <strong>Email:</strong> s3757573@student.rmit.edu.au<br>
        </p>
      </div>

      <div class="col-lg-2 col-md-6 footer-links">
        <h4>Useful Links</h4>
        <ul>
          <li><i class="bx bx-chevron-right"></i> <a href="home.php">Home</a></li>
          <li><i class="bx bx-chevron-right"></i> <a href="team.php">Teams</a></li>
          <li><i class="bx bx-chevron-right"></i> <a href="products.php">Products</a></li>
        </ul>
      </div>

      <div class="col-lg-3 col-md-6 footer-links">
        <h4>Our Services</h4>
        <ul>
          <li><i class="bx bx-chevron-right"></i> <a href="#">AWS Lambda</a></li>
          <li><i class="bx bx-chevron-right"></i> <a href="#">Amazon S3</a></li>
          <li><i class="bx bx-chevron-right"></i> <a href="#">AWS Elastic Beanstalk</a></li>
          <li><i class="bx bx-chevron-right"></i> <a href="#">AWS API Gateway</a></li>
          <li><i class="bx bx-chevron-right"></i> <a href="#">AWS DynamoDB</a></li>
        </ul>
      </div>

      <div class="col-lg-3 col-md-6 footer-links">
      <h4>Join us</h4>
        <ul>
          <li><i class="bx bx-chevron-right"></i> <a href="register.php">Sign up</a></li>
        </ul>
      </div>

    </div>
  </div>
</div>

<div class="container d-md-flex py-4">

  <div class="me-md-auto text-center text-md-start">
    <div class="copyright">
      &copy; Copyright <strong><span>RMIT</span></strong>. Cloud computing assignment 3 deveployment team
    </div>
  </div>
  <div class="social-links text-center text-md-right pt-3 pt-md-0">
    <a href="https://twitter.com" class="twitter"><i class="bx bxl-twitter"></i></a>
    <a href="https://www.facebook.com" class="facebook"><i class="bx bxl-facebook"></i></a>
    <a href="https://www.instagram.com" class="instagram"><i class="bx bxl-instagram"></i></a>
    <a href="https://www.linkedin.com" class="linkedin"><i class="bx bxl-linkedin"></i></a>
  </div>
</div>
</footer>

<a href="#" class="back-to-top d-flex align-items-center justify-content-center"><i class="bi bi-arrow-up-short"></i></a>

  <script src="assets/vendor/aos/aos.js"></script>
  <script src="assets/vendor/bootstrap/js/bootstrap.bundle.min.js"></script>
  <script src="assets/vendor/glightbox/js/glightbox.min.js"></script>
  <script src="assets/vendor/isotope-layout/isotope.pkgd.min.js"></script>
  <script src="assets/vendor/php-email-form/validate.js"></script>
  <script src="assets/vendor/swiper/swiper-bundle.min.js"></script>
  <script src="assets/vendor/waypoints/noframework.waypoints.js"></script>

  <script src="assets/js/main.js"></script>

</body>

</html>
