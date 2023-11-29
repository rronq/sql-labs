<?php
// Database connection details
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "dvwa"; // Replace with your actual database name

try {
    // Create connection
    $conn = new mysqli($servername, $username, $password, $dbname);

    // Check connection
    if ($conn->connect_error) {
        throw new Exception("Connection failed: " . $conn->connect_error);
    }

    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        // Retrieve and sanitize user input
        $username = $conn->real_escape_string($_POST['username']);
        $password = $_POST['password'];

        // Use prepared statement to prevent SQL injection
        $sql = "SELECT user_id, user, password FROM users WHERE user=?";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param('s', $username);
        $stmt->execute();
        $result = $stmt->get_result();

        if ($result) {
            if ($result->num_rows > 0) {
                while ($row = $result->fetch_assoc()) {
                    echo "User ID: " . $row["user_id"] . "<br>";
                    echo "Username: " . $row["user"] . "<br>";
                    echo "Password Hash: " . $row["password"] . "<br>";
                }
            } else {
                echo "No user found with username: $username";
            }
        } else {
            throw new Exception("Error in the query: " . $conn->error);
        }

        // Close the prepared statement
        $stmt->close();
    }

    $conn->close();
} catch (Exception $e) {
    echo "An error occurred: " . $e->getMessage();
}
?>

<form action="javascript:history.back()">
    <input type="submit" value="Back">
</form>
