<?php
session_start();
if (isset($_SESSION['data'])) {
    $getrandom = $_SESSION['data'];
    echo "Received data: $getrandom";
        $hashpassword_db = $_SESSION['hashpassword_db'];
        $hashed_password=  $_SESSION['hashpassword'];
        $Final_hashed_password = hash('sha256', $hashed_password);
        if($Final_hashed_password==$hashpassword_db){
            $db_host = 'localhost';
            $db_user = 'root';
            $db_password = '';
            $db_name = 'users';
        
            $conn = mysqli_connect($db_host, $db_user, $db_password, $db_name);
            if (!$conn) {
                die("Connection failed: " . mysqli_connect_error());
            }
        $newPassword = $hashed_password; 
        $newRandom = $getrandom;
        $newUsername = $_SESSION['username'];
        $sql = "UPDATE userstable SET password = '$newPassword', random_number = '$newRandom' WHERE username = '$newUsername'";

        if (mysqli_query($conn, $sql)) {
            header('Location: http://localhost/login-system/main.php');
            exit();}
        }
        else {
            header('Location: http://localhost/login-system/Login-folder/Error-Page');
            exit();
        }
}
?>
