<?php
    require_once('dbfunct.php');
    session_start();
    $conn = connectToDB();

    $username = $_SESSION['username'];
    $password = $_SESSION['password'];

    $sqlPhone = "SELECT `phone` FROM `details` WHERE `username` LIKE '$username'";
    $phoneResult = mysqli_query($conn, $sqlPhone);
    $rowPhone = mysqli_fetch_assoc($phoneResult);
    $phone = $rowPhone['phone'];

    $sqlUser_id = "SELECT `user_id` FROM `details` WHERE `username` LIKE '$username' && `phone` LIKE '$phone'";
    $user_idResult = mysqli_query($conn, $sqlUser_id);
    $rowUser_id = mysqli_fetch_assoc($user_idResult);
    $user_id = $rowUser_id['user_id'];
?>

<?php 
        
            if ($_POST['user_id'] && $_POST['username'] && $_POST['password'] && $_POST['phone']){
                $user_id = mysqli_real_escape_string($conn,trim($_POST['user_id']));
                $username_entry = mysqli_real_escape_string($conn,trim($_POST['username']));
                $password_Entry = mysqli_real_escape_string($conn,trim($_POST['password']));
                $password_hashed = mysqli_real_escape_string($conn,trim(password_hash(trim($_POST['password']), PASSWORD_DEFAULT)));
                $phone_entry = mysqli_real_escape_string($conn,trim($_POST['phone']));

                $updateUserQuery = "UPDATE `details` SET `username`='$username_entry',`password`='$password_hashed',`phone`='$phone_entry' WHERE `user_Id` = $user_id;";
                $updateUser_result = mysqli_query($conn, $updateUserQuery);

                if($updateUser_result){
                    echo "<p class='d-flex justify-content-center'>User Updated!</p>";
                }
            }else{
                echo "<p class='d-flex justify-content-center'>All fields must be filled appropriatly</p>";
            }
        //Redirect back to the page where was deleted
        echo '<script type="text/javascript">';
        echo 'window.location.href="profileEdit.php";';
        echo '</script>';
        exit();
        exit();
    ?>