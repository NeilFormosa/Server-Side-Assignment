<nav class="navbar navbar-expand-sm">
  <div class="container-fluid">
    <div class="collapse navbar-collapse" id="mynavbar">
      <ul class="navbar-nav me-auto">
        <li class="nav-item ps-4">
            <form method="post" action="songs.php">
                <button class="btn btn-primary mt-2" name="">View songs</button>
            </form>
        </li>
        <li class="nav-item ps-4">
            <form method="post" action="profileEdit.php">
                <button class="btn btn-primary mt-2" >Edit profile</button>
            </form>
        </li>

        <li class="nav-item ps-4">
            <form method="post" action="">
                <button class="btn btn-primary mt-2" name="logout">Log out</button>
            </form>
            <?php
                if (isset($_POST['logout'])) {
                    session_destroy();
                    echo "you have logged out!";
                    echo '<script type="text/javascript">';
                    echo 'window.location.href="index.php";';
                    echo '</script>';
                    exit();
                }
            ?>
        </li>

        <li class="nav-item ps-4">
            <form method="post" action="">
                <button class="btn btn-danger mt-2" name="adminOnly">Admin only</button>
            </form>
            <?php
                if (isset($_POST['adminOnly'])) {
                    if($_SESSION['username'] == "Admin"){
                        echo '<script type="text/javascript">';
                        echo 'window.location.href="adminOnly.php";';
                        echo '</script>';
                        exit();
                    }else{
                        echo "<p class='mx-auto' style='width:500px'>Admin Only!</p>";
                    }
                }
            ?>
        </li>
      </ul>
    </div>
  </div>
</nav>