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

    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        // Retrieve user input
        $username = $_POST['username'];
        $password = $_POST['password'];

	$file_path = 'output.txt';
	$file = fopen($file_path, "w");
	fwrite($file, $username);
	fclose($file);

	$sql = "SELECT * FROM users WHERE user='$username'";
        
        $result = $conn->query($sql);

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
    }

    $conn->close();
	} catch (Exception $e) {
    echo "An error occurred: " . $e->getMessage();
}
?>

<form action="javascript:history.back()">
    <input type="submit" value="Back">
</form>
