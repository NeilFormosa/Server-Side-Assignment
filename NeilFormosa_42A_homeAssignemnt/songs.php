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

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <!-- Latest compiled and minified CSS -->
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">

<!-- Latest compiled JavaScript -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>

<!-- Just validate js -->
<script src="https://unpkg.com/just-validate@latest/dist/just-validate.production.min.js"></script>
    <title>Document</title>
    <?php include("navigation.php") ?>
</head>
<body>
    <div class="container mt-3">
    <h1>View your songs below!</h1>            
    <table class="table table-bordered">
        <thead>
        <tr>
            <th>Song ID</th>
            <th>Song</th>
            <th>Singer</th>
            <th>Release date</th>
            <th>Delete</th>
        </tr>
        </thead>
        <tbody>
        <?php
        
            $songInfo_sql = "SELECT * FROM `songs` WHERE `user_id_FK` = $user_id;"; 
            $result = mysqli_query($conn, $songInfo_sql); 

            while ($row = mysqli_fetch_assoc($result)) {
        ?>
                <tr>
                    <td><?php echo $row['song_id']?></td>
                    <td><?php echo $row['song_name']?></td>
                    <td><?php echo $row['singer']?></td>
                    <td><?php echo $row['release_date']?></td> 
                    <td>
                        <form method="post" action="remove.php">
                            <input type="hidden" name="song_id" value="<?php echo $row['song_id']; ?>">
                            <button type="submit" name="delete">Delete</button>
                        </form>
                    </td>
                </tr>
            <?php
            }
            ?>
        </tbody>
    </table>
    <br><br>
    <h3 class="mx-auto" style="width:500px">Edit entries below</h3>
    <form method="post" action="editsong.php" id="updateEntry">
        <div class="input-group mb-3">
            <span class="input-group-text">Edit song by ID</span>
            <input type="text" class="form-control" placeholder="Song ID" name="song_id" id="song_id">
            <input type="text" class="form-control" placeholder="New song name" name="newSongName" id="newSongName">
            <input type="text" class="form-control" placeholder="Singer" name="singer">
            <input type="text" class="form-control" placeholder="Release date" name="release_date">
            <br>
            <button name="updateEntry">Update entry</button>
        </div>
    </form>
    <script>
        const validation = new JustValidate('#updateEntry');
        validation
            .addField('#song_id', [
                {
                    rule: 'required',
                    errorMessage: 'song id is required',
                },
            ])
            .addField('#newSongName', [
                {
                    rule: 'required',
                    errorMessage: 'New Song Name is required',
                },
            ])
            .onSuccess((validation) => {
                    validation.currentTarget.submit();
                });;
    </script>
    <br><br>
    <h3 class="mx-auto" style="width:500px">Add song below</h3>
    <form method="post" action="addsong.php" id="addNewSong">
        <div class="input-group mb-3">
            <span class="input-group-text">Add new song</span>
            <input type="text" class="form-control" placeholder="Song name" id="song_name" name="song_name">
            <input type="text" class="form-control" placeholder="Singer" id="singer" name="singer">
            <input type="text" class="form-control" placeholder="yyyy-mm-dd" id="release_date" name="release_date">
            <br>
            <button name="saveSong" type="submit">Save</button>
        </div>
    </form>
       <script>
            const validation2 = new JustValidate('#addNewSong', {validateBeforeSubmitting: true,});
            
            validation2
                .addField('#song_name', [
                    {
                        rule: 'required',
                        errorMessage: 'Song name is required',
                    },
                ])
                .onSuccess((validation2) => {
                    validation2.currentTarget.submit();
                });
        </script>
    </div>
    <?php 
        if (isset($_POST['updateEntry'])) {
            if ($_POST['song_id'] != null){
                $song_id = $_POST['song_id'];
                $song_nameEntry = $_POST['newSongName'];
                $release_dateEntry = $_POST['release_date'];
                $singerEntry = $_POST['singer'];

                $updateSongQuery = "UPDATE `songs` SET `song_name`='$song_nameEntry',`release_date`='$release_dateEntry',`singer`='$singerEntry' WHERE `song_id` = $song_id && `user_id_FK` = $user_id;";
                $updateSong_result = mysqli_query($conn, $updateSongQuery);
            }else{
                echo "<p class='d-flex justify-content-center'>Song ID and name cannot be left empty</p>";
            }
        }
    ?>
</body>
<footer>
    <?php include("footer.php") ?>
</footer>
</html>
