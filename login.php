<?php
require './functions.php';
session_start();
connectDB();

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    
    $email = $_POST['email'];
    $password = $_POST['password'];

    // Kiểm tra email và mật khẩu có hợp lệ hay không
    if (empty($email) || empty($password)) {
        echo "Email hoặc mật khẩu không được để trống";
        exit;
    }

    // Kiểm tra định dạng email đúng hay không
    if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        echo "Địa chỉ Email không hợp lệ";
        exit;
    }
 
    $stmt = $conn->prepare("SELECT * FROM student WHERE email = ?");
    $stmt->bind_param("s", $email);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows > 0) {
        // Lấy thông tin user từ db
        $row = $result->fetch_assoc();
       
        if ($_POST['password'] === $row['password']) {
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
    <title>Welcome to Team 2</title>
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
                    <h2 class="heading-section">Welcome Back</h2>
                </div>
            </div>
            <div class="row justify-content-center">
                <div class="col-md-6 col-lg-4">
                    <form action="" class="signin-form" method="POST">
                        <!-- Thêm CSRF token -->
                        <input type="hidden" name="csrf_token" value="<?php echo $csrf_token; ?>">

                        <!-- Các trường nhập email và password -->
                        <div class="form-group">
                            <input type="email" class="form-control" placeholder="Email" name="email" required>
                        </div>

                        <div class="form-group">
                            <input type="password" class="form-control" placeholder="Password" name="password" required>
                        </div>

                        <button type="submit" class="btn btn-primary submit px-3">Sign In</button>

                        <p class="w-100 text-center">&mdash; Or Sign In With &mdash;</p>

                        <div class="social d-flex text-center">
                            <a href="https://www.facebook.com/" class="px-2 py-2 mr-md-1 rounded"><span class="ion-logo-facebook mr-2"></span> Facebook</a>
                            <a href="https://twitter.com/" class="px-2 py-2 ml-md-1 rounded"><span class="ion-logo-twitter mr-2"></span> Twitter</a>
                        </div>
                    </form>
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



