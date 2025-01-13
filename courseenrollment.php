<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Enroll in Beginner's Course</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 0;
            padding: 0;
            background-color: #f4f4f9;
        }
        .container {
            max-width: 600px;
            margin: 50px auto;
            padding: 20px;
            background: #fff;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
            border-radius: 8px;
        }
        h2 {
            text-align: center;
            color: #333;
        }
        form {
            display: flex;
            flex-direction: column;
        }
        label {
            margin: 10px 0 5px;
            font-weight: bold;
        }
        input, select, button {
            padding: 10px;
            margin-bottom: 15px;
            border: 1px solid #ddd;
            border-radius: 4px;
            font-size: 16px;
        }
        button {
            background-color: rgba(240, 128, 128, 0.9);
            color: white;
            border: none;
            cursor: pointer;
        }
        button:hover {
            background-color: #ff6347;
        }
    </style>
</head>
<body>
    <div class="container">
    <h2>Enroll in Beginner's Course</h2>
        <form action="" method="POST">
            <label for="fullName">Full Name</label>
            <input type="text" id="fullName" name="fullName" required pattern="[A-Za-z\s]+" title="Please enter a valid name.">

            <label for="email">Email Address</label>
            <input type="email" id="email" name="email" required>

            <label for="contactNumber">Contact Number</label>
            <input type="tel" id="contactNumber" name="contactNumber" required pattern="^\d{10}$" title="Please enter a valid 10-digit Nepali phone number.">

            <label for="startDate">Preferred Start Date</label>
            <input type="date" id="startDate" name="startDate" required min="2025-01-01">

            <label for="vehicleType">Type of Vehicle</label>
            <select id="vehicleType" name="vehicleType" required>
                <option value="car">Car</option>
                <option value="motorbike">Motorbike</option>
                <option value="scooter">Scooter</option>
            </select>

            <label for="paymentMethod">Payment Method</label>
            <select id="paymentMethod" name="paymentMethod" required>
                <option value="creditCard">Credit Card</option>
                <option value="esewa">Esewa</option>
                <option value="bankTransfer">Bank Transfer</option>
            </select>

            <button type="submit" name="submit">Submit</button>
        </form>
    </div>

    <?php
    if ($_SERVER['REQUEST_METHOD'] == 'POST') {
        // Database configuration
        $host = 'localhost'; // Replace with your host
        $user = 'root'; // Replace with your database username
        $password = ''; // Replace with your database password
        $dbname = 'project';

        // Create a connection
        $conn = new mysqli($host, $user, $password, $dbname);

        // Check connection
        if ($conn->connect_error) {
            die("Connection failed: " . $conn->connect_error);
        }

        // Collect form data and validate
        $fullName = $conn->real_escape_string($_POST['fullName']);
        $email = $conn->real_escape_string($_POST['email']);
        $contactNumber = $conn->real_escape_string($_POST['contactNumber']);
        $startDate = $conn->real_escape_string($_POST['startDate']);
        $vehicleType = $conn->real_escape_string($_POST['vehicleType']);
        $paymentMethod = $conn->real_escape_string($_POST['paymentMethod']);

        $errors = [];

        // Validate full name
        if (!preg_match("/^[A-Za-z\s]+$/", $fullName)) {
            $errors[] = "Invalid full name.";
        }

        // Validate email
        if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
            $errors[] = "Invalid email address.";
        }

        // Validate contact number
        if (!preg_match("/^\d{10}$/", $contactNumber)) {
            $errors[] = "Invalid contact number. Please enter a 10-digit Nepali phone number.";
        }

        // Validate start date
        if (empty($startDate)) {
            $errors[] = "Start date is required.";
        }

        // Check for errors
        if (empty($errors)) {
            // Insert data into the database
            $sql = "INSERT INTO beginner (full_name, email, contact_number, start_date, vehicle_type, payment_method)
                    VALUES ('$fullName', '$email', '$contactNumber', '$startDate', '$vehicleType', '$paymentMethod')";

            if ($conn->query($sql) === TRUE) {
                echo "<p style='text-align: center; color: green;'>Enrollment successful! Thank you, $fullName.</p>";
            } else {
                echo "<p style='text-align: center; color: red;'>Error: " . $conn->error . "</p>";
            }
        } else {
            foreach ($errors as $error) {
                echo "<p style='text-align: center; color: red;'>$error</p>";
            }
        }

        // Close the connection
        $conn->close();
    }
    ?>