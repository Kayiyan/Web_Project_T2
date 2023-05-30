<?php
session_start();
require './functions.php';
connectDB();

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $challengeTitle = isset($_POST['challenge_name']) ? $_POST['challenge_name'] : '';
    $challengeHint = isset($_POST['challenge_hint']) ? $_POST['challenge_hint'] : '';
    $answerOrMessage = isset($_POST['answer_or_message']) ? $_POST['answer_or_message'] : '';

    // Xử lý upload file
    $targetDir = "uploads_challenge/"; // Thư mục để lưu trữ file challenge
    $targetFile = $targetDir . basename($_FILES["fileToUpload"]["name"]);
    $uploadOk = 1;
    $fileType = strtolower(pathinfo($targetFile, PATHINFO_EXTENSION));

    // Kiểm tra tính hợp lệ của file
    $maxFileSize = 500000; // Kích thước tối đa cho phép (500KB)
    if ($_FILES["fileToUpload"]["size"] > $maxFileSize) {
        echo "Kích thước file quá lớn. Chỉ cho phép upload file nhỏ hơn " . ($maxFileSize / 1000) . "KB.";
        $uploadOk = 0;
    }

    // Kiểm tra định dạng file
    $allowedExtensions = array("txt"); // Mảng chứa các đuôi file được phép
    if (!in_array($fileType, $allowedExtensions)) {
        echo "Chỉ cho phép upload file văn bản (.txt).";
        $uploadOk = 0;
    }

    // Di chuyển file tải lên vào thư mục đích
    if ($uploadOk == 0) {
        echo "File không hợp lệ.";
    } else {
        if (move_uploaded_file($_FILES["fileToUpload"]["tmp_name"], $targetFile)) {
            // Lưu thông tin challenge vào cơ sở dữ liệu
            $sql = "INSERT INTO challenges (title, hint, challenge_file, answer_or_message) VALUES (?, ?, ?, ?)";
            $stmt = $conn->prepare($sql);
            $stmt->bind_param("ssss", $challengeTitle, $challengeHint, $targetFile, $answerOrMessage);

            if ($stmt->execute()) {
                echo "Upload challenge thành công.";
            } else {
                echo "Đã xảy ra lỗi khi lưu thông tin challenge vào cơ sở dữ liệu: " . $stmt->error;
            }
        } else {
            echo "Đã xảy ra lỗi khi tải lên file.";
        }
    }
}
?>
