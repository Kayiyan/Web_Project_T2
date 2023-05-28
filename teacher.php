<?php
session_start();
require './functions.php';
connectDB();

// Lấy thông tin của giáo viên
$sql = "SELECT * FROM teacher WHERE id = 1";
$result = $conn->query($sql);

?>

<html>
<head>
    <title>Trang Giáo viên</title>
</head>
<body>
    <h1>Chào mừng, Giáo viên </h1>

    <!-- Form thêm sinh viên -->
    <h2>Thêm sinh viên</h2>
    <form method="post" action="">
        <!-- Các trường thông tin cho sinh viên -->
        <a href="student-add.php">Thêm sinh viên</a>
    </form>

    <!-- Form sửa thông tin sinh viên -->
    <h2>Sửa thông tin sinh viên</h2>
    <form method="post" action="">
        <!-- Các trường thông tin cho sinh viên -->
        <a href="student-edit.php">Sửa thông tin sinh viên</a>
    </form>

    <!-- Form xóa sinh viên -->
    <h2>Xóa sinh viên</h2>
    <form method="post" action="">
        <!-- Xóa sinh viên ở đây -->
        <a href="student-delete.php">Xóa sinh viên</a>
    </form>

    <!-- Hiển thị toàn bộ sinh viên -->
    <h2>Hiển thị danh sách sinh viên</h2>
    <form method="post" action="">
        <!-- Các trường thông tin cho sinh viên -->
        <a href="student-list.php">Danh sách sinh viên</a>
    </form>

    <!-- Form upload bài tập -->
    <h2>Upload bài tập</h2>
    <form action="upload.php" method="post" enctype="multipart/form-data">
        Select file to upload:
        <input type="file" name="fileToUpload" id="fileToUpload">
        <input type="submit" value="Upload File" name="submit">
    </form>

    <!-- Form upload challenge -->
    <h2>Upload challenge</h2>
    <form action="upload_challenge.php" method="post" enctype="multipart/form-data">
        Select file to upload:
        <input type="file" name="fileToUpload" id="fileToUpload">
        <input type="submit" value="Upload File" name="submit">
    </form>
</body>
</html>


