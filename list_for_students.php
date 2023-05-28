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
            margin: 0;
            padding: 20px;
            background-color: #e0f2f1; /* Màu xanh nhạt cho khung nền */
        }

        h1 {
            text-align: center;
        }

        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 20px;
            background-color: #fff; /* Màu nền phù hợp */
            border: 1px solid #ddd;
        }

        th, td {
            padding: 10px;
            text-align: left;
            border-bottom: 1px solid #ddd;
        }

        th {
            background-color: #f2f2f2;
        }

        tr:nth-child(even) {
            background-color: #f9f9f9;
        }

        tr:hover {
            background-color: #e5e5e5;
        }

        a.button {
            display: inline-block;
            background-color: #4CAF50;
            color: #fff;
            padding: 8px 12px;
            text-decoration: none;
            border-radius: 4px;
            transition: background-color 0.3s ease;
        }

        a.button:hover {
            background-color: #45a049;
        }
    </style>
</head>
<body>
    <h1>Danh sách sinh viên</h1>
    <table>
        <tr>
            <th>ID</th>
            <th>Name</th>
            <th>Email</th>
            <th>Phone Number</th>
        </tr>
        <?php foreach ($students as $item): ?>
        <tr>
            <td><?php echo $item['id']; ?></td>
            <td><?php echo $item['name']; ?></td>
            <td><?php echo $item['email']; ?></td>
            <td><?php echo $item['phone_number']; ?></td>
        </tr>
        <?php endforeach; ?>
    </table>
</body>
</html>




