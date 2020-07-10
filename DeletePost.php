<?php require_once("Includes/DB.php"); ?>
<?php require_once("Includes/Functions.php"); ?>
<?php require_once("Includes/Sessions.php"); ?>
<?php Confirm_Login(); ?>

<?php
$SearchQueryParameter = $_GET['id'];
global $ConnectingDB;

$sql = "SELECT * FROM posts WHERE id ='$SearchQueryParameter'";
$stmtPost = $ConnectingDB->query($sql);
while ($DataRows = $stmtPost->fetch()) {
    $TitleToBeUpdated = $DataRows['title'];
    $CatagoryToBeUpdated = $DataRows['category'];
    $ImageToBeUpdated = $DataRows['image'];
    $PostToBeUpdated = $DataRows['post'];
}

if (isset($_POST["Submit"])) {
    // Query to delete Post in DB When everything is fine
    global $ConnectingDB;
    $sql = "DELETE FROM posts WHERE id='$SearchQueryParameter'";
    $Execute = $ConnectingDB->query($sql);
    if ($Execute) {
        $Target_Path_To_DELETE_Image = "Uploads/$ImageToBeDeleted";
        unlink($Target_Path_To_DELETE_Image);
        $_SESSION["SuccessMessage"] = "Post Deleted Successfully";
        Redirect_to("Posts.php");
    } else {
        $_SESSION["ErrorMessage"] = "Something went wrong. Try Again !";
        Redirect_to("Posts.php");
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
    <title>Edit Post</title>
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
                    <h1><i class="fas fa-trash" style="color:#27aae1;"></i> Delete Posts</h1>
                </div>
                <div class="col-lg-3 mb-2">
                    <a href="AddNewPost.php" class="btn btn-primary btn-block">
                        <i class="fas fa-edit"></i> Add New Post
                    </a>
                </div>
                <div class="col-lg-3 mb-2">
                    <a href="Categories.php" class="btn btn-info btn-block">
                        <i class="fas fa-folder-plus"></i> Add New Category
                    </a>
                </div>
                <div class="col-lg-3 mb-2">
                    <a href="Admins.php" class="btn btn-warning btn-block">
                        <i class="fas fa-user-plus"></i> Add New Admin
                    </a>
                </div>
                <div class="col-lg-3 mb-2">
                    <a href="Comments.php" class="btn btn-success btn-block">
                        <i class="fas fa-check"></i> Approve Comments
                    </a>
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
                // connect db
                ?>
                <form class="" action="DeletePost.php?id=<?php echo $SearchQueryParameter ?>" method="post" enctype="multipart/form-data">
                    <div class="card bg-secondary text-light mb-3">
                        <div class="card-body bg-dark">
                            <div class="form-group">
                                <label for="title"> <span class="FieldInfo"> Post Title: </span></label>
                                <input disabled class="form-control" type="text" name="PostTitle" id="title" placeholder="Type title here" value="<?php echo $TitleToBeUpdated ?>">
                            </div>
                            <div class="form-group">
                                <span class="FieldInfo">Exisiting Category:</span>
                                <?php echo $CatagoryToBeUpdated ?>
                            </div>
                            <div class="form-group">
                                <span class="FieldInfo">Exisiting Image:</span>
                                <img src="Uploads/<?php echo $ImageToBeUpdated ?>" />
                            </div>
                            <div class="form-group">
                                <label for="Post"> <span class="FieldInfo"> Post: </span></label>
                                <textarea disabled class="form-control" id="Post" name="PostDescription" rows="8" cols="80">
                                    <?php echo $PostToBeUpdated ?>
                                </textarea>
                            </div>
                            <div class="row">
                                <div class="col-lg-6 mb-2">
                                    <a href="Dashboard.php" class="btn btn-warning btn-block"><i class="fas fa-arrow-left"></i> Back To Dashboard</a>
                                </div>
                                <div class="col-lg-6 mb-2">
                                    <button type="submit" name="Submit" class="btn btn-danger btn-block">
                                        <i class="fas fa-trash"></i> Delete
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