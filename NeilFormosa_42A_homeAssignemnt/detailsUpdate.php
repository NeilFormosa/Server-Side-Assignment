<?php
    require_once "dbfunct.php";
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

    $sqlProfile = "SELECT `profilePicture` FROM `details` WHERE `username` LIKE '$username' && `phone` LIKE '$phone'";
    $profileResult = mysqli_query($conn, $sqlProfile);
    $rowProfile = mysqli_fetch_assoc($profileResult);
    $profile = $rowProfile['profilePicture'];
?>

<?php
                $conn = connectToDB();
                $totalUsersQuery = "SELECT COUNT(`user_Id`) FROM `details`";
                $totalUsersResult = mysqli_query($conn, $totalUsersQuery);
                $rowTotalUser = mysqli_fetch_assoc($totalUsersResult);
                $totalUsers = $rowTotalUser['COUNT(`user_Id`)'];

                $validDetails = true;

                $sqlUsername = "SELECT `username` FROM `details`";
                $sqlPhone = "SELECT `phone` FROM `details`";
                $sqlUser_id = "SELECT `user_id` FROM `details`";

                $usernameResult = mysqli_query($conn, $sqlUsername);
                $phoneResult = mysqli_query($conn, $sqlPhone);
                $user_idResult = mysqli_query($conn, $sqlUser_id);

                for ($x = 1; $x <= $totalUsers; $x++){
                    $rowUsername = mysqli_fetch_assoc($usernameResult);
                    $rowPhone = mysqli_fetch_assoc($phoneResult);
                    $rowUser_id = mysqli_fetch_assoc($user_idResult);

                    $username = $rowUsername['username'];
                    $phone = $rowPhone['phone'];
                    $user_id_db = $rowUser_id['user_id'];

                    if (((mysqli_real_escape_string($conn,trim($_POST['username'])) == $username) || (mysqli_real_escape_string($conn,trim($_POST['phone'])) == $phone)) && $user_id_db != $user_id && ((empty($_POST['username'])) || (empty($_POST['phone'])))) {
                        $validDetails = false;
                    }
                }
                
                if ($validDetails == true){
                    $usernameEntry = mysqli_real_escape_string($conn,trim($_POST['username']));
                    $phoneEntry = mysqli_real_escape_string($conn,trim($_POST['phone']));
                    $passwordEntry = mysqli_real_escape_string($conn,trim($_POST['password']));
                    $passwordHash = mysqli_real_escape_string($conn,password_hash(trim($_POST['password']), PASSWORD_DEFAULT));

                    $updateDetailsQuery = "UPDATE `details` SET `username`='$usernameEntry',`password`='$passwordHash',`phone`='$phoneEntry' WHERE `user_Id` = $user_id";
                    $updatedDetails = mysqli_query($conn, $updateDetailsQuery);

                    if($updatedDetails){
                        echo "<p class='mx-auto' style='width:500px'>Details updated succesfully";
                        $_SESSION['username'] = $usernameEntry;
                        $_SESSION['password'] = $passwordEntry;
                    }
                    
                }
                else{
                    echo "<p class='mx-auto' style='width:500px'>username or phone already in use or left empty!</p>";
                }

                //Redirect back to the page where the song was deleted
                echo '<script type="text/javascript">';
                echo 'window.location.href="profileEdit.php";';
                echo '</script>';
                exit();
        ?>