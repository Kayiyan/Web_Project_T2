<?php
require './libs/students.php';
$students = get_all_students();
?>

<!DOCTYPE html>
<html>
<head>
    <title>Danh sách sinh viên</title>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <style>
        body {
            font-family: Arial, sans-serif;
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

        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 20px;
        }

        th, td {
            padding: 10px;
            text-align: left;
        }

        th {
            background-color: #f2f2f2;
        }

        tr:nth-child(even) {
            background-color: #f9f9f9;
        }

        .options-btn {
            display: flex;
            justify-content: space-between;
            align-items: center;
        }

        .options-btn input {
            margin-right: 10px;
        }
    </style>
<script>
    function showPassword() {
        document.getElementById('password').textContent = 'Có cái nịt';
    }
</script>
</head>
<body>
    <h1>Danh sách sinh viên</h1>
    <a href="student-add.php">Thêm sinh viên</a><br><br>
    <table border="1" cellspacing="0" cellpadding="10">
        <tr>
            <th>ID</th>
            <th>Name</th>
            <th>Email</th>
            <th>Phone Number</th>
            <th>Options</th>
        </tr>
        <?php foreach ($students as $item) { ?>
            <tr>
                <td><?php echo $item['id']; ?></td>
                <td><?php echo $item['name']; ?></td>
                <td><?php echo $item['email']; ?></td>
                <td><?php echo $item['phone_number']; ?></td>
                <td class="options-btn">
                    <input onclick="window.location = 'student-edit.php?id=<?php echo $item['id']; ?>'" type="button" value="Sửa">
                    <form method="post" action="student-delete.php" onsubmit="return confirm('Bạn có chắc muốn xóa không?');">
                        <input type="hidden" name="id" value="<?php echo $item['id']; ?>">
                        <input type="submit" name="delete" value="Xóa">
                    </form>
                </td>
            </tr>
        <?php } ?>
    </table>
</body>
</html>
<button onclick="location.href='teacher.php'" type="button">Trở về</button>
