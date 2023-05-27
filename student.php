<?php
session_start();
$servername = "localhost";
$username = "root";
$password = "";
$database = "test";

// Tạo kết nối
$conn = new mysqli($servername, $username, $password, $database);

// Kiểm tra kết nối
if ($conn->connect_error) {
    die("Kết nối thất bại: " . $conn->connect_error);
}

// Lấy thông tin sinh viên từ session
$student_id = $_SESSION['id'];
$student_name = $_SESSION['name']; 
var_dump($student_name);
$student_email = $_SESSION['email'];
var_dump($student_email);
$student_phone = $_SESSION['phone_number'];

// Xử lý cập nhật thông tin
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    if (isset($_POST["student_phone"])) {
        $newPhone = $_POST["student_phone"];

        // Cập nhật số điện thoại trong cơ sở dữ liệu
        $updateQuery = "UPDATE student SET phone_number = '$newPhone' WHERE id = $student_id";
        if ($conn->query($updateQuery) === TRUE) {
            $student_phone = $newPhone;
            echo "Cập nhật thông tin thành công";
        } else {
            echo "Cập nhật thông tin thất bại: " . $conn->error;
        }
    }
}

// Đóng kết nối
$conn->close();
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

