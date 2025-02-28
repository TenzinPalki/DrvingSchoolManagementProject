<?php
// Database Connection
$host = "localhost";
$user = "root";
$password = "";
$dbname = "project";

$conn = new mysqli($host, $user, $password, $dbname);

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Fetch instructor performance data
$instructor_id = 1; // Assuming we're viewing the dashboard for instructor with ID 1

$query = "SELECT i.name, COUNT(pr.record_id) AS num_courses, AVG(pr.score) AS average_score
          FROM instructors i
          LEFT JOIN performance_records pr ON i.instructor_id = pr.instructor_id
          WHERE i.instructor_id = $instructor_id
          GROUP BY i.instructor_id";

$result = $conn->query($query);

if ($result->num_rows > 0) {
    $data = $result->fetch_assoc();
} else {
    $data = [
        'name' => 'Unknown Instructor',
        'num_courses' => 0,
        'average_score' => 0
    ];
}

$conn->close();
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Student Performance Overview</title>
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            font-family: Arial, sans-serif;
            line-height: 1.6;
            color: #333;
            background-color: #f9f9f9;
            padding: 50px;
        }

        header {
            background-color: rgba(240, 128, 128, 0.9);
            text-align: center;
            padding: 20px;
            margin-bottom: 40px;
        }

        header h1 {
            color: #fff;
        }

        .dashboard {
            display: flex;
            justify-content: space-between;
            margin-bottom: 30px;
        }

        .dashboard .card {
            background-color: #fff;
            padding: 20px;
            width: 30%;
            box-shadow: 0 2px 5px rgba(0, 0, 0, 0.1);
            border-radius: 8px;
        }

        .card h3 {
            margin-bottom: 10px;
        }

        .card p {
            font-size: 18px;
            margin-bottom: 10px;
        }

        footer {
            text-align: center;
            margin-top: 40px;
            padding: 10px 0;
            background-color: #333;
            color: #fff;
        }

        footer a {
            color: #fff;
            text-decoration: underline;
        }

        footer a:hover {
            color: #ff6347;
        }
    </style>
</head>

<body>

<header>
    <h1>Student Performance Dashboard</h1>
</header>

<div class="dashboard">
    <div class="card">
        <h3>Student Name</h3>
        <p><?php echo $data['name']; ?></p>
    </div>

    <div class="card">
        <h3>Total Courses Taught</h3>
        <p><?php echo $data['num_courses']; ?></p>
    </div>

    <div class="card">
        <h3>Average Score</h3>
        <p><?php echo number_format($data['average_score'], 2); ?> / 10</p>
    </div>
</div>



</body>

</html>
