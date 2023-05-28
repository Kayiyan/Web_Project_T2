<?php

require './libs/students.php';

// Lấy thông tin hiển thị để người dùng sửa
$id = isset($_GET['id']) ? (int)$_GET['id'] : '';
if ($id) {
    $data = get_student($id);
}

// Nếu không có dữ liệu tức là không tìm thấy sinh viên cần sửa
if (!$data) {
    header("Location: student-list.php");
    exit();
}

// Nếu người dùng submit form
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Lấy dữ liệu
    $data['name'] = isset($_POST['name']) ? $_POST['name'] : '';
    $data['email'] = isset($_POST['email']) ? $_POST['email'] : '';
    $data['phone_number'] = isset($_POST['phone_number']) ? $_POST['phone_number'] : '';
    $data['username'] = isset($_POST['username']) ? $_POST['username'] : '';
    $data['password'] = isset($_POST['password']) ? $_POST['password'] : '';
    $data['id'] = isset($_POST['id']) ? $_POST['id'] : '';

    // Validate thông tin
    $errors = array();
    if (empty($data['name'])) {
        $errors['name'] = 'Chưa nhập tên sinh viên';
    }

    if (empty($data['email'])) {
        $errors['email'] = 'Chưa nhập email sinh viên';
    }

    // Nếu không có lỗi thì chỉnh sửa sinh viên
    if (empty($errors)) {
        edit_student($data['id'], $data['name'], $data['email'], $data['phone_number'], $data['username'], $data['password']);
        // Trở về trang danh sách
        header("Location: student-list.php");
        exit();
    }
}

disconnect_db();
?>

<!DOCTYPE html>
<html>
<head>
    <title>Sửa sinh viên</title>
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
    <h1>Sửa sinh viên</h1>
    <a href="student-list.php">Trở về</a><br><br>
    <form method="post" action="student-edit.php?id=<?php echo $data['id']; ?>">
        <table border="1" cellspacing="0" cellpadding="10">
            <tr>
                <td>Tên</td>
                <td>
                    <input type="text" name="name" value="<?php echo $data['name']; ?>"/>
                    <?php if (!empty($errors['name'])) echo $errors['name']; ?>
                </td>
            </tr>
            <tr>
                <td>Email</td>
                <td>
                    <input type="text" name="email" value="<?php echo $data['email']; ?>"/>
                    <?php if (!empty($errors['email'])) echo $errors['email']; ?>
                </td>
            </tr>
            <tr>
                <td>Số điện thoại</td>
                <td>
                    <input type="text" name="phone_number" value="<?php echo $data['phone_number']; ?>"/>
                </td>
            </tr>
            <tr>
                <td>Username</td>
                <td>
                    <input type="text" name="username" value="<?php echo $data['username']; ?>"/>
                </td>
            </tr>
            <tr>
                <td>Password</td>
                <td>
                    <input type="password" name="password" value="<?php echo $data['password']; ?>"/>
                </td>
            </tr>
            <tr>
                <td></td>
                <td>
                    <input type="hidden" name="id" value="<?php echo $data['id']; ?>"/>
                    <input type="submit" name="edit_student" value="Lưu"/>
                </td>
            </tr>
        </table>
    </form>
</body>
</html>
