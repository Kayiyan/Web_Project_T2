<?php
require_once 'functions.php';
session_start();

// Kiểm tra xem người dùng đã đăng nhập chưa
if (!isset($_SESSION['email'])) {
    header("location: login.php"); // Chuyển hướng đến trang đăng nhập nếu chưa đăng nhập
    exit;
}

// Lấy thông tin sinh viên từ session
$student_id = $_SESSION['id'];
$student_name = $_SESSION['name'];
$student_email = $_SESSION['email'];
$student_phone = $_SESSION['phone'];

// Kiểm tra vai trò của sinh viên
if ($_SESSION['role'] = 1 || $student_id != $_SESSION['id']) {
    header("location: login.php"); // Chuyển hướng đến trang đăng nhập nếu không có quyền truy cập
    exit;
}

// Xử lý form cập nhật thông tin sinh viên
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $new_phone = $_POST['student_phone'];

    // Kết nối đến cơ sở dữ liệu
    $conn = connectDB();

    // Thực hiện cập nhật thông tin sinh viên trong cơ sở dữ liệu
    $stmt = $conn->prepare("UPDATE students SET phone = ? WHERE email = ?");
    $stmt->bind_param("ss", $new_phone, $student_email);
    $stmt->execute();
    // Cập nhật lại thông tin trong session
    $_SESSION['phone'] = $new_phone;
    // Đóng kết nối cơ sở dữ liệu
    $conn->close();
    // Hiển thị thông báo cập nhật thành công
    echo "Cập nhật thông tin thành công.";
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Cập nhật thông tin sinh viên</title>
</head>
<body>
    <h1>Cập nhật thông tin sinh viên</h1>

    <h2>Thông tin sinh viên:</h2>
    <p>Họ tên: <?php echo $student_name; ?></p>
    <p>Email: <?php echo $student_email; ?></p>
    <p>Số điện thoại: <?php echo $student_phone; ?></p>

    <h2>Cập nhật thông tin:</h2>
    <form action="<?php echo $_SERVER['PHP_SELF']; ?>" method="POST">
        <label for="student_phone">Số điện thoại:</label>
        <input type="text" name="student_phone" value="<?php echo $student_phone; ?>" required>
        <input type="submit" value="Cập nhật">
    </form>

    <br>
    <a href="logout.php">Đăng xuất</a> <!-- Link đăng xuất -->
</body>
</html>
