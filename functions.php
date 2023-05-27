<?php
global $conn;
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
function connectDB() {
    global $conn;
    $conn = mysqli_connect("localhost", "root", "", "test");

    if (mysqli_connect_errno()) {
        echo "Failed to connect to MySQL: " . mysqli_connect_error();
        exit();
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

// Hàm thêm sinh viên
function addStudent($conn, $username, $password, $name, $email, $phone_number) {
    // Kiểm tra username đã tồn tại hay chưa
    $checkQuery = "SELECT * FROM student WHERE username = ?";
    $stmt = $conn->prepare($checkQuery);
    $stmt->bind_param("s", $username);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows > 0) {
        echo "Tên đăng nhập đã tồn tại";
        return;
    }

    // Hash mật khẩu
    $hashed_password = password_hash($password, PASSWORD_DEFAULT);

    // Thêm sinh viên vào cơ sở dữ liệu
    $insertQuery = "INSERT INTO student (username, password, name, email, phone_number) VALUES (?, ?, ?, ?, ?)";
    $stmt = $conn->prepare($insertQuery);
    $stmt->bind_param("sssss", $username, $hashed_password, $name, $email, $phone_number);

    if ($stmt->execute()) {
        echo "Thêm sinh viên thành công";
    } else {
        echo "Lỗi: " . $stmt->error;
    }
}


?>
