<?php
// Enable error reporting
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

$servername = "localhost";
$username = "root";
$password = "";
$dbname = "webinar";

// Create connection
$conn = new mysqli($servername, $username, $password, $dbname);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $name = $_POST['name'];
    $age = $_POST['age'];
    $gender = $_POST['gender'];
    $country = $_POST['country'];
    $email = $_POST['email'];
    $qualification = $_POST['qualification'];

    // Prepare and bind
    $stmt = $conn->prepare("INSERT INTO registration (name, age, gender, country, email, qualification) VALUES (?, ?, ?, ?, ?, ?)");
    $stmt->bind_param("sissss", $name, $age, $gender, $country, $email, $qualification);

    // Execute the statement
    if ($stmt->execute()) {
        // Send confirmation email
        $to = $email;
        $subject = "Webinar Registration Confirmation";
        $message = "Dear $name,\n\nThank you for registering for the Machine Learning Webinar.\n\nDate and Time: 25th December 2024, 10:00 AM IST\nVenue: Google Meet\n\nBest regards,\nWebinar Team";
        $headers = "From:raghugr131204@gmail.com";

        mail($to, $subject, $message, $headers);

        // Show success message and redirect
        echo "<script>alert('Registration successful! A confirmation email has been sent.'); window.location.href = 'registration.html';</script>";
        exit();
    } else {
        echo "Error: " . $stmt->error;
    }

    $stmt->close();
    $conn->close();
}
?>
