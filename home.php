<?php
    require 'vendor/autoload.php';
    date_default_timezone_set('UTC');
    use Aws\DynamoDb\DynamoDbClient;
    session_start();
    $Dbclient = new DynamoDbClient([
      'region' => 'us-east-1',
      'version' => 'latest',
      'credentials' => [
             'key' => '*****',
             'secret' => '******'
      ],
   ]);

   function CheckOrder($id){
    global $Dbclient;
    $orders = $Dbclient->getIterator('Scan', [
      'TableName' => 'order'
     ]);
     
     foreach($orders as $order){
       if($order['product_id']['N'] == $id)
       {
          return true;
       }
      }
      return false;
   }
?>


<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="utf-8">
  <meta content="width=device-width, initial-scale=1.0" name="viewport">

  <title>Selling Heaven</title>
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
  <link href="images/icons">

  <link href="assets/css/style.css" rel="stylesheet">
</head>

<body>


  <header id="header" class="fixed-top">
    <div class="container d-flex align-items-center">

      <h1 class="logo me-auto"><a href="index.html"><span>Selling</span>Heaven</a></h1>
      
      <nav id="navbar" class="navbar order-last order-lg-0">
        <ul>
          <li><a href="home.php" class="active">Home</a></li>

          <li class="dropdown"><a href="#"><span>About</span> <i class="bi bi-chevron-down"></i></a>
            <ul>
              <li><a href="team.php">Team</a></li>       
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
             else{
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


  <section id="hero">
    <div id="heroCarousel" data-bs-interval="5000" class="carousel slide carousel-fade" data-bs-ride="carousel">

      <div class="carousel-inner" role="listbox">

       
        <div class="carousel-item active" style="background-image: url(assets/img/slide/handshake.jpg);">
          <div class="carousel-container">
            <div class="carousel-content animate__animated animate__fadeInUp">
              <h2>Welcome to <span>SellingHeaven</span></h2>
              <p>We try to suggest a community that belongs only to us. As a user, you can buy any product that is mounted here in our community. If you like it, you can leave us a message and let us know if you are interested in our products. We will try our best to preserve it and correct more chances for you.</p>
              <div class="text-center"><a href="register.php" class="btn-get-started">Join us</a></div>
            </div>
          </div>
        </div>

        
        <div class="carousel-item" style="background-image: url(assets/img/slide/sell.jpg);">
          <div class="carousel-container">
          </div>
        </div>

       
        <div class="carousel-item" style="background-image: url(assets/img/slide/sell2.jpg);">
          <div class="carousel-container">
          </div>
        </div>

      </div>

      <a class="carousel-control-prev" href="#heroCarousel" role="button" data-bs-slide="prev">
        <span class="carousel-control-prev-icon bi bi-chevron-left" aria-hidden="true"></span>
      </a>

      <a class="carousel-control-next" href="#heroCarousel" role="button" data-bs-slide="next">
        <span class="carousel-control-next-icon bi bi-chevron-right" aria-hidden="true"></span>
      </a>

      <ol class="carousel-indicators" id="hero-carousel-indicators"></ol>

    </div>
  </section>

  <main id="main">

    <section id="services" class="services section-bg">
      
      <div class="container" data-aos="fade-up">

        <div class="row">
          <div class="col-lg-4 col-md-6 d-flex align-items-stretch" data-aos="zoom-in" data-aos-delay="100">
            <div class="icon-box iconbox-blue">
              <div class="icon">
              <img src="/images/icons/lambda.png" />
              </div>
              <h4><a href="">Aws Lambda</a></h4>
              <p>We create the function in this server to resize the image which user uploaded</p>
            </div>
          </div>

          <div class="col-lg-4 col-md-6 d-flex align-items-stretch mt-4 mt-md-0" data-aos="zoom-in" data-aos-delay="200">
            <div class="icon-box iconbox-orange ">
              <div class="icon">
                <img src="/images/icons/elastic.png" />
              </div>
              <h4><a href="">Aws Elastic Beanstalk</a></h4>
              <p>We create our application in local environment and deploy the application by using this server</p>
            </div>
          </div>

          <div class="col-lg-4 col-md-6 d-flex align-items-stretch mt-4 mt-lg-0" data-aos="zoom-in" data-aos-delay="300">
            <div class="icon-box iconbox-pink">
              <div class="icon">    
                <img src="/images/icons/dynamodb.png" />
              </div>
              <h4><a href="">Aws DynamoDb</a></h4>
              <p>We use this server to store all the data about user in our system</p>
            </div>
          </div>

          <div class="col-lg-4 col-md-6 d-flex align-items-stretch mt-4" data-aos="zoom-in" data-aos-delay="100">
            <div class="icon-box iconbox-yellow">
              <div class="icon">
                <img src="/images/icons/s3.png" />
              </div>
              <h4><a href="">Amazon S3</a></h4>
              <p>We use this service to store all static files, such as user images and processed images</p>
            </div>
          </div>

          <div class="col-lg-4 col-md-6 d-flex align-items-stretch mt-4" data-aos="zoom-in" data-aos-delay="200">
            <div class="icon-box iconbox-red">
              <div class="icon">
                <img src="/images/icons/api.png" />
              </div>
              <h4><a href="">Aws API Gateway</a></h4>
              <p>We use this service to generate specific APIs to retrieve data from the database based on our own requirements</p>
            </div>
          </div>
        </div>
      </div>
    </section>

    <section id="portfolio" class="portfolio">
      <div class="container">

        <div class="row" data-aos="fade-up">
          <div class="col-lg-12 d-flex justify-content-center">
            <ul id="portfolio-flters">
              <li data-filter="*" class="filter-active">Available Products</li>
            </ul>
          </div>
        </div>

        <div class="row portfolio-container" data-aos="fade-up">

        <?php 
               $tableName = 'products';
               $iterator = $Dbclient->getIterator('Scan', [
                        'TableName' => $tableName
                        ]);
              foreach($iterator as $item)
              {
                if(CheckOrder($item['id']['N']) == false)
                {
                   $product = $Dbclient->getItem(array(
                             'ConsistentRead' => true,
                             'TableName' => $tableName,
                             'Key' => array(
                                'id' => array('N' => $item['id']['N'])
                             )));
                   $imageUrl = $product['Item']['image']['S'];              
             
                 echo "<div class='col-lg-4 col-md-6 portfolio-item filter-app'>";
                 echo "<img src='".$imageUrl."' class='img-fluid' alt=''>";
                 echo "<div class='portfolio-info'>";
                 echo "<h4>".$product['Item']['product_name']['S']."</h4>";
                 echo "<p>$ ".$product['Item']['price']['N']."</p>";
                 echo "<p>".$product['Item']['label']['S']."</p>";
                 echo "<a href='".$imageUrl."' data-gallery='portfolioGallery' class='portfolio-lightbox preview-link' title='".$product['Item']['product_name']['S']."'><i class='bi bi-card-image'></i></a>";
                 echo "</div>";
                 echo "</div>";
                }
              }
          ?>  
       
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
              <li><i class="bx bx-chevron-right"></i> <a href="home.php" class="active">Home</a></li>
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
