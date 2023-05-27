<?php
session_start();
require './functions.php';
connectDB();
// check login
if (!isset($_SESSION['email'])) {
    header("location: login.php");
    exit;
}

}
// Các chức năng của Giáo viên
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Xử lý thêm sinh viên
    if (isset($_POST["addStudent"])) {
        addStudent($conn, $_POST["username"], $_POST["password"], $_POST["name"], $_POST["email"], $_POST["phone_number"]);
    }
    // Xử lý sửa thông tin sinh viên
    if (isset($_POST["editStudent"])) {        
        editStudent($conn, $_POST["student_id"], $_POST["name"], $_POST["email"], $_POST["phone_number"]);
    }
    // Xử lý xóa sinh viên
    if (isset($_POST["deleteStudent"])) {
        deleteStudent($conn, $_POST["student_id"]);
    }
    // Xử lý upload file bài tập
    if (isset($_POST["uploadAssignment"])) {        
        handleFileUpload()($conn, $_FILES["assignment_file"]);
    }
}


?>
<html>
<head>
    <title>Trang Giáo viên</title>
</head>
<body>
    <h1>Chào mừng, Giáo viên <?php echo $row["name"]; ?></h1>

    <!-- Form thêm sinh viên -->
    <h2>Thêm sinh viên</h2>
    <form method="post" action="">
        <!-- Các trường thông tin cho sinh viên -->
        <input type="submit" name="addStudent" value="Thêm sinh viên">
    </form>

    <!-- Form sửa thông tin sinh viên -->
    <h2>Sửa thông tin sinh viên</h2>
    <form method="post" action="">
        <!-- Chọn sinh viên cần sửa -->
        <!-- Các trường thông tin cho sinh viên -->
        <input type="submit" name="editStudent" value="Sửa thông tin">
    </form>

    <!-- Form xóa sinh viên -->
    <h2>Xóa sinh viên</h2>
    <form method="post" action="">
        <!-- Chọn sinh viên cần xóa -->
        <input type="submit" name="deleteStudent" value="Xóa sinh viên">
    </form>

    <!-- Form upload bài tập -->
    <h2>Upload bài tập</h2>
    <form method="post" action="" enctype="multipart/form-data">
        <!-- Các trường thông tin cho bài tập -->
        <input type="submit" name="uploadAssignment" value="Upload bài tập">
    </form>
</body>
</html>

