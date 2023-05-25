<?php
// functions.php

// Hàm xử lý tải lên tệp
function handleFileUpload() {
    if (isset($_FILES['fileToUpload'])) {
        $target_dir = "uploads/";
        $target_file = $target_dir . basename($_FILES["fileToUpload"]["name"]);
        if (move_uploaded_file($_FILES["fileToUpload"]["tmp_name"], $target_file)) {
            echo "Tệp " . htmlspecialchars(basename($_FILES["fileToUpload"]["name"])). " đã được tải lên thành công.";
        } else {
            echo "Xin lỗi, có lỗi xảy ra khi tải lên tệp của bạn.";
        }
    }
}

// Hàm phương thức tìm kiếm
function searchProducts() {
    if (isset($_GET['q'])) {
        $search_term = $_GET['q'];

        $stmt = $conn->prepare("SELECT * FROM products WHERE name LIKE ? OR description LIKE ?");
        $search_term = "%$search_term%";
        $stmt->bind_param("ss", $search_term, $search_term);
        $stmt->execute();
        $result = $stmt->get_result();

        if ($result->num_rows > 0) {
            while ($row = $result->fetch_assoc()) {
                echo "Tên: " . htmlspecialchars($row["name"]) . " - Mô tả: " . htmlspecialchars($row["description"]) . "<br>";
            }
        } else {
            echo "Không tìm thấy kết quả.";
        }
    }
}

// Hàm kết nối đến cơ sở dữ liệu MySQL
function connectToDatabase() {
    $servername = "localhost";
    $username = "root";
    $password = "";
    $dbname = "test";

    $conn = new mysqli($servername, $username, $password, $dbname);

    if ($conn->connect_error) {
        die("Kết nối thất bại: " . $conn->connect_error);
    }

    return $conn;
}
?>
