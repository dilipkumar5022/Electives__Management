<?php
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $studentId = $_POST['studentId'];
    $selectedCourse = $_POST['selectedCourse'];
    $department = $_POST['department'];

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
    $stmt->bind_result($existingECources);
    $stmt->fetch();
    $stmt->close();

    if (!empty($existingECources)) {
        echo "<script>
                alert('You have already selected e_cources: {$existingECources}.');
                window.location.href='cource.php?studentId={$studentId}'; 
              </script>";
    } else {
        $coursesByDepartment = [
            'cse' => ['Java', 'Python', 'DBMS'],
            'eee' => ['IoT', 'Electronics', 'Embedded C'],
            'ece' => ['ECE-1', 'ECE-2', 'ECE-3'],
            'mech' => ['Auto-CAD', 'MECH-B']
        ];

        $isSameDepartmentCourse = in_array($selectedCourse, $coursesByDepartment[$department]);

        if ($isSameDepartmentCourse) {
            echo "<script>
                    alert('Hello! You cannot select a course from your own department.');
                    window.location.href='cource.php?studentId={$studentId}'; // Redirect to cource.php
                  </script>";
        } else {
            $sql = "UPDATE studentinfo SET e_cources = ? WHERE studentid = ?";
            $stmt = $conn->prepare($sql);
            $stmt->bind_param("ss", $selectedCourse, $studentId);
            
            if ($stmt->execute()) {
                echo "<script>
                        alert('Course updated successfully!');
                        window.location.href='index.html'; // Redirect to index.html
                      </script>";
            } else {
                echo "<script>
                        alert('Error updating course');
                        window.location.href='cource.php?studentId={$studentId}'; // Redirect to cource.php
                      </script>";
            }

            $stmt->close();
        }
    }

    $conn->close();
}
?>
