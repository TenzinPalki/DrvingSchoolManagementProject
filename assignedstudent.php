<?php
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "project";

$conn = new mysqli($servername, $username, $password, $dbname);

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Fetch assigned students
$sql = "SELECT instructor_name, student_name, email, phone, vehicle_type, course_type, course_time, start_date FROM assigned_students ORDER BY start_date ASC";
$result = $conn->query($sql);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Assigned Students</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 20px;
            background-color: #f4f4f4;
        }
        .student-section {
            max-width: 900px;
            margin: auto;
            background-color: #fff;
            padding: 20px;
            border-radius: 8px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
        }
        h2 {
            text-align: center;
        }
        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 20px;
        }
        th, td {
            border: 1px solid #ccc;
            padding: 10px;
            text-align: left;
        }
        th {
            background-color: rgba(240, 128, 128, 0.9);
            color: white;
        }
        tr:nth-child(even) {
            background-color: #f9f9f9;
        }
    </style>
</head>
<body>

<section class="student-section">
    <h2>Assigned Students</h2>
    <table>
        <tr>
            <th>Instructor</th>
            <th>Student Name</th>
            <th>Email</th>
            <th>Phone</th>
            <th>Vehicle Type</th>
            <th>Course Type</th>
            <th>Course Time</th>
            <th>Start Date</th>
        </tr>
        <?php
        if ($result->num_rows > 0) {
            while ($row = $result->fetch_assoc()) {
                echo "<tr>
                        <td>" . htmlspecialchars($row['instructor_name']) . "</td>
                        <td>" . htmlspecialchars($row['student_name']) . "</td>
                        <td>" . htmlspecialchars($row['email']) . "</td>
                        <td>" . htmlspecialchars($row['phone']) . "</td>
                        <td>" . htmlspecialchars($row['vehicle_type']) . "</td>
                        <td>" . htmlspecialchars($row['course_type']) . "</td>
                        <td>" . htmlspecialchars($row['course_time']) . "</td>
                        <td>" . htmlspecialchars($row['start_date']) . "</td>
                      </tr>";
            }
        } else {
            echo "<tr><td colspan='8' style='text-align:center;'>No assigned students found</td></tr>";
        }
        ?>
    </table>
</section>

</body>
</html>

<?php
$conn->close();
?>
