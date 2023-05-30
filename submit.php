<?php
session_start();
require './functions.php';
connectDB();

// Lấy thông tin sinh viên đã submit challenges
$sql = "SELECT student_name, challenge_id FROM student_submit";
$stmt = $conn->prepare($sql);
$stmt->execute();
$result = $stmt->get_result();
?>

<html>
<head>
    <title>Danh sách sinh viên đã submit challenges</title>
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
    <h1>Danh sách sinh viên đã submit challenges</h1>

    <table>
        <tr>
            <th>Sinh viên</th>
            <th>Challenges</th>
        </tr>
        <?php
        if ($result->num_rows > 0) {
            while ($row = $result->fetch_assoc()) {
                $studentName = $row['student_name'];
                $challengeId = $row['challenge_id'];

                // Lấy thông tin về tên bài tập từ bảng challenges
                $sqlChallenge = "SELECT title FROM challenges WHERE id = ?";
                $stmtChallenge = $conn->prepare($sqlChallenge);
                $stmtChallenge->bind_param("i", $challengeId);
                $stmtChallenge->execute();
                $resultChallenge = $stmtChallenge->get_result();

                if ($resultChallenge->num_rows > 0) {
                    $rowChallenge = $resultChallenge->fetch_assoc();
                    $challengeName = $rowChallenge['title'];
                } else {
                    $challengeName = "Challenge không tồn tại";
                }

                echo "<tr><td>$studentName</td><td>$challengeName</td></tr>";
            }
        } else {
            echo "<tr><td colspan='2'>Không có sinh viên nào đã submit challenges.</td></tr>";
        }
        ?>
    </table>
</body>
</html>
<button onclick="location.href='teacher.php'" type="button">Trở về</button>