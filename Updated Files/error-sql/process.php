 <?php
// Database connection details
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "dvwa"; // Replace with your actual database name

// Create connection
$conn = new mysqli($servername, $username, $password, $dbname);

// Check if the form is submitted
if ($_SERVER['REQUEST_METHOD'] === 'POST') {


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
            echo "No user found with ID: $userId";
        }
    } else {
        echo "Error executing the query: " . $stmt->error;
    }

    $stmt->close();

    $conn->close();
}
?>

<!-- Add a back button -->
<form action="javascript:history.back()">
    <input type="submit" value="Back">
</form>
