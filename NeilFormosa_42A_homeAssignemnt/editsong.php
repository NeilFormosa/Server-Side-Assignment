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
        
            if ($_POST['song_id'] != null){
                $song_id = mysqli_real_escape_string($conn,trim($_POST['song_id']));
                $song_nameEntry = mysqli_real_escape_string($conn,trim($_POST['newSongName']));
                $release_dateEntry = mysqli_real_escape_string($conn,trim($_POST['release_date']));
                $singerEntry = mysqli_real_escape_string($conn,trim($_POST['singer']));

                $updateSongQuery = "UPDATE `songs` SET `song_name`='$song_nameEntry',`release_date`='$release_dateEntry',`singer`='$singerEntry' WHERE `song_id` = $song_id && `user_id_FK` = $user_id;";
                $updateSong_result = mysqli_query($conn, $updateSongQuery);
            }else{
                echo "<p class='d-flex justify-content-center'>Song ID and name cannot be left empty</p>";
            }

        // Redirect back to the page where the song was deleted
        echo '<script type="text/javascript">';
        echo 'window.location.href="songs.php";';
        echo '</script>';
        exit();
    ?>