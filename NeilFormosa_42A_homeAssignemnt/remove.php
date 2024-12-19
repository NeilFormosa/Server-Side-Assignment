<?php
    require_once("dbfunct.php");
    $conn = connectToDB();

    if(isset($_POST['delete'])) {
        // Get the song ID from the submitted form
        $song_id = $_POST['song_id'];

        $delete_sql = "DELETE FROM `songs` WHERE `song_id` = $song_id";
        $delete_result = mysqli_query($conn, $delete_sql);

        if($delete_result) {
            // Redirect back to the page where the song was deleted
            echo '<script type="text/javascript">';
            echo 'window.location.href="songs.php";';
            echo '</script>';
            exit();
        } else {
            echo "Error deleting song.";
        }
    }

    if(isset($_POST['deleteUser'])) {
        // Get the user ID from the submitted form
        $user_id = $_POST['user_Id'];
        echo "$user_id";

        $delete_sql = "DELETE FROM `songs` WHERE `user_id_FK` = $user_id";
        $delete_result = mysqli_query($conn, $delete_sql);
        if ($delete_result){
            $delete_sql = "DELETE FROM `details` WHERE `user_Id` = $user_id;";
            $delete_result = mysqli_query($conn, $delete_sql);

            if($delete_result) {
                // Redirect back to the page where the user was deleted
                echo '<script type="text/javascript">';
                echo 'window.location.href="adminOnly.php";';
                echo '</script>';
                exit();
            } else {
                echo "Error deleting user.";
            }   
        }
    }
?>