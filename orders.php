<?php
  session_start();
  require 'vendor/autoload.php';
  date_default_timezone_set('UTC');
  use Aws\DynamoDb\DynamoDbClient;

  $Dbclient = new DynamoDbClient([
    'region' => 'us-east-1',
    'version' => 'latest',
    'credentials' => [
           'key' => 'AKIAQASP6GPXRZZAJ4FS',
           'secret' => '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'
    ],
 ]);

   function GetOrders()
   {
      global $Dbclient;
      $orders = $Dbclient->getIterator('Scan', [
                    'TableName' => 'order'
                ]);
      $orderBox = array();
      foreach($orders as $order)
      {
          if($order['user_email']['S'] == $_SESSION['useremail'])
          {
               array_push($orderBox,$order);
          }
      }
      return $orderBox;
   }
?>
<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="utf-8">
  <meta content="width=device-width, initial-scale=1.0" name="viewport">

  <title>Orders - SellingHeaven</title>
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
             else
             {
          ?>
           <li><a href="orders.php" class="active">Orders</a></li>
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
          <h2>Orders</h2>
          <ol>
            <li><a href="home.php">Home</a></li>
            <li>Orders</li>
          </ol>
        </div>

      </div>
    </section>

    <section id="pricing" class="pricing">
      <div class="container" data-aos="fade-up"> 
        <div class="row" >
          
          <?php 
              $orders = GetOrders();
              if(count($orders) != 0)
              {
                foreach($orders as $order)
                {
                    if($order['isPaid'] == false){
          ?>
          <div class="col-lg-3 col-md-6 mt-4 mt-md-0">
            <div class="box featured">
            <span class="advanced">
                <a href="deleteOrder.php?id=<?php echo $order['product_id']['N'];?>">
                    <i class="bi bi-trash-fill" style="color:#00001a;"></i>        
                </a>
            </span>
              <h3>
                  <?php echo $order['product_name']['S'];?>
              </h3>
              <h4><sup>$</sup><?php echo $order['price']['N'];?></h4>
              <?php echo "<img src='".$order['product_image']['S']."' width='250' height='300'>";?>
              <div class="btn-wrap">
                <a href="payment.php?id=<?php echo $order['product_id']['N'];?>" class="btn-buy">Pay Now</a>
              </div>
            </div>
          </div>
         <?php }
         else{
         ?>
           
           <div class="col-lg-3 col-md-6 mt-4 mt-md-0">
            <div class="box featuredPaid">
            <span class="advancedPaid">Paid</span>
              <h3>
                  <?php echo $order['product_name']['S'];?>
              </h3>
              <h4><sup>$</sup><?php echo $order['price']['N'];?></h4>
              <?php echo "<img src='".$order['product_image']['S']."' width='250' height='300'>";?>
              <div class="btn-wrap">
              <div style="font-size: 25px;">
                     .....<i class="bi bi-truck" title="The product is delivering"></i>
                 </div>
              </div>
            </div>
          </div>
        
        <?php }}} else {?>
          <p>You have no order now.</p>      
         <?php } ?>
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
          <li><i class="bx bx-chevron-right"></i> <a href="products.php" class="active">Products</a></li>
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