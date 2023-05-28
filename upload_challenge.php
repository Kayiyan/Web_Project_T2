<?php
$target_dir = "uploads_challenge/";
$target_file = $target_dir . basename($_FILES["fileToUpload"]["name"]);
$uploadOk = 1;
$fileType = strtolower(pathinfo($target_file, PATHINFO_EXTENSION));

// Kiểm tra loại file
if($fileType != "txt") {
    echo "Chỉ cho phép upload file văn bản (.txt).";
    $uploadOk = 0;
}

// Kiểm tra kích thước file
if ($_FILES["fileToUpload"]["size"] > 500000) {
    echo "File quá lớn. Chỉ cho phép upload file nhỏ hơn 500KB.";
    $uploadOk = 0;
}

// Kiểm tra biến $uploadOk để xác định liệu file có được upload hay không
if ($uploadOk == 0) {
    echo "File của bạn không được tải lên.";
} else {
    // Nếu mọi thứ ổn, tiến hành upload file
    if (move_uploaded_file($_FILES["fileToUpload"]["tmp_name"], $target_file)) {
        echo "File ". htmlspecialchars(basename($_FILES["fileToUpload"]["name"])). " đã được tải lên.";
    } else {
        echo "Có lỗi xảy ra khi tải lên file.";
    }
}
?>