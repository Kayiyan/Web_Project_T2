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
</head>
<body>
    <h1>Danh sách sinh viên</h1>
    <a href="student-add.php">Thêm sinh viên</a> <br/> <br/>
    <table width="100%" border="1" cellspacing="0" cellpadding="10">
        <tr>
            <td>ID</td>
            <td>Name</td>
            <td>Email</td>
            <td>Phone Number</td>
            <td>Options</td>
        </tr>
        <?php foreach ($students as $item){ ?>
        <tr>
            <td><?php echo $item['id']; ?></td>
            <td><?php echo $item['name']; ?></td>
            <td><?php echo $item['email']; ?></td>
            <td><?php echo $item['phone_number']; ?></td>
            <td>
                <form method="post" action="student-delete.php">
                    <input onclick="window.location = 'student-edit.php?id=<?php echo $item['id']; ?>'" type="button" value="Sửa"/>
                    <input type="hidden" name="id" value="<?php echo $item['id']; ?>"/>
                    <input onclick="return confirm('Bạn có chắc muốn xóa không?');" type="submit" name="delete" value="Xóa"/>
                </form>
            </td>
        </tr>
        <?php } ?>
    </table>
</body>
</html>
