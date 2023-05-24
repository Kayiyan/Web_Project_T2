<?php
require 'connectDB.php';
session_start();

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Kiểm tra CSRF token
    if(!isset($_POST['csrf_token']) || ($_POST['csrf_token'] !== $_SESSION['csrf_token'])){
        die("CSRF token không hợp lệ");
    }

    $email = $_POST['email'];
    $password = $_POST['password'];

    //Kiểm tra email và mật khẩu có hợp lệ hay không
    if(empty($email) || empty($password)){
        echo "Email hoặc mật khẩu không được để trống";
        exit;
    }

    // Kiểm tra định dạng email đúng hay không
    if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        echo "Địa chỉ Email không hợp lệ";
        exit;
    }

    // Mã hóa password
    $password = password_hash($password, PASSWORD_DEFAULT);

    // Sử dụng Prepared Statement để khắc phục lỗi SQL Injection
    $stmt = $conn->prepare("SELECT * FROM `user` WHERE `email` = ?");
    $stmt->bind_param("s", $email);
    $stmt->execute();
    $result = $stmt->get_result();
    
    if ($result->num_rows > 0) {
        // Lấy thông tin user từ db
        $row = $result->fetch_assoc();

        // Kiểm tra mật khẩu
        if(password_verify($password, $row['password'])){

            $_SESSION["email"] = $email;

            if ($row["role"] == 0) {
                header("location: student.php");
            } elseif ($row["role"] == 1) {
                header("location: teacher.php");
            }

            exit;
        } else {
            echo "Mật khẩu không đúng";
            exit;
        }
    } else {
        echo "Không tìm thấy tài khoản với Email này";
        exit;
    }
}
?>

<!doctype html>
<html lang="en">
  <head>
  	<title>Welcom to Team 2</title>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

	<link href="https://fonts.googleapis.com/css?family=Lato:300,400,700&display=swap" rel="stylesheet">

	<link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css">
	
	<link rel="stylesheet" href="css/style.css">

	</head>
	<body class="img js-fullheight" style="background-image: url(images/bg.jpg);">
	<section class="ftco-section">
		<div class="container">
			<div class="row justify-content-center">
				<div class="col-md-6 text-center mb-5">
					<h2 class="heading-section">Hello World</h2>
				</div>
			</div>
			<div class="row justify-content-center">
				<div class="col-md-6 col-lg-4">
					<div class="login-wrap p-0">
		      	<h3 class="mb-4 text-center">Have an account?</h3>
		      	<form action="#" class="signin-form">
		      		<div class="form-group">
		      			<input type="text" class="form-control" placeholder="Username" required>
		      		</div>
	            <div class="form-group">
	              <input id="password-field" type="password" class="form-control" placeholder="Password" required>
	              <span toggle="#password-field" class="fa fa-fw fa-eye field-icon toggle-password"></span>
	            </div>
	            <div class="form-group">
	            	<button type="submit" class="form-control btn btn-primary submit px-3">Sign In</button>
	            </div>
	            <div class="form-group d-md-flex">
	            	<div class="w-50">
		            	<label class="checkbox-wrap checkbox-primary">Remember Me
									  <input type="checkbox" checked>
									  <span class="checkmark"></span>
									</label>
								</div>
								<div class="w-50 text-md-right">
									<a href="#" style="color: #fff">Forgot Password</a>
								</div>
	            </div>
	          </form>
	          <p class="w-100 text-center">&mdash; Or Sign In With &mdash;</p>
	          <div class="social d-flex text-center">
	          	<a href="https://www.facebook.com/" class="px-2 py-2 mr-md-1 rounded"><span class="ion-logo-facebook mr-2"></span> Facebook</a>
	          	<a href="https://twitter.com/" class="px-2 py-2 ml-md-1 rounded"><span class="ion-logo-twitter mr-2"></span> Twitter</a>
	          </div>
		      </div>
				</div>
			</div>
		</div>
	</section>

	<script src="js/jquery.min.js"></script>
  <script src="js/popper.js"></script>
  <script src="js/bootstrap.min.js"></script>
  <script src="js/main.js"></script>

	</body>
</html>

