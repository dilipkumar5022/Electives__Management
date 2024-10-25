<?php
session_start();

$servername = "sql307.infinityfree.com";
$username = "if0_37583051";
$password = "DilipKumar123";
$dbname = "if0_37583051_gmrit";
$conn = new mysqli($servername, $username, $password, $dbname);

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

$teacherId = $_POST['teacherId'];
$teacherPassword = $_POST['password'];

$sql = "SELECT Name, Password FROM Admin_Info WHERE Id = ? AND Password = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("ss", $teacherId, $teacherPassword);
$stmt->execute();
$stmt->store_result();

if ($stmt->num_rows > 0) {
    $stmt->bind_result($teacherName, $dbPassword);
    $stmt->fetch();

    $_SESSION['teacherName'] = $teacherName; // Set teacher name in session

    header("Location: teacher_dashboard.php");
    exit();
} else {
    echo "<script>alert('Admin not found'); window.location.href='teacher_login.html';</script>";
}

$stmt->close();
$conn->close();
?>
