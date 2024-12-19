<?php
    function connectToDB(){
        $conn = mysqli_connect("localhost", "root", "", "home_assignment_db");
        return $conn;
    }

    function deleteSong($songID){
        $conn = connectToDB();
        $sql = "DELETE FROM `songs` WHERE `song_id` = $songID";
        echo $sql;
        $res = mysqli_query($conn, $sql);
        return $res;
    }
?>