<?php require_once("Includes/DB.php"); ?>
<?php require_once("Includes/Functions.php"); ?>
<?php require_once("Includes/Sessions.php"); ?>
<?php $_SESSION["TrackingURL"] = $_SERVER["PHP_SELF"];
Confirm_Login(); ?>
<?php
// Fetching the existing Admin Data Start
$AdminId = $_SESSION["UserId"];
global $ConnectingDB;
$sql  = "SELECT * FROM admins WHERE id='$AdminId'";
$stmt = $ConnectingDB->query($sql);
while ($DataRows = $stmt->fetch()) {
    $ExistingName     = $DataRows['aname'];
    $ExistingUsername = $DataRows['username'];
    $ExistingHeadline = $DataRows['aheadline'];
    $ExistingBio      = $DataRows['abio'];
    $ExistingImage    = $DataRows['aimage'];
}
// Fetching the existing Admin Data End
if (isset($_POST["Submit"])) {
    $AName     = $_POST["Name"];
    $AHeadline = $_POST["Headline"];
    $ABio      = $_POST["Bio"];
    $Image     = $_FILES["Image"]["name"];
    $Target    = "Images/" . basename($_FILES["Image"]["name"]);
    if (strlen($AHeadline) > 30) {
        $_SESSION["ErrorMessage"] = "Headline Should be less than 30 characters";
        Redirect_to("MyProfile.php");
    } elseif (strlen($ABio) > 500) {
        $_SESSION["ErrorMessage"] = "Bio should be less than than 500 characters";
        Redirect_to("MyProfile.php");
    } else {
        // Query to Update Admin Data in DB When everything is fine
        global $ConnectingDB;
        if (!empty($_FILES["Image"]["name"])) {
            $sql = "UPDATE admins
              SET aname='$AName', aheadline='$AHeadline', abio='$ABio', aimage='$Image'
              WHERE id='$AdminId'";
        } else {
            $sql = "UPDATE admins
              SET aname='$AName', aheadline='$AHeadline', abio='$ABio'
              WHERE id='$AdminId'";
        }
        $Execute = $ConnectingDB->query($sql);
        move_uploaded_file($_FILES["Image"]["tmp_name"], $Target);
        if ($Execute) {
            $_SESSION["SuccessMessage"] = "Details Updated Successfully";
            Redirect_to("MyProfile.php");
        } else {
            $_SESSION["ErrorMessage"] = "Something went wrong. Try Again !";
            Redirect_to("MyProfile.php");
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
    <title>My Profile</title>
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
                    <li class="nav-item"><a href="Logout.php" class="nav-link text-danger">
                            <i class="fas fa-user-times"></i> Logout</a></li>
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
                    <h1><i class="fas fa-user text-success mr-2"></i>@<?php echo $ExistingUsername; ?></h1>
                </div>
            </div>
        </div>
    </header>
    <!-- HEADER END -->

    <!-- Main Area -->
    <section class="container py-2 mb-4">
        <div class="row">
            <!-- Left Area -->
            <div class="col-md-3">
                <div class="card">
                    <div class="card-header bg-dark text-light">
                        <h3> <?php echo $ExistingName; ?></h3>
                        <small> <?php echo $ExistingHeadline; ?></small>

                    </div>
                    <div class="card-body">
                        <img src="Images/<?php echo $ExistingImage ?>" class="block img-fluid mb-3" alt="">
                        <div class="">
                            <?php echo $ExistingBio ?>
                        </div>
                    </div>
                </div>
            </div>
            <!-- Righ Area -->
            <div class="col-md-9" style="min-height:400px;">
                <?php
                echo ErrorMessage();
                echo SuccessMessage();
                ?>
                <form class="" action="MyProfile.php" method="post" enctype="multipart/form-data">
                    <div class="card bg-dark text-light">
                        <div class="card-header bg-secondary text-light">
                            <h4>Edit Profile</h4>
                        </div>
                        <div class="card-body">
                            <div class="form-group">
                                <input class="form-control" type="text" name="Name" id="title" placeholder="Your name" value="<?php echo $ExistingName; ?>">
                            </div>
                            <div class="form-group">
                                <input class="form-control" type="text" id="title" placeholder="Headline" name="Headline" value="<?php echo $ExistingHeadline; ?>">
                                <small class="text-muted"> Add a professional headline like, 'Engineer' at XYZ or 'Architect' </small>
                                <span class="text-danger">Not more than 30 characters</span>
                            </div>
                            <div class="form-group">
                                <textarea placeholder="Bio" class="form-control" id="Post" name="Bio" rows="8" cols="80"><?php echo $ExistingBio; ?></textarea>
                            </div>

                            <div class="form-group">
                                <div class="custom-file">
                                    <input class="custom-file-input" type="File" name="Image" id="imageSelect" value="">
                                    <label for="imageSelect" class="custom-file-label">Select Image </label>
                                </div>
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