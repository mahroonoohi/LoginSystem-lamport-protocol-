<?php
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $username = $_POST['username'];
    $password = $_POST['password'];
    $random_number = 3; 
    $hashed_password = hash('sha256', $password);
    for ($i = 0; $i < $random_number-1; $i++) {
        $hashed_password = hash('sha256', $hashed_password);
    }
    
    $db_host = 'localhost';
    $db_user = 'root';
    $db_password = '';
    $db_name = 'users';

    $conn = mysqli_connect($db_host, $db_user, $db_password, $db_name);
    if (!$conn) {
        die("Connection failed: " . mysqli_connect_error());
    }
    // Prepare and execute a SQL query to insert data into the users table
    $query = "INSERT INTO userstable (username, password, random_number) VALUES ('$username', '$hashed_password', '$random_number')";

    if ($conn->query($query) === TRUE) {
        echo "New record created successfully";
    } else {
        echo "Error: " . $query . "<br>" . $conn->error;
    }

    // Redirect to login.php
    header('Location:http://localhost/login-system/Login-folder/Forms.php');
    exit(); 
    $conn->close();
}
?>
