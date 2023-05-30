<?php
$target_dir = "uploads/";
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
        // Thêm dữ liệu vào bảng 'homeworks'
        $homework_file = $target_file;

        // Kết nối đến cơ sở dữ liệu
        $conn = new mysqli("localhost", "root", "", "test");
        if ($conn->connect_error) {
            die("Không thể kết nối đến cơ sở dữ liệu: " . $conn->connect_error);
        }

        // Sử dụng câu lệnh prepared statement để đảm bảo an toàn về SQL injection
        $sql = "INSERT INTO homeworks (homework_file) VALUES (?)";

        // Chuẩn bị câu lệnh truy vấn
        $stmt = $conn->prepare($sql);
        if ($stmt === false) {
            echo "Có lỗi xảy ra khi chuẩn bị câu lệnh truy vấn: " . $conn->error;
            exit;
        }

        // Gắn giá trị vào câu lệnh truy vấn
        $stmt->bind_param("s", $homework_file);

        // Thực thi câu lệnh truy vấn
        if ($stmt->execute() === true) {
            echo "File " . htmlspecialchars(basename($_FILES["fileToUpload"]["name"])) . " đã được tải lên thành công";
        } else {
            echo "Có lỗi xảy ra khi tải lên file " . $stmt->error;
        }

        // Đóng câu lệnh truy vấn và kết nối
        $stmt->close();
        $conn->close();
    } else {
        echo "Có lỗi xảy ra khi tải lên file.";
    }
}
?>
