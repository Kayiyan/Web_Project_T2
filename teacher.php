<?php
session_start();
require './functions.php';
connectDB();

// Lấy thông tin của giáo viên
$sql = "SELECT * FROM teacher WHERE id = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("i", $id);
$id = 1;
$stmt->execute();
$result = $stmt->get_result();


?>

<html>
<head>
    <title>Trang Giáo viên</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #eef5f3;
            padding: 20px;
        }

        h1 {
            text-align: center;
            margin-bottom: 30px;
        }

        h2 {
            margin-top: 40px;
            margin-bottom: 20px;
        }

        form {
            margin-bottom: 30px;
        }

        form a {
            display: inline-block;
            background-color: #4CAF50;
            color: #fff;
            padding: 8px 12px;
            text-decoration: none;
            border-radius: 4px;
            transition: background-color 0.3s ease;
            margin-right: 10px;
        }

        form a:hover {
            background-color: #45a049;
        }

        input[type="file"] {
            margin-top: 10px;
        }

        /* Tăng màu xanh nhạt của nền */
        body {
            background-color: #c9e6df;
        }
    </style>
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
