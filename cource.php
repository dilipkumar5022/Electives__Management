<?php

$name = $_GET['name'];
$studentId = $_GET['studentId'];
$course = $_GET['course'];
$department = $_GET['department'];


$servername = "sql307.infinityfree.com";
$username = "if0_37583051";
$password = "DilipKumar123";
$dbname = "if0_37583051_gmrit";

$conn = new mysqli($servername, $username, $password, $dbname);


if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}


$sql = "SELECT e_cources FROM studentinfo WHERE studentid = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("s", $studentId);
$stmt->execute();
$stmt->bind_result($e_cources);
$stmt->fetch();
$stmt->close();
$conn->close();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Student Details</title>
    <link rel="stylesheet" href="Css.css">

    <script>
        function showCourses(department) {
            var cseCourses = document.getElementById('cseCourses');
            var eeeCourses = document.getElementById('eeeCourses');
            var eceCourses = document.getElementById('eceCourses');
            var mechCourses = document.getElementById('mechCourses');

            cseCourses.style.display = 'none';
            eeeCourses.style.display = 'none';
            eceCourses.style.display = 'none';
            mechCourses.style.display = 'none';

            document.getElementById(department + 'Courses').style.display = 'block';
        }
    </script>
</head>
<body>
    <div class="main">
    <div class="parent">
    <h2>Welcome, <?php echo htmlspecialchars($name); ?></h2>
    <p>Your Student ID: <?php echo htmlspecialchars($studentId); ?></p>
    <p>Your Course: <?php echo htmlspecialchars($course); ?></p>
    <p>Your Department: <?php echo htmlspecialchars($department); ?></p>
    </div>
    <div class="child">
    <h3>Your e_Cources:</h3>
    <p><?php echo htmlspecialchars($e_cources !== null ? $e_cources : 'null'); ?></p>

    <h3>Select a Department:</h3>
    <button onclick="showCourses('cse')">CSE</button>
    <button onclick="showCourses('eee')">EEE</button>
    <button onclick="showCourses('ece')">ECE</button>
    <button onclick="showCourses('mech')">MECH</button>

    <form method="POST" action="update_course.php">
        <input type="hidden" name="studentId" value="<?php echo htmlspecialchars($studentId); ?>">
        <input type="hidden" name="department" value="<?php echo htmlspecialchars($department); ?>">

        <div id="cseCourses" style="display:none;">
            <h4>CSE Courses:</h4>
            <input type="radio" name="selectedCourse" value="Java" required> Java<br>
            <input type="radio" name="selectedCourse" value="Python"> Python<br>
            <input type="radio" name="selectedCourse" value="DBMS"> DBMS<br>
        </div>

        <div id="eeeCourses" style="display:none;">
            <h4>EEE Courses:</h4>
            <input type="radio" name="selectedCourse" value="IoT" required> IoT<br>
            <input type="radio" name="selectedCourse" value="Electronics"> Electronics<br>
            <input type="radio" name="selectedCourse" value="Embedded C"> Embedded C<br>
        </div>

        <div id="eceCourses" style="display:none;">
            <h4>ECE Courses:</h4>
            <input type="radio" name="selectedCourse" value="ECE-1" required> ECE-1<br>
            <input type="radio" name="selectedCourse" value="ECE-2"> ECE-2<br>
            <input type="radio" name="selectedCourse" value="ECE-3"> ECE-3<br>
        </div>

        <div id="mechCourses" style="display:none;">
            <h4>MECH Courses:</h4>
            <input type="radio" name="selectedCourse" value="Auto-CAD" required> Auto-CAD<br>
            <input type="radio" name="selectedCourse" value="MECH-B"> MECH-B<br>
        </div>

        <br>
        <input class="sub" type="submit" value="Next">
    </form>
    </div>
    </div>
</body>
</html>
