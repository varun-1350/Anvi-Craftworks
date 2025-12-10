<?php
/* ==============================
   Render PostgreSQL DB Settings
   Replace these with your credentials
================================ */
$host = "your-render-hostname";
$port = "5432";
$dbname = "your-database-name";
$user = "your-username";
$password = "your-password";

/* ==============================
   Get data from form
================================ */
$name = $_GET['name'] ?? '';
$contact = $_GET['contact'] ?? '';
$feedback = $_GET['feedback'] ?? '';

if ($name == "" || $contact == "" || $feedback == "") {
    die("All fields are required.");
}

/* ==============================
   Connect to DB
================================ */
$conn = pg_connect("host=$host port=$port dbname=$dbname user=$user password=$password");

if (!$conn) {
    die("Database connection failed.");
}

/* ==============================
   Insert into table
================================ */
$sql = "INSERT INTO feedback (name, contact, message) VALUES ($1, $2, $3)";
$result = pg_query_params($conn, $sql, array($name, $contact, $feedback));

if ($result) {
    echo "<h2 style='color:white; background:#2d203f; padding:20px; text-align:center;'>Thank you for your feedback!</h2>";
    echo "<p style='text-align:center;'><a href='index.html'>Go Back</a></p>";
} else {
    echo "Error saving feedback.";
}
?>
