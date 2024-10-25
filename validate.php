<?php
$servername = "sql307.infinityfree.com";
$username = "if0_37583051";
$password = "DilipKumar123";
$dbname = "if0_37583051_gmrit";

$conn = new mysqli($servername, $username, $password, $dbname);

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

$studentId = $_POST['studentId'];
$password = $_POST['password'];

$sql = "SELECT * FROM studentinfo WHERE studentid = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("s", $studentId);
$stmt->execute();
$result = $stmt->get_result();

if ($result->num_rows == 0) {
    echo "<script>alert('Student ID not in our database'); window.history.back();</script>";
} else {
    $row = $result->fetch_assoc();
    if ($row['password'] != $password) {
        echo "<script>alert('Password is wrong'); window.history.back();</script>";
    } else {
        $name = $row['Name'];
        $course = $row['cources'];
        $department = $row['department'];
        $studentId =$row['studentid'];
        header("Location: cource.php?name=" . urlencode($name) . "&studentId=" . urlencode($studentId) . "&course=" . urlencode($course) . "&department=" . urlencode($department));
        exit();
    }
}

$conn->close();
?>
