<?php
require_once 'functions.php';
connectDB();

$target_dir = "student_uploads_homeworks/";
$target_file = $target_dir . basename($_FILES["fileToUpload"]["name"]);
$uploadOk = 1;
$fileType = strtolower(pathinfo($target_file, PATHINFO_EXTENSION));

// Kiểm tra loại file
$allowedExtensions = array("txt"); // Mảng chứa các đuôi file được phép
if (!in_array($fileType, $allowedExtensions)) {
    echo "Chỉ cho phép upload file văn bản (.txt).";
    $uploadOk = 0;
}

// Kiểm tra kích thước file
$maxFileSize = 500000; // Kích thước tối đa cho phép (500KB)
if ($_FILES["fileToUpload"]["size"] > $maxFileSize) {
    echo "File quá lớn. Chỉ cho phép upload file nhỏ hơn " . ($maxFileSize / 1000) . "KB.";
    $uploadOk = 0;
}

// Kiểm tra biến $uploadOk để xác định liệu file có được upload hay không
if ($uploadOk == 0) {
    echo "File của bạn không được tải lên.";
} else {
    // Nếu mọi thứ ổn, tiến hành upload file
    if (move_uploaded_file($_FILES["fileToUpload"]["tmp_name"], $target_file)) {
        echo "File " . htmlspecialchars(basename($_FILES["fileToUpload"]["name"])) . " đã được tải lên.";

        // Thực hiện truy vấn SQL để cập nhật đường dẫn file bài tập của sinh viên vào CSDL
        $homework_file = $target_file;
        $homework_id = $_POST['homework_id']; // ID của bài tập được chọn từ form
        $student_name = $_POST['student_name']; // Tên sinh viên

        // Sử dụng prepared statement để đảm bảo an toàn về SQL injection
        $stmt = $conn->prepare("UPDATE homeworks SET student_answer = ? WHERE id = ?");
        $stmt->bind_param("si", $homework_file, $homework_id);

        if ($stmt->execute()) {
            echo "Thông tin bài tập đã được lưu vào CSDL.";

            // Thực hiện truy vấn SQL để cập nhật thông tin bài tập vào bảng homework_submit
            $stmtInsert = $conn->prepare("INSERT INTO homework_submit (homework_id, student_name) VALUES (?, ?)");
            $stmtInsert->bind_param("is", $homework_id, $student_name);

            if ($stmtInsert->execute()) {
                echo "Thông tin bài tập đã được cập nhật.";
            } else {
                echo "Có lỗi xảy ra khi cập nhật thông tin bài tập: " . $stmtInsert->error;
            }
        } else {
            echo "Có lỗi xảy ra khi lưu thông tin bài tập: " . $stmt->error;
        }
    } else {
        echo "Có lỗi xảy ra khi tải lên file.";
    }
}
?>
