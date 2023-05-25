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

// Hàm chỉnh sửa thông tin sinh viên
function editStudent($student_id, $student_name, $student_email, $student_phone) {
    $conn = connectToDatabase();
    $stmt = $conn->prepare("UPDATE students SET name=?, email=?, phone=? WHERE id=?");
    $stmt->bind_param("sssi", $student_name, $student_email, $student_phone, $student_id);
    
    if ($stmt->execute()) {
        echo "Thông tin sinh viên đã được cập nhật thành công.";
    } else {
        echo "Có lỗi xảy ra khi cập nhật thông tin sinh viên.";
    }

    $stmt->close();
    $conn->close();
}

// Hàm xóa sinh viên
function deleteStudent($student_id) {
    $conn = connectToDatabase();
    $stmt = $conn->prepare("DELETE FROM students WHERE id=?");
    $stmt->bind_param("i", $student_id);
    
    if ($stmt->execute()) {
        echo "Sinh viên đã được xóa thành công.";
    } else {
        echo "Có lỗi xảy ra khi xóa sinh viên.";
    }

    $stmt->close();
    $conn->close();
}

?>
