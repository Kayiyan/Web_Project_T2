<?php
require_once 'functions.php';
session_start();

// Kiểm tra người dùng đã đăng nhập chưa
if (!isset($_SESSION["email"])) {
    header("Location: login.php");
    exit;
}

// Kiểm tra vai trò của người dùng
if ($_SESSION["role"] !== "teacher") {
    header("Location: student.php");
    exit;
}

// Xử lý yêu cầu xóa sinh viên
if (isset($_POST["delete_student_id"])) {
    $student_id = $_POST["delete_student_id"];
    deleteStudent($student_id);
}

// Xử lý yêu cầu chỉnh sửa thông tin sinh viên
if (isset($_POST["edit_student_id"])) {
    $student_id = $_POST["edit_student_id"];
    $student_name = $_POST["edit_student_name"];
    $student_email = $_POST["edit_student_email"];
    $student_phone = $_POST["edit_student_phone"];
    editStudent($student_id, $student_name, $student_email, $student_phone);
}

// Hiển thị danh sách sinh viên
$conn = connectToDatabase();
$stmt = $conn->prepare("SELECT * FROM students");
$stmt->execute();
$result = $stmt->get_result();
?>

<!DOCTYPE html>
<html>
<head>
    <title>Trang quản lý - Giáo viên</title>
</head>
<body>
    <h1>Trang quản lý - Giáo viên</h1>

    <h2>Danh sách sinh viên</h2>
    <?php
    if ($result->num_rows > 0) {
        while ($row = $result->fetch_assoc()) {
            echo "<p>";
            echo "ID: " . $row["id"] . "<br>";
            echo "Họ tên: " . $row["name"] . "<br>";
            echo "Email: " . $row["email"] . "<br>";
            echo "Số điện thoại: " . $row["phone"] . "<br>";
            echo "</p>";
            echo '<form action="" method="post">';
            echo '<input type="hidden" name="delete_student_id" value="' . $row["id"] . '">';
            echo '<input type="submit" value="Xóa">';
            echo '</form>';
            echo '<form action="" method="post">';
            echo '<input type="hidden" name="edit_student_id" value="' . $row["id"] . '">';
            echo '<label>Họ tên:</label>';
            echo '<input type="text" name="edit_student_name" value="' . $row["name"] . '"><br>';
            echo '<label>Email:</label>';
            echo '<input type="text" name="edit_student_email" value="' . $row["email"] . '"><br>';
            echo '<label>Số điện thoại:</label>';
            echo '<input type="text" name="edit_student_phone" value="' . $row["phone"] . '"><br>';
            echo '<input type="submit" value="Chỉnh sửa">';
            echo '</form>';
            echo "<hr>";
        }
    } else {
        echo "Không có sinh viên nào.";
    }

    $stmt->close();
    $conn->close();
    ?>

    <a href="logout.php">Đăng xuất</a>
</body>
</html>
