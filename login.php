<?php
require './functions.php';
session_start();
connectDB();

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $username = $_POST['username'];
    $password = $_POST['password'];

    // Kiểm tra username và mật khẩu có hợp lệ hay không
    if (empty($username) || empty($password)) {
        echo "Username hoặc mật khẩu không được để trống";
        exit;
    }

    $stmt = $conn->prepare("SELECT * FROM roles WHERE username = ?");
    $stmt->bind_param("s", $username);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows > 0) {
        // Lấy thông tin user từ db
        $row = $result->fetch_assoc();

        if ($password === $row['password']) {
            $_SESSION["username"] = $username;

            if ($row["type"] == "student") {
                // Kiểm tra quyền của sinh viên và chuyển hướng tới trang student.php
                header("location: student.php");
                exit;
            } elseif ($row["type"] == "teacher") {
                // Chuyển hướng tới trang teacher.php
                header("location: teacher.php");
                exit;
            }
        } else {
            echo "Mật khẩu không đúng";
            exit;
        }
    } else {
        echo "Không tìm thấy tài khoản với username này";
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

                        <!-- Các trường nhập username và password -->
                        <div class="form-group">
                            <input type="text" class="form-control" placeholder="Username" name="username" required>
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




