<?php
// Biến kết nối toàn cục
global $conn;

// Hàm kết nối database
function connect_db()
{
    // Gọi tới biến toàn cục $conn
    global $conn;
    
    // Nếu chưa kết nối thì thực hiện kết nối
    if (!$conn){
        $conn = mysqli_connect('localhost', 'root', '', 'test') or die ('Không thể kết nối đến cơ sở dữ liệu');
        // Thiết lập font chữ kết nối
        mysqli_set_charset($conn, 'utf8');
    }
}

// Hàm ngắt kết nối
function disconnect_db()
{
    // Gọi tới biến toàn cục $conn
    global $conn;
    
    // Nếu đã kết nối thì thực hiện ngắt kết nối
    if ($conn){
        mysqli_close($conn);
    }
}

// Hàm lấy tất cả sinh viên
function get_all_students()
{
    // Gọi tới biến toàn cục $conn
    global $conn;
    
    // Hàm kết nối
    connect_db();
    
    // Câu truy vấn lấy tất cả sinh viên
    $sql = "SELECT * FROM student";
    
    // Thực hiện câu truy vấn
    $query = mysqli_query($conn, $sql);
    
    // Mảng chứa kết quả
    $result = array();
    
    // Lặp qua từng record và đưa vào biến kết quả
    if ($query){
        while ($row = mysqli_fetch_assoc($query)){
            $result[] = $row;
        }
    }
    
    // Trả kết quả về
    return $result;
}

// Hàm lấy sinh viên theo ID
function get_student($student_id)
{
    // Gọi tới biến toàn cục $conn
    global $conn;
    
    // Hàm kết nối
    connect_db();
    
    // Chống SQL Injection
    $student_id = intval($student_id);
    
    // Câu truy vấn lấy sinh viên theo ID
    $sql = "SELECT * FROM student WHERE id = $student_id";
    
    // Thực hiện câu truy vấn
    $query = mysqli_query($conn, $sql);
    
    // Mảng chứa kết quả
    $result = array();
    
    // Nếu có kết quả thì đưa vào biến $result
    if (mysqli_num_rows($query) > 0){
        $row = mysqli_fetch_assoc($query);
        $result = $row;
    }
    
    // Trả kết quả về
    return $result;
}

// Hàm thêm sinh viên
function add_student($student_username, $student_password, $student_name, $student_email, $student_phone_number)
{
    // Gọi tới biến toàn cục $conn
    global $conn;

    // Hàm kết nối
    connect_db();
    echo "Hello";

    // // Chống SQL Injection
    // $student_username = mysqli_real_escape_string($conn, $student_username);
    // $student_password = mysqli_real_escape_string($conn, $student_password);
    // $student_name = mysqli_real_escape_string($conn, $student_name);
    // $student_email = mysqli_real_escape_string($conn, $student_email);
    // $student_phone_number = mysqli_real_escape_string($conn, $student_phone_number);

    // Câu truy vấn thêm sinh viên    
    $sql = "INSERT INTO student(username, password, name, email, phone_number, teacher_id) VALUES ('{$student_username}','{$student_password}','{$student_name}','{$student_email}','{$student_phone_number}',{1})";
  
    // Thực hiện câu truy vấn
    $query = mysqli_query($conn, $sql);

    // Đóng kết nối
    disconnect_db();

    return $query;
}


// Hàm sửa sinh viên
function edit_student($student_id, $student_name, $student_email, $student_phone_number, $student_username, $student_password)
{
    // Gọi tới biến toàn cục $conn
    global $conn;
    
    // Hàm kết nối
    connect_db();
    
    // Chống SQL Injection
    $student_id = intval($student_id);
    $student_name = mysqli_real_escape_string($conn, $student_name);
    $student_email = mysqli_real_escape_string($conn, $student_email);
    $student_phone_number = mysqli_real_escape_string($conn, $student_phone_number);
    $student_username = mysqli_real_escape_string($conn, $student_username);
    $student_password = mysqli_real_escape_string($conn, $student_password);
    
    // Câu truy vấn sửa sinh viên
    $sql = "UPDATE student SET name = '$student_name', email = '$student_email', phone_number = '$student_phone_number', username = '$student_username', password = '$student_password' WHERE id = $student_id";
    
    // Thực hiện câu truy vấn
    $query = mysqli_query($conn, $sql);
    
    // Đóng kết nối
    disconnect_db();
    
    return $query;
}


// Hàm xóa sinh viên
function delete_student($student_id)
{
    // Gọi tới biến toàn cục $conn
    global $conn;
    
    // Hàm kết nối
    connect_db();
    
    // Chống SQL Injection
    $student_id = intval($student_id);
    
    // Câu truy vấn xóa sinh viên
    $sql = "DELETE FROM student WHERE id = $student_id";
    
    // Thực hiện câu truy vấn
    $query = mysqli_query($conn, $sql);
    
    // Đóng kết nối
    disconnect_db();
    
    return $query;
}
?>
