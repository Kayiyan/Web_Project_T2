<?php
require 'connectDB.php';
session_start();

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Kiểm tra CSRF token
    if(!isset($_POST['csrf_token']) || ($_POST['csrf_token'] !== $_SESSION['csrf_token'])){
        die("CSRF token không hợp lệ");
    }

    $email = $_POST['email'];
    $password = $_POST['password'];

    //Kiểm tra email và mật khẩu có hợp lệ hay không
    if(empty($email) || empty($password)){
        echo "Email hoặc mật khẩu không được để trống";
        exit;
    }

    // Kiểm tra định dạng email đúng hay không
    if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        echo "Địa chỉ Email không hợp lệ";
        exit;
    }

    // Mã hóa password
    $password = password_hash($password, PASSWORD_DEFAULT);

    // Sử dụng Prepared Statement để khắc phục lỗi SQL Injection
    $stmt = $conn->prepare("SELECT * FROM `user` WHERE `email` = ?");
    $stmt->bind_param("s", $email);
    $stmt->execute();
    $result = $stmt->get_result();
    
    if ($result->num_rows > 0) {
        // Lấy thông tin user từ db
        $row = $result->fetch_assoc();

        // Kiểm tra mật khẩu
        if(password_verify($password, $row['password'])){

            $_SESSION["email"] = $email;

            if ($row["role"] == 0) {
                header("location: student.php");
            } elseif ($row["role"] == 1) {
                header("location: teacher.php");
            }

            exit;
        } else {
            echo "Mật khẩu không đúng";
            exit;
        }
    } else {
        echo "Không tìm thấy tài khoản với Email này";
        exit;
    }
}
?>

