<?php
  session_start();
  require 'vendor/autoload.php';
  date_default_timezone_set('UTC');
  use Aws\DynamoDb\DynamoDbClient;
  use Aws\DynamoDb\Marshaler;
  session_start();
  $Dbclient = new DynamoDbClient([
    'region' => 'us-east-1',
    'version' => 'latest',
    'credentials' => [
           'key' => '******',
           'secret' => '*******'
    ],
 ]);

 $products = $Dbclient->getIterator('Scan', [
  'TableName' => 'products'
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


 foreach($products as $item)
 {
     if(isset($_POST[$item['id']['N']]))
     {
        $url = "https://h6dj8ltf6l.execute-api.us-east-1.amazonaws.com/createOrder/order";    
					$data = json_encode([
						"user_email" => $_SESSION['useremail'],
            "product_id" => $item['id']['N'],
						"price" => $item['price']['N'],
						"product_image" => $item['image']['S'],
            "product_name" => $item['product_name']['S']
					]);
					$curl = curl_init($url);
					curl_setopt($curl, CURLOPT_HEADER, false);
					curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
					curl_setopt($curl, CURLOPT_HTTPHEADER, array("Content-type: application/json"));
					curl_setopt($curl, CURLOPT_POST, true);
					curl_setopt($curl, CURLOPT_POSTFIELDS, $data);
					curl_exec($curl);
					curl_close($curl);
     }
 }
?>
<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="utf-8">
  <meta content="width=device-width, initial-scale=1.0" name="viewport">

  <title>Products - SellingHeaven</title>
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

          <li><a href="products.php" class="active">Products</a></li>
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
          <h2>Products</h2>
          <ol>
            <li><a href="home.php">Home</a></li>
            <li>Products</li>
          </ol>
        </div>

      </div>
    </section>

    <section id="blog" class="blog">
      <div class="container" data-aos="fade-up">

        <div class="row">

          <div class="col-lg-8 entries">
          <?php 
               $tableName = 'products';
               
               if(isset($_POST['search']) == false)
               {
               
                   $iterator = $Dbclient->getIterator('Scan', [
                                'TableName' => $tableName
                               ]);
                   foreach($iterator as $item)
                   {
                          $product = $Dbclient->getItem(array(
                                 'ConsistentRead' => true,
                                 'TableName' => $tableName,
                                  'Key' => array(
                                  'id' => array('N' => $item['id']['N'])
                                  )));
                           $imageUrl = $product['Item']['image']['S'];   
                   
                      if(CheckOrder($item['id']['N']) == false)
                      {
            ?>  
            
            <article class="entry">
            
              <div class="entry-img">
                <?php echo "<img src='".$imageUrl."'alt='' width='855' height='700'>";?>
              </div>

              <h2 class="entry-title">
                <a href=""><?php echo $product['Item']['product_name']['S'];?> &nbsp;</a>
                <?php echo "<a href='".$imageUrl."' data-gallery='portfolioGallery' class='portfolio-lightbox preview-link' ><i class='bi bi-card-image'></i></a>"; ?>
              </h2>

              <div class="entry-meta">
                <ul>
                  <li class="d-flex align-items-center"><i class="bi bi-person"></i> <a href=""><?php echo $product['Item']['creator_name']['S'];?></a></li>
                  <li class="d-flex align-items-center"><i class="bi bi-clock"></i> <a href=""><?php echo $product['Item']['date']['S'];?></a></li>
                  <li class="d-flex align-items-center"><i class="bi bi-currency-dollar"></i> <a href=""><?php echo $product['Item']['price']['N'];?></a></li>
                </ul>
              </div>

              <div class="entry-content">
                <p>
                <?php echo $product['Item']['description']['S'];?>
                </p>

                <?php if($_SESSION['useremail'] != null){ ?>
                <div class="read-more">
                <form method="POST"> 
                <?php echo "<input type='submit' id='".$product['Item']['id']['N']."' name='".$product['Item']['id']['N']."' value='Buy now'>"; ?>
               </form>
              </div>
              <?php } ?>

              </div>   
            </article>
            <?php }}} 
            
            else {
                                   
                      $iterator = $Dbclient->getIterator('Scan', array(
                                    'TableName'     => $tableName,
                                    'ScanFilter' => array(
                                        'product_name' => array(
                                            'AttributeValueList' => array(
                                                array('S' => $_POST['p_name'])
                                            ),
                                            'ComparisonOperator' => 'CONTAINS'
                                        )
                                    )
                                ));
                     
                  foreach($iterator as $item)
                  {     
                           
                     if(CheckOrder($item['id']['N']) == false)
                     {  
              ?>
     
           <article class="entry">
            
              <div class="entry-img">
                <?php echo "<img src='".$item['image']['S']."'alt='' width='855' height='700'>";?>
              </div>

              <h2 class="entry-title">
                <a href=""><?php echo $item['product_name']['S'];?>&nbsp;</a>
                <?php echo "<a href='".$item['image']['S']."' data-gallery='portfolioGallery' class='portfolio-lightbox preview-link' ><i class='bi bi-card-image'></i></a>"; ?>
              </h2>

              <div class="entry-meta">
                <ul>
                  <li class="d-flex align-items-center"><i class="bi bi-person"></i> <a href=""><?php echo $item['creator_name']['S'];?></a></li>
                  <li class="d-flex align-items-center"><i class="bi bi-clock"></i> <a href=""><?php echo $item['date']['S'];?></a></li>
                  <li class="d-flex align-items-center"><i class="bi bi-currency-dollar"></i> <a href=""><?php echo $item['price']['N'];?></a></li>
                </ul>
              </div>

              <div class="entry-content">
                <p>
                <?php echo $item['description']['S'];?>
                </p>
                
                <?php if($_SESSION['useremail'] != null){ ?>
                <div class="read-more">
                <form method="POST">
                <?php echo "<input type='submit' id='".$item['id']['N']."' name='".$item['id']['N']."' value='Buy now'>"; ?>
                </form>
               </div>
                 <?php } ?>
              </div>   
            </article>
           <?php }}}?>
          </div>

          <div class="col-lg-4">

            <div class="sidebar">

              <h3 class="sidebar-title">Search by Name</h3>
              <div class="sidebar-item search-form">
                <form method="POST">
                  <?php echo "<input id='p_name' name='p_name' type='text' value='".$_POST['p_name']."'>"; ?>
                  <button id="search" name="search" type="submit"><i class="bi bi-search"></i></button>
                </form>
              </div>
             
              <?php if($_SESSION['useremail'] != null) {?>
              <h3 class="sidebar-title"><a href="orders.php">Your current orders</a></h3>
              <div class="sidebar-item recent-posts">
                
                <?php
                    $orders = $Dbclient->getIterator('Scan', [
                        'TableName' => 'order'
                    ]);
                   foreach($orders as $order)
                   {
                      if($order['user_email']['S'] == $_SESSION['useremail'])
                      {                                      
                ?>

                <div class="post-item clearfix">
                   <?php echo "<img src='".$order['product_image']['S']."'>"; ?>
                  <h4><?php echo $order['product_name']['S']; ?></h4>
                  <h6>&nbsp&nbsp&nbsp<i class="bi bi-currency-dollar"></i><?php echo $order['price']['N'];?></h6>
                </div>

               <?php }}}?>
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
