<?php
// Database connection details
$servername = "localhost";
$username = "dvwa";
$password = "p@ssw0rd";
$dbname = "dvwa"; // Replace with your actual database name

try {
    // Create connection
    $conn = new mysqli($servername, $username, $password, $dbname);

    // Check connection
    if ($conn->connect_error) {
        throw new Exception("Connection failed: " . $conn->connect_error);
    }

    // Check if the form is submitted
    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        // Retrieve user input
        $userId = $_POST['userId'];

        $sql = "SELECT user_id, user FROM users WHERE user_id = ?";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("s", $userId);
        $stmt->execute();
        $result = $stmt->get_result();

        if ($result) {
            if ($result->num_rows > 0) {
                // Fetch and display user information
                while ($row = $result->fetch_assoc()) {
                    echo "User ID: " . $row["user_id"] . "<br>";
                    echo "Username: " . $row["user"] . "<br>";
                }
            } else {
                echo "User missing in the database.";
            }
        } else {
            throw new Exception("Error in the query: " . $stmt->error);
        }

        $stmt->close();
    }

    $conn->close();
} catch (Exception $e) {
    echo "An error occurred: " . $e->getMessage();
}
?>

<!-- Add a back button -->
<form action="javascript:history.back()">
    <input type="submit" value="Back">
</form>
