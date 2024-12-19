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

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <!-- Latest compiled and minified CSS -->
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">

<!-- Latest compiled JavaScript -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
    <title>Document</title>
    <?php include("navigation.php") ?>

<!-- Just validate js -->
<script src="https://unpkg.com/just-validate@latest/dist/just-validate.production.min.js"></script>
</head>
<body>
    <h1 class="mx-auto" style="width:500px">Edit your details here!</h1>
        <div class= "d-flex align-items-center">
            <div class="container">
                <form method="post" action="detailsUpdate.php" id="editProfile">
                    <label for = "username" class="form-label">Username</label>
                    <input type="text" name ="username" id="username" class="form-control" value="<?php echo "$username"; ?>">
                    <label for = "phone" class="form-label">phone</label>
                    <input type="text" name ="phone" id="phone" class="form-control" value="<?php echo "$phone"; ?>">
                    <label for = "password" class="form-label">Password</label>
                    <input type="password" name ="password" id="password" class="form-control" value="<?php echo "$password"; ?>">
                    <br>
                    <button class="btn btn-primary mt-2" type="submit">Save</button>
                </form>
                <div class="text-center">
                    <img src="profilePictures/<?php echo $profile; ?>" class="rounded" alt="profile picture" style="height: 100px;">
                </div>
                <div class="mb-3">
                    <form method="POST" action="editPic.php" id="editPic">
                        <label for="formFile" class="form-label">Profile picture</label>
                        <input class="form-control" type="file" id="formFile" name="formFile" accept="image/png, image/jpeg">
                        <button class="btn btn-primary mt-2" name="editPic">Save picture</button>                
                    </form>
                </div>
                <script>
                    const validation = new JustValidate('#editProfile');
                    validation
                        .addField('#username', [
                            {
                                rule: 'required',
                                errorMessage: 'Username is required',
                            },
                            {
                                rule: 'minLength',
                                value: 3,
                                errorMessage: 'Min length 3',
                            },
                            {
                                rule: 'maxLength',
                                value: 15,
                                errorMessage: 'Max length 15',
                            },
                        ])
                        .addField('#phone', [
                            {
                                rule: 'required',
                                errorMessage: 'phone is required',
                            },
                        ])
                        .addField('#password', [
                            {
                                rule: 'required',
                                errorMessage: 'password is required',
                            },
                            {
                                rule: 'minLength',
                                value: 3,
                                errorMessage: 'Min length 3',
                            },
                        ])
                        .onSuccess((validation) => {
                                validation.currentTarget.submit();
                            });
                </script>
            </div>
        </div>
</body>
<footer>
    <?php include("footer.php") ?>
</footer>
</html>
