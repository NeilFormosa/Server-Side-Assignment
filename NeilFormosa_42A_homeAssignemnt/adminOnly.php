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
    <h1>View all accounts below!</h1>            
    <table class="table table-bordered">
        <thead>
        <tr>
            <th>User ID</th>
            <th>Username</th>
            <th>Password</th>
            <th>Phone</th>
            <th>Profile picture</th>
        </tr>
        </thead>
        <tbody>
        <?php
        
            $userInfo_sql = "SELECT * FROM `details`"; 
            $result = mysqli_query($conn, $userInfo_sql); 

            while ($row = mysqli_fetch_assoc($result)) {
        ?>
                <tr>
                    <td><?php echo $row['user_Id']?></td>
                    <td><?php echo $row['username']?></td>
                    <td><?php echo $row['password']?></td>
                    <td><?php echo $row['phone']?></td>
                    <td><?php echo $row['profilePicture']?></td> 
                    <td>
                        <form method="post" action="remove.php">
                            <input type="hidden" name="user_Id" value="<?php echo $row['user_Id']; ?>">
                            <button type="submit" name="deleteUser">Delete</button>
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
    <form method="post" action="adminPower.php" id="EditUser">
        <div class="input-group mb-3">
            <span class="input-group-text">Edit user by ID</span>
            <input type="text" class="form-control" placeholder="User ID" name="user_id" id="user_id">
            <input type="text" class="form-control" placeholder="Username" name="username" id="username">
            <input type="text" class="form-control" placeholder="Password" name="password" id="password"> 
            <input type="text" class="form-control" placeholder="phone" name="phone" id="phone">
            <br>
            <!--<form method="post" action=""> -->
                <button type="submit" name="updateUser">Update entry</button>
            <!--</form> -->
        </div>
    </form>
    <script>
        const validation = new JustValidate('#EditUser');

        validation
            .addField('#user_id',[
                {
                    rule: 'required',
                },
            ])
            .addField('#username', [
                {
                    rule: 'required',
                },
            ])
            .addField('#password', [
                {
                    rule: 'required',
                },
            ])
            .addField('#phone', [
                {
                    rule: 'required',
                },
            ])
            .onSuccess((validation) => {
                    validation.currentTarget.submit();
                });
    </script>
</body>
<footer>
    <?php include("footer.php") ?>
</footer>
</html>
