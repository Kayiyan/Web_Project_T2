<?php
require_once 'functions.php';
session_start();

// Kiểm tra xem người dùng đã đăng nhập chưa
if (!isset($_SESSION['email'])) {
    header("location: login.php"); // Chuyển hướng đến trang đăng nhập nếu chưa đăng nhập
    exit;
}

// Kiểm tra xem người dùng có vai trò giáo viên hay không
if ($_SESSION['role'] != 1) {
    header("location: login.php"); // Chuyển hướng đến trang đăng nhập nếu không có quyền truy cập
    exit;
}

// Xử lý thêm sinh viên
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $student_name = $_POST['student_name'];
    $student_email = $_POST['student_email'];
    $student_password = $_POST['student_password'];
    $student_phone = $_POST['student_phone'];

    // Kiểm tra email đã tồn tại trong cơ sở dữ liệu chưa
    $conn = connectToDatabase();
    $stmt = $conn->prepare("SELECT * FROM students WHERE email = ?");
    $stmt->bind_param("s", $student_email);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows > 0) {
        echo "Email đã tồn tại. Vui lòng chọn một email khác.";
        exit;
    }

    // Mã hóa mật khẩu sinh viên
    $hashed_password = password_hash($student_password, PASSWORD_DEFAULT);

    // Thêm sinh viên vào cơ sở dữ liệu
    $stmt = $conn->prepare("INSERT INTO students (name, email, password, phone) VALUES (?, ?, ?, ?)");
    $stmt->bind_param("ssss", $student_name, $student_email, $hashed_password, $student_phone);
    $stmt->execute();

    // Đóng kết nối cơ sở dữ liệu
    $conn->close();

    // Hiển thị thông báo thành công
    echo "Thêm sinh viên thành công.";
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Thêm sinh viên</title>
</head>
<body>
    <h1>Thêm sinh viên</h1>

    <form method="POST" action="">
        <label>Tên:</label>
        <input type="text" name="student_name" required><br>

        <label>Email:</label>
        <input type="email" name="student_email" required><br>

        <label>Mật khẩu:</label>
        <input type="password" name="student_password" required><br>

        <label>Số điện thoại:</label>
        <input type="text" name="student_phone" required><br>

        <input type="submit" value="Thêm sinh viên">
    </form>
</body>
</html>
