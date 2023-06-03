<?php

require './libs/students.php';

// Nếu người dùng submit form
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Lấy dữ liệu
    $data['name'] = isset($_POST['name']) ? $_POST['name'] : '';
    $data['email'] = isset($_POST['email']) ? $_POST['email'] : '';
    $data['phone_number'] = isset($_POST['phone_number']) ? $_POST['phone_number'] : '';
    $data['username'] = isset($_POST['username']) ? $_POST['username'] : '';
    $data['password'] = isset($_POST['password']) ? $_POST['password'] : '';

    // Validate thông tin
    $errors = array();
    if (empty($data['name'])) {
        $errors['name'] = 'Chưa nhập tên sinh viên';
    }

    if (empty($data['email'])) {
        $errors['email'] = 'Chưa nhập email sinh viên';
    }

    if (empty($data['username'])) {
        $errors['username'] = 'Chưa nhập username sinh viên';
    }

    if (empty($data['password'])) {
        $errors['password'] = 'Chưa nhập password sinh viên';
    }

    // Nếu không có lỗi thì thêm sinh viên
    if (empty($errors)) {
        add_student($data['username'], $data['password'], $data['name'], $data['email'], $data['phone_number']);
        // Trở về trang danh sách
        header("Location: student-list.php");
        exit();
    }
}
?>


<!DOCTYPE html>
<html>
<head>
    <title>Thêm sinh viên</title>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #c9e6df;
            padding: 20px;
        }

        h1 {
            text-align: center;
            margin-bottom: 30px;
        }

        a {
            display: inline-block;
            background-color: #4CAF50;
            color: #fff;
            padding: 8px 12px;
            text-decoration: none;
            border-radius: 4px;
            transition: background-color 0.3s ease;
        }

        a:hover {
            background-color: #45a049;
        }

        form {
            width: 50%;
            margin: 0 auto;
            background-color: #fff;
            padding: 20px;
            border-radius: 4px;
        }

        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 20px;
        }

        th, td {
            padding: 10px;
            text-align: left;
        }
    </style>
</head>
<body>
    <h1>Thêm sinh viên</h1>
    <a href="student-list.php">Trở về</a><br><br>
    <form method="post" action="student-add.php">
        <table border="1" cellspacing="0" cellpadding="10">
            <tr>
                <td>Tên</td>
                <td>
                    <input type="text" name="name" value="<?php echo isset($data['name']) ? $data['name'] : ''; ?>"/>
                    <?php if (!empty($errors['name'])) echo $errors['name']; ?>
                </td>
            </tr>
            <tr>
                <td>Email</td>
                <td>
                    <input type="text" name="email" value="<?php echo isset($data['email']) ? $data['email'] : ''; ?>"/>
                    <?php if (!empty($errors['email'])) echo $errors['email']; ?>
                </td>
            </tr>
            <tr>
                <td>Số điện thoại</td>
                <td>
                    <input type="text" name="phone_number" value="<?php echo isset($data['phone_number']) ? $data['phone_number'] : ''; ?>"/>
                </td>
            </tr>
            <tr>
                <td>Username</td>
                <td>
                    <input type="text" name="username" value="<?php echo isset($data['username']) ? $data['username'] : ''; ?>"/>
                    <?php if (!empty($errors['username'])) echo $errors['username']; ?>
                </td>
            </tr>
            <tr>
                <td>Password</td>
                <td>
                    <input type="password" name="password" value="<?php echo isset($data['password']) ? $data['password'] : ''; ?>"/>
                    <?php if (!empty($errors['password'])) echo $errors['password']; ?>
                </td>
            </tr>
            <tr>
                <td></td>
                <td>
                    <input type="submit" name="add_student" value="Lưu"/>
                </td>
            </tr>
        </table>
    </form>
</body>
</html>
