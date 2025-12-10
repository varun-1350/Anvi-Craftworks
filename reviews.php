<?php
/* ========= Render PostgreSQL Settings ========= */
$host = "your-render-hostname";
$port = "5432";
$dbname = "your-database-name";
$user = "your-username";
$password = "your-password";

/* ========= Connect ========= */
$conn = pg_connect("host=$host port=$port dbname=$dbname user=$user password=$password");

if (!$conn) {
    die("Database connection failed.");
}

/* ========= Save Review ========= */
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $name   = $_POST['name'] ?? '';
    $review = $_POST['review'] ?? '';
    $rating = $_POST['rating'] ?? '3';

    if ($name != "" && $review != "") {
        $sql = "INSERT INTO reviews (name, message, rating) VALUES ($1, $2, $3)";
        pg_query_params($conn, $sql, [$name, $review, $rating]);
    }

    header("Location: reviews.html");
    exit();
}

/* ========= Show Reviews ========= */
$result = pg_query($conn, "SELECT name, message, rating, created_at FROM reviews ORDER BY id DESC");

while ($row = pg_fetch_assoc($result)) {
    $stars = str_repeat("★", intval($row['rating']));
    
    echo "<div class='review-box'>";
    echo "<div class='name'>" . htmlspecialchars($row['name']) . "</div>";
    echo "<div class='stars'>$stars</div>";
    echo "<div>" . nl2br(htmlspecialchars($row['message'])) . "</div>";
    echo "<small>" . $row['created_at'] . "</small>";
    echo "</div>";
}
?>
