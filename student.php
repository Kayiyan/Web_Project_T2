<?php
require_once 'functions.php';
session_start();

// Kiểm tra xem người dùng đã đăng nhập chưa
if (!isset($_SESSION['email'])) {
    header("location: login.php"); // Chuyển hướng đến trang đăng nhập nếu chưa đăng nhập
    exit;
}

// Kiểm tra xem người dùng có vai trò sinh viên hay không
if ($_SESSION['role'] != 0) {
    header("location: login.php"); // Chuyển hướng đến trang đăng nhập nếu không có quyền truy cập
    exit;
}

// Lấy thông tin sinh viên từ session
$student_name = $_SESSION['name'];
$student_email = $_SESSION['email'];
$student_phone = $_SESSION['phone'];

// Xử lý form cập nhật thông tin sinh viên
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $new_email = $_POST['student_email'];
    $new_phone = $_POST['student_phone'];

    // Kết nối đến cơ sở dữ liệu
    $conn = connectToDatabase();

    // Thực hiện cập nhật thông tin sinh viên trong cơ sở dữ liệu
    $stmt = $conn->prepare("UPDATE students SET email = ?, phone = ? WHERE email = ?");
    $stmt->bind_param("sss", $new_email, $new_phone, $student_email);
    $stmt->execute();
    
    // Cập nhật lại thông tin trong session
    $_SESSION['email'] = $new_email;
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
    <title>Trang sinh viên</title>
</head>
<body>
    <h1>Xin chào, <?php echo $student_name; ?></h1>

    <h2>Thông tin sinh viên:</h2>
    <p>Email: <?php echo $student_email; ?></p>
    <p>Số điện thoại: <?php echo $student_phone; ?></p>

    <h2>Cập nhật thông tin:</h2>
    <form action="<?php echo $_SERVER['PHP_SELF']; ?>" method="POST">
        <label for="student_email">Email:</label>
        <input type="email" name="student_email" value="<?php echo $student_email; ?>" required>
        <label for="student_phone">Số điện thoại:</label>
        <input type="text" name="student_phone" value="<?php echo $student_phone; ?>" required>
        <input type="submit" value="Cập nhật">
    </form>

    <a href="logout.php">Đăng xuất</a> <!-- Link đăng xuất -->
</body>
</html>
