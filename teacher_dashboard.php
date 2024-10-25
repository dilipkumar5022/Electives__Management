

<?php
session_start();

if (!isset($_SESSION['teacherName'])) {
    header("Location: teacher_login.html");
    exit();
}
$servername = "sql307.infinityfree.com";
$username = "if0_37583051";
$password = "DilipKumar123";
$dbname = "if0_37583051_gmrit";

$conn = new mysqli($servername, $username, $password, $dbname);

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Handle student deletion if requested
if (isset($_GET['delete_studentid'])) {
    $studentid = $_GET['delete_studentid'];
    $delete_sql = "UPDATE studentinfo SET e_cources = NULL WHERE studentid = '$studentid'";
    $conn->query($delete_sql);
    header("Location: teacher_dashboard.php");
    exit();
}

// Fetch all students
$sql = "SELECT SNO, Name, studentid, password, cources, e_cources, department FROM studentinfo";
$result = $conn->query($sql);

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Teacher Dashboard</title>
    <style>
<style>
        body {
            font-family: Arial, sans-serif;
            margin: 0;
            padding: 0;
            background-image: url('./gmrit.png');
            background-size: cover;
            background-position: center;
            color: white;
            height: 100vh;
        }
        .navbar {
            background-color: #333;
            overflow: hidden;
        }
        .navbar a {
            float: left;
            display: block;
            color: white;
            text-align: center;
            padding: 14px 20px;
            text-decoration: none;
        }
        .navbar a:hover {
            background-color: #ddd;
            color: black;
        }
        .container {
            display: flex;
            margin-top: 20px;
        }
        .sidebar {
            width: 20%;
            background-color: #2c3e50;
            color: white;
            padding: 20px;
            height: 80vh;
            box-shadow: 2px 0 5px rgba(0,0,0,0.1);
        }
        .main-content {
            width: 80%;
            padding: 20px;
            background-color: #fff;
            box-shadow: 0 2px 5px rgba(0,0,0,0.1);
        }
        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 20px;
            box-shadow: 0 2px 5px rgba(0,0,0,0.1);
        }
        table, th, td {
            border: 1px solid #ddd;
        }
        th, td {
            padding: 10px;
            text-align: left;
        }
        th {
            background-color: #2c3e50;
            color: white;
        }
        tr:nth-child(even) {
            background-color: #f9f9f9;
        }
        .delete-btn {
            background-color: #e74c3c;
            color: white;
            border: none;
            padding: 5px 10px;
            cursor: pointer;
            border-radius: 5px;
            transition: background-color 0.3s ease;
        }
        .delete-btn:hover {
            background-color: #c0392b;
        }
    </style>    </style>
</head>
<body>

<div class="navbar">
    <a href="index.html">Student Login</a>
</div>

<div class="container">
    <div class="sidebar">
        <h2>Welcome, <?php echo $_SESSION['teacherName']; ?></h2> <!-- Display teacher's name from session -->
        <p><a href="teacher_login.html" style="color:white;">Logout</a></p>
    </div>
    <div class="main-content">
        <h2>Student Information</h2>
        <table>
            <thead>
                <tr>
                    <th>SNO</th>
                    <th>Name</th>
                    <th>Student ID</th>
                    <th>Password</th>
                    <th>Courses</th>
                    <th>E-Courses</th>
                    <th>Department</th>
                    <th>Action</th>
                </tr>
            </thead>
            <tbody>
                <?php
                if ($result->num_rows > 0) {
                    while ($row = $result->fetch_assoc()) {
                        echo "<tr>
                                <td>{$row['SNO']}</td>
                                <td>{$row['Name']}</td>
                                <td>{$row['studentid']}</td>
                                <td>{$row['password']}</td>
                                <td>{$row['cources']}</td>
                                <td>{$row['e_cources']}</td>
                                <td>{$row['department']}</td>
                                <td><a href='teacher_dashboard.php?delete_studentid={$row['studentid']}' class='delete-btn'>Delete</a></td>
                              </tr>";
                    }
                } else {
                    echo "<tr><td colspan='8'>No students found</td></tr>";
                }
                ?>
            </tbody>
        </table>
    </div>
</div>

</body>
</html>

<?php
$conn->close();
?>
