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
                    
                        $profilePicture = $_POST['formFile'];
                        $updateDetailsQuery = "UPDATE `details` SET `profilePicture`='$profilePicture' WHERE `user_Id` = $user_id;";
                        $updatedDetails = mysqli_query($conn, $updateDetailsQuery);
                    //Redirect back to the page where the song was deleted
                    echo '<script type="text/javascript">';
                    echo 'window.location.href="profileEdit.php";';
                    echo '</script>';
                    exit();
                ?>