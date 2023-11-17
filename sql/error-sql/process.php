<?php
// Set error reporting to suppress errors
error_reporting(0);

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

        // Query to fetch user information
        $sql = "SELECT user_id, user FROM users WHERE user_id = '$userId';";
        $result = $conn->query($sql);

        // Check if the query was successful
        if ($result) {
            // Check if any rows were returned
            if ($result->num_rows > 0) {
                // Fetch and display user information
                while ($row = $result->fetch_assoc()) {
                    echo "User ID: " . $row["user_id"] . "<br>";
                    echo "Username: " . $row["user"] . "<br>";
                }
            } else {
                // No user found with the given ID
                echo "No user found with ID: $userId";
            }
        } else {
            // Error in the query
            throw new Exception("Error in the query");
        }
    }

    // Close the database connection
    $conn->close();
} catch (Exception $e) {
    // Do nothing or customize this block based on your needs
}
?>



<!-- Add a back button -->
<form action="javascript:history.back()">
    <input type="submit" value="Back">
</form>