<?php require_once("Includes/DB.php"); ?>
<?php require_once("Includes/Functions.php"); ?>
<?php require_once("Includes/Sessions.php"); ?>
<?php
$_SESSION["TrackingURL"] = $_SERVER["PHP_SELF"];
Confirm_Login(); ?>
<?php
if (isset($_POST["Submit"])) {
    $PostTitle = $_POST["PostTitle"];
    $Category  = $_POST["Category"];
    $Image     = $_FILES["Image"]["name"];
    $Target    = "Uploads/" . basename($_FILES["Image"]["name"]);
    $PostText  = $_POST["PostDescription"];
    $Admin = 'Maddie';
    $CurrentTime = time();
    $DateTime = strftime("%B-%d-%Y %H:%M:%S", $CurrentTime);

    if (empty($PostTitle)) {
        $_SESSION["ErrorMessage"] = "Title Cant be empty";
        Redirect_to("AddNewPost.php");
    } elseif (strlen($PostTitle) < 5) {
        $_SESSION["ErrorMessage"] = "Post Title should be greater than 5 characters";
        Redirect_to("AddNewPost.php");
    } elseif (strlen($PostText) > 9999) {
        $_SESSION["ErrorMessage"] = "Post Description should be less than than 1000 characters";
        Redirect_to("AddNewPost.php");
    } else {
        // Query to insert Post in DB When everything is fine
        global $ConnectingDB;
        $sql = "INSERT INTO posts(datetime,title,category,author,image,post)";
        $sql .= "VALUES(:dateTime,:postTitle,:categoryName,:adminName,:imageName,:postDescription)";
        $stmt = $ConnectingDB->prepare($sql);
        $stmt->bindValue(':dateTime', $DateTime);
        $stmt->bindValue(':postTitle', $PostTitle);
        $stmt->bindValue(':categoryName', $Category);
        $stmt->bindValue(':adminName', $Admin);
        $stmt->bindValue(':imageName', $Image);
        $stmt->bindValue(':postDescription', $PostText);
        $Execute = $stmt->execute();
        move_uploaded_file($_FILES["Image"]["tmp_name"], $Target);
        if ($Execute) {
            $_SESSION["SuccessMessage"] = "Post with id : " . $ConnectingDB->lastInsertId() . " added Successfully";
            Redirect_to("AddNewPost.php");
        } else {
            $_SESSION["ErrorMessage"] = "Something went wrong. Try Again !";
            Redirect_to("AddNewPost.php");
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
    <title>Posts</title>
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
                    <h1><i class="fas fa-edit" style="color:#27aae1;"></i> ADD Posts</h1>
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
                    <a href="Comment.php" class="btn btn-success btn-block">
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
            <div class="col-lg-12">
                <?php
                echo ErrorMessage();
                echo SuccessMessage();
                ?>
                <table class="table table-striped table-hover">
                    <thead class="thead-dark">
                        <tr>
                            <th>#</th>
                            <th>Title</th>
                            <th>Category</th>
                            <th>Date&Time</th>
                            <th>Author</th>
                            <th>Banner</th>
                            <th>Comments</th>
                            <th>Action</th>
                            <th>Live Preview</th>
                        </tr>
                        <?php
                        global $ConnectingDB;
                        $sql = "SELECT * FROM posts";
                        $stmt = $ConnectingDB->query($sql);
                        $Sr = 0;
                        while ($DataRows = $stmt->fetch()) {
                            $Id = $DataRows["id"];
                            $DateTime = $DataRows["datetime"];
                            $PostTitle = $DataRows["title"];
                            $Category = $DataRows["category"];
                            $Admin = $DataRows["author"];
                            $Image = $DataRows["image"];
                            $PostText = $DataRows["post"];
                            $Sr++;

                        ?>
                            <tr>
                                <td><?php echo $Sr; ?></td>
                                <td>
                                    <?php if (strlen($PostTitle) > 20) {
                                        $PostTitle = substr($PostTitle, 0, 20) . '..';
                                    }
                                    echo $PostTitle; ?>
                                </td>
                                <td>
                                    <?php
                                    if (strlen($Category) > 10) {
                                        $Category = substr($Category, 0, 10) . '..';
                                    }
                                    echo $Category;
                                    ?>
                                </td>
                                <td>
                                    <?php
                                    if (strlen($DateTime) > 11) {
                                        $DateTime = substr($DateTime, 0, 11) . '..';
                                    }
                                    echo $DateTime;
                                    ?>
                                </td>
                                <td>
                                    <?php
                                    if (strlen($Admin) > 6) {
                                        $Admin = substr($Admin, 0, 6) . '..';
                                    }
                                    echo $Admin;
                                    ?>
                                </td>
                                <td>
                                    <img src="Uploads/<?php echo $Image; ?>" width="170px;" height="50px">
                                </td>
                                <td>
                                    <?php $Total = ApproveCommentsAccordingtoPost($Id);
                                    if ($Total > 0) {
                                    ?>
                                        <span class="badge badge-success">
                                            <?php
                                            echo $Total; ?>
                                        </span>
                                    <?php  }  ?>
                                    <?php $Total = DisApproveCommentsAccordingtoPost($Id);
                                    if ($Total > 0) {
                                    ?>
                                        <span class="badge badge-danger">
                                            <?php
                                            echo $Total;  ?>
                                        </span>
                                    <?php  }    ?>
                                </td>

                                <td><a href="EditPost.php?id=<?php echo $Id; ?>"><span class="btn btn-warning">Edit</span></a>
                                    <a href="DeletePost.php?id=<?php echo $Id; ?>"><span class="btn btn-danger">Delete</span></a>
                                </td>
                                <td> <a href="FullPost.php?id=<?php echo $Id; ?>" target="_blank"><span class="btn btn-primary">Live Preview</span></a>
                                </td>
                            </tr>
                        <?php } ?>
                    </thead>
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