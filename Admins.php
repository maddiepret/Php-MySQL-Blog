<?php require_once("Includes/DB.php"); ?>
<?php require_once("Includes/Functions.php"); ?>
<?php require_once("Includes/Sessions.php"); ?>
<?php $_SESSION["TrackingURL"] = $_SERVER["PHP_SELF"];
Confirm_Login(); ?>

<?php
if (isset($_POST["Submit"])) {
    $UserName        = $_POST["Username"];
    $Name            = $_POST["Name"];
    $Password        = $_POST["Password"];
    $ConfirmPassword = $_POST["ConfirmPassword"];
    $Admin           = $_SESSION["UserName"];
    $aheadline       = '';
    $abio            = '';
    $CurrentTime = time();
    $DateTime = strftime("%B-%d-%Y %H:%M:%S", $CurrentTime);

    if (empty($UserName) || empty($Password) || empty($ConfirmPassword)) {
        $_SESSION["ErrorMessage"] = "All fields must be filled out";
        Redirect_to("Admins.php");
    } elseif (strlen($Password) < 4) {
        $_SESSION["ErrorMessage"] = "Password should be greater than 3 characters";
        Redirect_to("Admins.php");
    } elseif ($Password !== $ConfirmPassword) {
        $_SESSION["ErrorMessage"] = "Password and Confirm Password should match";
        Redirect_to("Admins.php");
    } elseif (CheckUserNameExistsOrNot($UserName)) {
        $_SESSION["ErrorMessage"] = "Username Exists. Try Another One! ";
        Redirect_to("Admins.php");
    } else {
        // Query to insert new admin in DB When everything is fine
        global $ConnectingDB;
        $sql = "INSERT INTO admins(datetime,username,password,aname,addedby,aheadline, abio)";
        $sql .= "VALUES(:dateTime,:userName,:password,:aName,:adminName,:aheadLine,:aBio)";

        $stmt = $ConnectingDB->prepare($sql);
        $stmt->bindValue(':dateTime', $DateTime);
        $stmt->bindValue(':userName', $UserName);
        $stmt->bindValue(':password', $Password);
        $stmt->bindValue(':aName', $Name);
        $stmt->bindValue(':adminName', $Admin);
        $stmt->bindValue(':aheadLine', $aheadline);
        $stmt->bindValue(':aBio', $abio);

        $Execute = $stmt->execute();
        var_dump($Execute);

        if ($Execute) {
            $_SESSION["SuccessMessage"] = "New Admin with the name of " . $Name . " added Successfully";
            Redirect_to("Admins.php");
        } else {
            $_SESSION["ErrorMessage"] = "Something went wrong. Try Again !";
            Redirect_to("Admins.php");
        }
    }
} //Ending of Submit Button If-Condition
?>






<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.6.3/css/all.css" integrity="sha384-UHRtZLI+pbxtHCWp1t77Bi1L4ZtiqrqD80Kn4Z8NTSRyMA2Fd33n5dQ8lWUE00s/" crossorigin="anonymous">
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.2.1/css/bootstrap.min.css" integrity="sha384-GJzZqFGwb1QTTN6wy59ffF1BuGJpLSa9DkKMp0DgiMDm4iYMj70gZWKYbI706tWS" crossorigin="anonymous">
    <link rel="stylesheet" href="Css/Styles.css">
    <title>Admin Page</title>
</head>

<body>
    <!-- NAVBAR -->
    <div style="height:10px; background:#27aae1;"></div>
    <nav class="navbar navbar-expand-lg navbar-dark bg-dark">
        <div class="container">
            <a href="#" class="navbar-brand"> MADDIE.COM</a>
            <button class="navbar-toggler" data-toggle="collapse" data-target="#navbarcollapseCMS">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarcollapseCMS">
                <ul class="navbar-nav mr-auto">
                    <li class="nav-item">
                        <a href="MyProfile.php" class="nav-link"> <i class="fas fa-user text-success"></i> My Profile</a>
                    </li>
                    <li class="nav-item">
                        <a href="Dashboard.php" class="nav-link">Dashboard</a>
                    </li>
                    <li class="nav-item">
                        <a href="Posts.php" class="nav-link">Posts</a>
                    </li>
                    <li class="nav-item">
                        <a href="Categories.php" class="nav-link">Categories</a>
                    </li>
                    <li class="nav-item">
                        <a href="Admins.php" class="nav-link">Manage Admins</a>
                    </li>
                    <li class="nav-item">
                        <a href="Comment.php" class="nav-link">Comments</a>
                    </li>
                    <li class="nav-item">
                        <a href="Blog.php?page=1" class="nav-link" target="_blank">Live Blog</a>
                    </li>
                </ul>
                <ul class="navbar-nav ml-auto">
                    <li class="nav-item">
                        <a href="Logout.php" class="nav-link text-danger">
                            <i class="fas fa-user-times"></i> Logout</a>
                    </li>
                </ul>
            </div>
        </div>
    </nav>
    <div style="height:10px; background:#27aae1;"></div>
    <!-- NAVBAR END -->
    <!-- HEADER -->
    <header class="bg-dark text-white py-3">
        <div class="container">
            <div class="row">
                <div class="col-md-12">
                    <h1><i class="fas fa-user" style="color:#27aae1;"></i> Manage Admins</h1>
                </div>
            </div>
        </div>
    </header>
    <!-- HEADER END -->

    <!-- Main Area -->
    <section class="container py-2 mb-4">
        <div class="row">
            <div class="offset-lg-1 col-lg-10" style="min-height:400px;">
                <?php
                echo ErrorMessage();
                echo SuccessMessage();
                ?>
                <form class="" action="Admins.php" method="post">
                    <div class="card bg-secondary text-light mb-3">
                        <div class="card-header">
                            <h1>Add New Admin</h1>
                        </div>
                        <div class="card-body bg-dark">
                            <div class="form-group">
                                <label for="Username"> <span class="FieldInfo"> Username: </span></label>
                                <input class="form-control" type="text" name="Username" id="Username" value="">
                            </div>
                            <div class="form-group">
                                <label for="Name"> <span class="FieldInfo"> Name: </span></label>
                                <input class="form-control" type="text" name="Name" id="Name" value="">
                                <small class="text-muted">Optional</small>
                            </div>
                            <div class="form-group">
                                <label for="Password"> <span class="FieldInfo"> Password: </span></label>
                                <input class="form-control" type="password" name="Password" id="Password" value="">
                            </div>
                            <div class="form-group">
                                <label for="ConfirmPassword"> <span class="FieldInfo"> Confirm Password: </span></label>
                                <input class="form-control" type="password" name="ConfirmPassword" id="ConfirmPassword" value="">
                            </div>
                            <div class="row">
                                <div class="col-lg-6 mb-2">
                                    <a href="Dashboard.php" class="btn btn-warning btn-block"><i class="fas fa-arrow-left"></i> Back To Dashboard</a>
                                </div>
                                <div class="col-lg-6 mb-2">
                                    <button type="submit" name="Submit" class="btn btn-success btn-block">
                                        <i class="fas fa-check"></i> Publish
                                    </button>
                                </div>
                            </div>
                        </div>
                    </div>
                </form>
                <h2>Existing Admins</h2>
                <table class="table table-striped table-hover">
                    <thead class="thead-dark">
                        <tr>
                            <th>No. </th>
                            <th>Date&Time</th>
                            <th> Username</th>
                            <th>Admin Name</th>
                            <th>Added by</th>
                            <th>Action</th>
                        </tr>
                    </thead>
                    <?php
                    global $ConnectingDB;
                    $sql = "SELECT * FROM admins ORDER BY id desc";
                    $Execute = $ConnectingDB->query($sql);
                    $SrNo = 0;
                    while ($DataRows = $Execute->fetch()) {
                        $AdminId = $DataRows["id"];
                        $DateTime = $DataRows["datetime"];
                        $AdminUsername = $DataRows["username"];
                        $AdminName = $DataRows["aname"];
                        $AddedBy = $DataRows["addedby"];

                        $SrNo++;
                    ?>
                        <tbody>
                            <tr>
                                <td><?php echo htmlentities($SrNo); ?></td>
                                <td><?php echo htmlentities($DateTime); ?></td>
                                <td><?php echo htmlentities($AdminUsername); ?></td>
                                <td><?php echo htmlentities($AdminName); ?></td>
                                <td><?php echo htmlentities($AddedBy); ?></td>
                                <td> <a href="DeleteAdmin.php?id=<?php echo $AdminId; ?>" class="btn btn-danger">Delete</a> </td>

                        </tbody>
                    <?php } ?>
                </table>
            </div>
        </div>

    </section>



    <!-- End Main Area -->
    <!-- FOOTER -->
    <footer class="bg-dark text-white">
        <div class="container">
            <div class="row">
                <div class="col">
                    <p class="lead text-center">Theme By | <a style="color: white; text-decoration: none; cursor: pointer;" href="https://madelein-online-portfolio.herokuapp.com/" target="_blank">MADDIE PRETORIUS</a> | <span id="year"></span> &copy; ----All right Reserved.</p>
                    <p class="text-center small"> This site is only used to improve skills &trade; Udemy ; &trade; Skillshare ; &trade; StackSkills</p>
                </div>
            </div>
        </div>
    </footer>
    <div style="height:10px; background:#27aae1;"></div>
    <!-- FOOTER END-->

    <script src="https://code.jquery.com/jquery-3.3.1.slim.min.js" integrity="sha384-q8i/X+965DzO0rT7abK41JStQIAqVgRVzpbzo5smXKp4YfRvH+8abtTE1Pi6jizo" crossorigin="anonymous"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.6/umd/popper.min.js" integrity="sha384-wHAiFfRlMFy6i5SRaxvfOCifBUQy1xHdJ/yoi7FRNXMRBu5WHdZYu1hA6ZOblgut" crossorigin="anonymous"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.2.1/js/bootstrap.min.js" integrity="sha384-B0UglyR+jN6CkvvICOB2joaf5I4l3gm9GU6Hc1og6Ls7i6U/mkkaduKaBhlAXv9k" crossorigin="anonymous"></script>
    <script>
        $('#year').text(new Date().getFullYear());
    </script>
</body>

</html>