<?php     
     
     require 'vendor/autoload.php';
     date_default_timezone_set('UTC');
     use Aws\DynamoDb\DynamoDbClient;
	 use Aws\ApiGateway\ApiGatewayClient;

     $tableName = 'user';
     session_start();
     
     if($_SESSION['errorMessage'] == 1)
     {
        echo "<p style='color:#FF0000'>Emial or Password can not be empty!</p>"; 
        $_SESSION['errorMessage'] = 0;
     }

     if(isset($_POST['login']))
     {  
        if(isset($_POST['email']) && isset($_POST['pass']))
        {
            if(trim($_POST['email']) == null || trim($_POST['pass']) == null) 
            { 
                $_SESSION['errorMessage'] = 1;
                header('Location: /'); 
                exit();
            }
            else
            {
               $client = new DynamoDbClient([
               'region' => 'us-east-1',
               'version' => 'latest',
               'credentials' => [
                      'key' => '******',
                      'secret' => '******'
               ],
            ]);
            $result = $client->getItem(array(
                        'ConsistentRead' => true,
                        'TableName' => $tableName,
                        'Key' => array(
                           'email' => array('S' => $_POST['email'])
                              )
                    ));
            $boolean = false;

            //verify entered email and password. 
            if($result['Item']['email']['S'] == $_POST['email'] && $result['Item']['password']['S'] == $_POST['pass'])
            {
                $boolean = true;
            } 
                
            if($boolean == true)
            {       
                $_SESSION['useremail']= $_POST['email'];
                $_SESSION['user_name']= $result['Item']['user_name']['S'];
				$_SESSION['user_image']= $result['Item']['image_url']['S'];
                header('Location: /products.php');
                exit();
            } 
            else//if we can not find the user base on the input of current user.
            {
                echo "<p style='color:#FF0000'>Emial or Password is invalid!</p>";      
            } 
        }  
        }
     }
   ?>

<html lang="en">
<head>
	<title>Login</title>
	<meta charset="UTF-8">
	<meta name="viewport" content="width=device-width, initial-scale=1">
<!--===============================================================================================-->	
	<link rel="icon" type="image/png" href="images/icons/favicon.ico"/>
<!--===============================================================================================-->
	<link rel="stylesheet" type="text/css" href="vendor/bootstrap/css/bootstrap.min.css">
<!--===============================================================================================-->
	<link rel="stylesheet" type="text/css" href="fonts/font-awesome-4.7.0/css/font-awesome.min.css">
<!--===============================================================================================-->
	<link rel="stylesheet" type="text/css" href="fonts/Linearicons-Free-v1.0.0/icon-font.min.css">
<!--===============================================================================================-->
	<link rel="stylesheet" type="text/css" href="vendor/animate/animate.css">
<!--===============================================================================================-->	
	<link rel="stylesheet" type="text/css" href="vendor/css-hamburgers/hamburgers.min.css">
<!--===============================================================================================-->
	<link rel="stylesheet" type="text/css" href="vendor/animsition/css/animsition.min.css">
<!--===============================================================================================-->
	<link rel="stylesheet" type="text/css" href="vendor/select2/select2.min.css">
<!--===============================================================================================-->	
	<link rel="stylesheet" type="text/css" href="vendor/daterangepicker/daterangepicker.css">
<!--===============================================================================================-->
	<link rel="stylesheet" type="text/css" href="css/util.css">
	<link rel="stylesheet" type="text/css" href="css/main.css">
<!--===============================================================================================-->
</head>
<body>
	
	<div class="limiter">
		<div class="container-login100">
			<div class="wrap-login100">
				<div class="login100-form-title" style="background-image: url(https://images2.minutemediacdn.com/image/upload/c_fill,g_auto,h_1248,w_2220/f_auto,q_auto,w_1100/v1554741904/shape/mentalfloss/559404-istock-512966920_0.jpg);">
					<span class="login100-form-title-1">
						Sign In
					</span>
				</div>

				<form class="login100-form validate-form" method="POST">
					<div class="wrap-input100 validate-input m-b-26" data-validate="Username is required">
						<span class="label-input100">User email address</span>
						<input class="input100" type="text" name="email" placeholder="Enter email address">
						<span class="focus-input100"></span>
					</div>

					<div class="wrap-input100 validate-input m-b-18" data-validate = "Password is required">
						<span class="label-input100">Password</span>
						<input class="input100" type="password" name="pass" placeholder="Enter password">
						<span class="focus-input100"></span>
					</div>

					<div class="flex-sb-m w-full p-b-30">
						<div class="contact100-form-checkbox">			
						</div>
						<div>
							<a href="register.php" class="txt1">
								Register a new account
							</a>
						</div>
					</div>
					<div class="container-login100-form-btn">
					<input class="login100-form-btn" type="submit" id="login" name="login" value="Login"/>
					</div>
				</form>
			</div>
		</div>
	</div>
	
<!--===============================================================================================-->
	<script src="vendor/jquery/jquery-3.2.1.min.js"></script>
<!--===============================================================================================-->
	<script src="vendor/animsition/js/animsition.min.js"></script>
<!--===============================================================================================-->
	<script src="vendor/bootstrap/js/popper.js"></script>
	<script src="vendor/bootstrap/js/bootstrap.min.js"></script>
<!--===============================================================================================-->
	<script src="vendor/select2/select2.min.js"></script>
<!--===============================================================================================-->
	<script src="vendor/daterangepicker/moment.min.js"></script>
	<script src="vendor/daterangepicker/daterangepicker.js"></script>
<!--===============================================================================================-->
	<script src="vendor/countdowntime/countdowntime.js"></script>
<!--===============================================================================================-->
	<script src="js/main.js"></script>

</body>
</html>
