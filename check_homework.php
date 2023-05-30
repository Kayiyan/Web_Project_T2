<?php
session_start();
require './functions.php';
connectDB();

// Lấy thông tin sinh viên đã upload bài tập
$sql = "SELECT student_name, homework_id FROM homework_submit";
$stmt = $conn->prepare($sql);
$stmt->execute();
$result = $stmt->get_result();

?>

<html>
<head>
    <title>Danh sách sinh viên đã upload bài tập</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #eef5f3;
            padding: 20px;
        }

        h1 {
            text-align: center;
            margin-bottom: 30px;
        }

        table {
            border-collapse: collapse;
            width: 100%;
            margin-bottom: 20px;
        }

        th, td {
            text-align: left;
            padding: 8px;
            border-bottom: 1px solid #ddd;
        }

        th {
            background-color: #f2f2f2;
        }
    </style>
</head>
<body>
    <h1>Danh sách sinh viên đã upload bài tập</h1>

    <table>
        <tr>
            <th>Sinh viên</th>
            <th>ID bài tập</th>
        </tr>
        <?php
        if ($result->num_rows > 0) {
            while ($row = $result->fetch_assoc()) {
                $studentName = $row['student_name'];
                $homeworkId = $row['homework_id'];

                echo "<tr><td>$studentName</td><td>$homeworkId</td></tr>";
            }
        } else {
            echo "<tr><td colspan='2'>Không có sinh viên nào đã upload bài tập.</td></tr>";
        }
        ?>
        
    </table>
</body>
</html>
<button onclick="location.href='teacher.php'" type="button">Trở về</button>
