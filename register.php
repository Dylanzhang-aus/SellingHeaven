<?php 
    require 'vendor/autoload.php';
    date_default_timezone_set('UTC');
    use Aws\DynamoDb\DynamoDbClient;
	use Aws\S3\S3Client;  
	session_start();  
    $tableName = 'user';
            
    if(isset($_POST['register']))
    {
        if(trim($_POST['email'])!= null && trim($_POST['pass'])!= null && trim($_POST['username'])!=null)
        {
            $client = new DynamoDbClient([
                'region' => 'us-east-1',
                'version' => 'latest',
                'credentials' => [
                       'key' => 'AKIAQASP6GPXRZZAJ4FS',
                       'secret' => '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'
                ],
             ]);
			 $s3client = new S3Client([
				'region' => 'us-east-1',
				'version' => 'latest',
				'credentials' => [
					   'key' => 'AKIAQASP6GPXRZZAJ4FS',
					   'secret' => '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'
				],
			 ]);

             $result = $client->getItem(array(
                'ConsistentRead' => true,
                'TableName' => $tableName,
                'Key' => array(
                   'email' => array('S' => $_POST['email'])
                      )
            ));

			
            $isExisted = false;
            
            //verify entered email existed. 
            if($result['Item']['email']['S'] == trim($_POST['email']) || $result['Item']['user_name']['S'] == trim($_POST['username']))
            {
                $isExisted = true;
            } 

            //if user email is new, we store in the datastore.
            if($isExisted == false)
            {
				$image_info = @getimagesize($_FILES['image']['tmp_name']);
				if($image_info == false)
				{
				    $s3client->putObject([
					     'Bucket' => 'a3-user-image',
					      'Key' => trim($_POST['username']).'.jpg',
					       'SourceFile' => $_FILES['userimage']['tmp_name']
				       ]);
                 
				    //get resized image from the bucket.
                    $image = $s3client->getObjectUrl('a3-resized-user-image','resized-'.trim($_POST['username']).'.jpg');


					//send json file to our api to add a new user in user table in dynamodb.
					$url = "https://h6dj8ltf6l.execute-api.us-east-1.amazonaws.com/register/user";    
					$data = json_encode([
						"email" => trim($_POST['email']),
                        "user_name" => trim($_POST['username']),
						"password" => trim($_POST['pass']),
						"image_url" => $image
					]);
					$curl = curl_init($url);
					curl_setopt($curl, CURLOPT_HEADER, false);
					curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
					curl_setopt($curl, CURLOPT_HTTPHEADER, array("Content-type: application/json"));
					curl_setopt($curl, CURLOPT_POST, true);
					curl_setopt($curl, CURLOPT_POSTFIELDS, $data);
					curl_exec($curl);
					curl_close($curl);

				    $_SESSION['useremail']= $_POST['email'];
				    $_SESSION['user_name']= $_POST['username']; 
					$_SESSION['user_image'] = $image;   
                    header('Location: /home.php');  
                    exit();   
			    }
				else
				{
					echo "<p style='color:#FF0000'>Please upload valid image for setting your profile.</p>";  
				}              
              }
              else
              {
                  echo "<p style='color:#FF0000'>The email or name already exists.</p>";
              }                                 
            }
            else
            {
                echo "<p style='color:#FF0000'>Email, Name and Password can not be empty.</p>";
            }  
        }        
?>
<html lang="en">
<head>
	<title>SignUp</title>
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
				<!--<div class="login100-form-title" style="background-image: url(images/bg-01.jpg);">-->
				<div class="login100-form-title" style="background-image: url(https://images2.minutemediacdn.com/image/upload/c_fill,g_auto,h_1248,w_2220/f_auto,q_auto,w_1100/v1554741904/shape/mentalfloss/559404-istock-512966920_0.jpg);">
					<span class="login100-form-title-1">
						Sign Up
					</span>
				</div>

				<form class="login100-form validate-form" method="POST" enctype="multipart/form-data">
					<div class="wrap-input100 validate-input m-b-26" data-validate="Username is required">
						<span class="label-input100">Username</span>
						<input class="input100" type="text" name="username" placeholder="Enter username">
						<span class="focus-input100"></span>
					</div>

					<div class="wrap-input100 validate-input m-b-18" data-validate = "Password is required">
						<span class="label-input100">Password</span>
						<input class="input100" type="password" name="pass" placeholder="Enter password">
						<span class="focus-input100"></span>
					</div>
					
					<div class="wrap-input100 validate-input m-b-18" data-validate = "Email is required">
						<span class="label-input100">Email</span>
						<input class="input100" type="test" name="email" placeholder="Enter email">
						<span class="focus-input100"></span>
					</div>

					<div class="wrap-input100 m-b-40">
						<span class="label-input100">Image</span>
						<input class="btn" type="file" id="userimage" name="userimage">
					</div>
					<div class="container-login100-form-btn">
					   <input class="login100-form-btn" type="submit" id="register" name="register" value="register"/>
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
