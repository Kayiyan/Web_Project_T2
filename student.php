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
$sql_student = "SELECT * FROM student WHERE id = ?";
$stmt_student = $conn->prepare($sql_student);
$stmt_student->bind_param("i", $student_id);
$stmt_student->execute();
$result_student = $stmt_student->get_result();

if ($result_student->num_rows > 0) {
    $row_student = $result_student->fetch_assoc();
    $student_name = htmlspecialchars($row_student['name']);
    $student_email = htmlspecialchars($row_student['email']);
    $student_phone = htmlspecialchars($row_student['phone_number']);

    // Xử lý cập nhật thông tin
    if ($_SERVER["REQUEST_METHOD"] == "POST") {
        if (isset($_POST["student_phone"]) && isset($_POST["student_email"]) && isset($_POST["student_password"])) {
            $newPhone = $_POST["student_phone"];
            $newEmail = $_POST["student_email"];
            $newPassword = $_POST["student_password"];

            // Cập nhật số điện thoại, email và mật khẩu trong cơ sở dữ liệu
            $updateQuery = "UPDATE student SET phone_number = ?, email = ?, password = ? WHERE id = ?";
            $stmt_update = $conn->prepare($updateQuery);
            $stmt_update->bind_param("sssi", $newPhone, $newEmail, $newPassword, $student_id);

            if ($stmt_update->execute()) {
                $student_phone = $newPhone;
                $student_email = $newEmail;
                echo "Cập nhật thông tin thành công";
            } else {
                echo "Cập nhật thông tin thất bại: " . $conn->error;
            }
        }
    }
}

// Lấy thông tin challenge từ cơ sở dữ liệu
$sql_challenge = "SELECT id, title, hint, answer_or_message FROM challenges ORDER BY id DESC LIMIT 1"; // Lấy challenge mới nhất
$result_challenge = $conn->query($sql_challenge);

$challengeId = 0;
$challengeTitle = "";
$challengeHint = "";
$answerOrMessage = "";

if ($result_challenge->num_rows > 0) {
    $row_challenge = $result_challenge->fetch_assoc();
    $challengeId = $row_challenge['id'];
    $challengeTitle = htmlspecialchars($row_challenge['title']);
    $challengeHint = htmlspecialchars($row_challenge['hint']);
    $answerOrMessage = htmlspecialchars($row_challenge['answer_or_message']);
}

// Xử lý submit challenge
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $studentAnswer = strtolower($_POST['answer']);
    $correctAnswer = strtolower(isset($answerOrMessage) ? $answerOrMessage : '');

    if ($studentAnswer == $correctAnswer) {
        $isCorrect = true;
    } else {
        $isCorrect = false;
    }

    // Insert thông tin vào bảng student_submit
    $insertQuery = "INSERT INTO student_submit (student_name, challenge_id, is_correct) VALUES (?, ?, ?)";
    $stmt_submit = $conn->prepare($insertQuery);
    $stmt_submit->bind_param("sii", $student_name, $challengeId, $isCorrect);

    if ($stmt_submit->execute()) {
        echo "Submit thành công";
    } else {
        echo "Submit thất bại: " . $conn->error;
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
            font-family: Arial, sans-serif;
        }

        h1 {
            color: #333;
        }

        h2 {
            color: #666;
        }

        label {
            display: block;
            margin-bottom: 5px;
        }

        input[type="text"],
        input[type="email"],
        input[type="password"] {
            width: 300px;
            padding: 5px;
            margin-bottom: 10px;
        }

        input[type="submit"] {
            padding: 10px 20px;
            background-color: #333;
            color: #fff;
            border: none;
            cursor: pointer;
        }

        input[type="submit"]:hover {
            background-color: #666;
        }

        .challenge {
            background-color: #fff;
            padding: 20px;
            margin-bottom: 20px;
        }
    </style>
</head>
<body>
    <h1>Trang Sinh Viên</h1>
    <h2>Thông tin cá nhân</h2>
    <p>Tên: <?php echo isset($student_name) ? $student_name : ''; ?></p>
    <p>Email: <?php echo isset($student_email) ? $student_email : ''; ?></p>
    <p>Số điện thoại: <?php echo isset($student_phone) ? $student_phone : ''; ?></p>

    <h2>Cập nhật thông tin</h2>
    <form action="<?php echo $_SERVER['PHP_SELF']; ?>" method="POST">
        <label for="student_phone">Số điện thoại:</label>
        <input type="text" name="student_phone" value="<?php echo isset($student_phone) ? $student_phone : ''; ?>"><br>

        <label for="student_email">Email:</label>
        <input type="email" name="student_email" value="<?php echo isset($student_email) ? $student_email : ''; ?>"><br>

        <label for="student_password">Mật khẩu:</label>
        <input type="password" name="student_password" value=""><br>

        <input type="submit" value="Cập nhật">
    </form>

    <div class="challenge">
        <h2>Challenge</h2>
        <p><?php echo isset($challengeTitle) ? $challengeTitle : ''; ?></p>
        <p>Hint: <?php echo isset($challengeHint) ? $challengeHint : ''; ?></p>
    </div>

    <div class="challenge">
        <h2>Kiểm tra kết quả:</h2>
        <form action="<?php echo $_SERVER['PHP_SELF']; ?>" method="POST">
            <label for="answer">Câu trả lời:</label>
            <input type="text" name="answer" required><br>

            <input type="submit" value="Kiểm tra">
        </form>

        <?php
        if ($_SERVER["REQUEST_METHOD"] == "POST") {
            $studentAnswer = strtolower($_POST['answer']);
            $correctAnswer = strtolower(isset($answerOrMessage) ? $answerOrMessage : '');

            if ($studentAnswer == $correctAnswer) {
                echo "Chúc mừng! Bạn đã trả lời đúng.";
            } else {
                echo "Rất tiếc! Bạn đã trả lời sai.";
            }
        }
        ?>
    </div>
</body>
</html>


    <h2>Danh sách sinh viên</h2>
    <a href="list_for_students.php">Click here to view</a> <br/> <br/>
</body>
</html>
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
    <!-- Form upload homwork answer -->
    <form action="upload_homework.php" method="post" enctype="multipart/form-data">
    <h2>Upload Homework</h2>
    <label for="homework_id">Homework ID:</label>
    <input type="number" name="homework_id" required><br><br>
    <label for="fileToUpload">Select file to upload:</label>
    <input type="file" name="fileToUpload" id="fileToUpload" required><br><br>
    <input type="hidden" name="student_name" value="<?php echo isset($student_name) ? $student_name : ''; ?>">
    <input type="submit" value="Upload" name="submit">
</form>
