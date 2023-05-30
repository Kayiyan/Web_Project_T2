<?php
session_start();
require './functions.php';
connectDB();

// Lấy thông tin giáo viên từ CSDL
$teacherId = $_SESSION['id'];
$sql = "SELECT * FROM teacher WHERE id = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("i", $teacherId);
$stmt->execute();
$result = $stmt->get_result();
$row = $result->fetch_assoc();

    // Kiểm tra nếu người dùng nhấn nút "Lưu"
    if ($_SERVER["REQUEST_METHOD"] == "POST") {
        $username = $_POST['username'];
        $password = $_POST['password'];
        $gmail = $_POST['gmail'];

            // Cập nhật thông tin giáo viên vào CSDL
            $updateSql = "UPDATE teacher SET username = ?, password = ?, gmail = ? WHERE id = ?";
            $stmt = $conn->prepare($updateSql);
            $stmt->bind_param("sssi", $username, $password, $gmail, $teacherId);
            $updateResult = $stmt->execute();

    if ($updateResult) {
        // Cập nhật thành công, chuyển hướng về trang thông tin giáo viên
        header("Location: teacher.php");
        exit;
    } else {
        // Cập nhật thất bại
        $errorMessage = "Đã có lỗi xảy ra. Vui lòng thử lại sau.";
    }
}
?>

<html>
<head>
    <title>Chỉnh sửa thông tin giáo viên</title>
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

        form {
            width: 400px;
            margin: 0 auto;
            background-color: #fff;
            padding: 20px;
            border-radius: 5px;
            box-shadow: 0 2px 5px rgba(0, 0, 0, 0.1);
        }

        label {
            display: block;
            margin-bottom: 10px;
        }

        input[type="text"],
        input[type="password"],
        input[type="email"] {
            width: 100%;
            padding: 8px;
            border: 1px solid #ddd;
            border-radius: 4px;
            box-sizing: border-box;
            margin-bottom: 10px;
        }

        input[type="submit"] {
            background-color: #4CAF50;
            color: #fff;
            padding: 10px 16px;
            border: none;
            border-radius: 4px;
            cursor: pointer;
            font-size: 16px;
        }

        input[type="submit"]:hover {
            background-color: #45a049;
        }

        .error-message {
            color: red;
        }
    </style>
</head>
<body>
    <h1>Chỉnh sửa thông tin giáo viên</h1>

    <form method="POST" action="">
        <label for="username">Tên đăng nhập:</label>
        <input type="text" name="username" value="<?php echo $row['username']; ?>" required>

        <label for="password">Mật khẩu:</label>
        <input type="password" name="password" value="<?php echo $row['password']; ?>" required>

        <label for="gmail">Gmail:</label>
        <input type="email" name="gmail" value="<?php echo $row['gmail']; ?>" required>

        <input type="submit" value="Lưu">

        <?php if (isset($errorMessage)): ?>
            <p class="error-message"><?php echo $errorMessage; ?></p>
        <?php endif; ?>
    </form>
</body>
</html>
<button onclick="location.href='teacher.php'" type="button">Trở về</button>