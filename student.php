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

// Lấy thông tin sinh viên từ cơ sở dữ liệu
$sql = "SELECT * FROM student WHERE id = $student_id";
$result = $conn->query($sql);

if ($result->num_rows > 0) {
    $row = $result->fetch_assoc();
    $student_name = $row['name'];
    $student_email = $row['email'];
    $student_phone = $row['phone_number'];

    // Xử lý cập nhật thông tin
    if ($_SERVER["REQUEST_METHOD"] == "POST") {
        if (isset($_POST["student_phone"]) && isset($_POST["student_email"]) && isset($_POST["student_password"])) {
            $newPhone = $_POST["student_phone"];
            $newEmail = $_POST["student_email"];
            $newPassword = $_POST["student_password"];

            // Cập nhật số điện thoại, email và mật khẩu trong cơ sở dữ liệu
            $updateQuery = "UPDATE student SET phone_number = '$newPhone', email = '$newEmail', password = '$newPassword' WHERE id = $student_id";
            if ($conn->query($updateQuery) === TRUE) {
                $student_phone = $newPhone;
                $student_email = $newEmail;
                echo "Cập nhật thông tin thành công";
            } else {
                echo "Cập nhật thông tin thất bại: " . $conn->error;
            }
        }
    }
}
// Đóng kết nối
$conn->close();
?>

<!DOCTYPE html>
<html>
<head>
    <title>Trang Sinh Viên</title>
    <style>
        body {
            background-color: #f2f2f2;
            font-family: Arial, sans-serif;
            margin: 0;
            padding: 20px;
        }

        h1 {
            color: #333;
        }

        h2 {
            color: #666;
            margin-bottom: 10px;
        }

        p {
            margin: 0;
        }

        label {
            display: block;
            margin-bottom: 5px;
        }

        input[type="text"],
        input[type="email"],
        input[type="password"] {
            width: 250px;
            padding: 5px;
            margin-bottom: 10px;
        }

        input[type="submit"] {
            padding: 10px 20px;
            background-color: #4CAF50;
            color: #fff;
            border: none;
            cursor: pointer;
        }

        a {
            color: #4CAF50;
            text-decoration: none;
        }

        a:hover {
            text-decoration: underline;
        }

        .file-links {
            margin-top: 20px;
        }

        .file-links a {
            display: block;
            margin-bottom: 5px;
        }
    </style>
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
        <input type="text" name="student_phone" value="<?php echo $student_phone; ?>" required><br>

        <label for="student_email">Email:</label>
        <input type="email" name="student_email" value="<?php echo $student_email; ?>" required><br>

        <label for="student_password">Mật khẩu:</label>
        <input type="password" name="student_password" required><br>

        <input type="submit" value="Cập nhật">
    </form>

    <h2>Download Home Work</h2>
    <div class="file-links">
        <?php
        $directory = "uploads/";
        $files = glob($directory . "*.*");
        $count = 1;
        ?>
        <?php foreach ($files as $file): ?>
            <?php $filename = basename($file); ?>
            <p><a href="download.php?path=<?php echo urlencode($file); ?>">Home Work <?php echo $count; ?></a></p>
            <?php $count++; ?>
        <?php endforeach; ?>
    </div>

    <h2>Link Challenge</h2>
    <div class="file-links">
        <?php
        $directory = "uploads_challenge/";
        $files = glob($directory . "*.*");
        $count = 1;
        ?>
        <?php foreach ($files as $file): ?>
            <?php $filename = basename($file); ?>
            <p><a href="download.php?path=<?php echo urlencode($file); ?>">Challenge <?php echo $count; ?></a></p>
            <?php $count++; ?>
        <?php endforeach; ?>
    </div>

    <br>
    <a href="logout.php">Đăng xuất</a> <!-- Link đăng xuất -->

    <h2>Danh sách sinh viên</h2>
    <a href="list_for_students.php">Click here to view</a> <br/> <br/>
</body>
</html>

