<?php
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $username = $_POST['username'];
    $password = $_POST['password'];
    $random_number=0;


    $db_host = 'localhost';
    $db_user = 'root';
    $db_password = '';
    $db_name = 'users';

    $conn = mysqli_connect($db_host, $db_user, $db_password, $db_name);
    if (!$conn) {
        die("Connection failed: " . mysqli_connect_error());
    }
$query = "SELECT * FROM userstable";
$result = mysqli_query($conn, $query);

if ($result) {
    $isuser=false;
    while ($row = mysqli_fetch_assoc($result)) {
        $userId = $row['id'];
        $usernamedb = $row['username'];
        $passworddb = $row['password'];
        $random_number=$row['random_number'];
        if($username==$usernamedb){
            $isuser=TRUE;
            if($random_number==1){
                session_start();
                $_SESSION['hashpassword_db'] = $passworddb;
                $_SESSION['hashpassword'] = $password;
                $_SESSION['username'] = $usernamedb;
                $_SESSION['data'] = $random_number-1;
                break;
            }
            if($random_number==0){
                echo("Your Session is finished After this timer, you will be automatically Redirected to the main page ");
                $timerDuration = 5; 
                sleep($timerDuration);
                header('Location:http://localhost/login-system/Registration-folder/Register.html');
                exit(); 
            }
            $hashed_password = hash('sha256', $password);
            for ($i = 0; $i < $random_number - 2; $i++) {
                $hashed_password = hash('sha256', $hashed_password);
            }
            session_start();
            $_SESSION['hashpassword_db'] = $passworddb;
            $_SESSION['hashpassword'] = $hashed_password;
            $_SESSION['username'] = $usernamedb;
            $_SESSION['data'] = $random_number-1;
            break;
        }
    }
    if($isuser==false){
        header('Location:http://localhost/login-system/Login-folder/Error-Page');
        exit(); 
    }
    header('Location:http://localhost/login-system/Login-folder/Server-side.php');
    exit(); 
    mysqli_free_result($result);
} else {
    echo "Error: " . mysqli_error($conn);}
}
?>
