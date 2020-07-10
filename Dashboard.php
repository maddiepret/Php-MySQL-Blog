<?php require_once("Includes/DB.php"); ?>
<?php require_once("Includes/Functions.php"); ?>
<?php require_once("Includes/Sessions.php"); ?>
<?php
$_SESSION["TrackingURL"] = $_SERVER["PHP_SELF"];
Confirm_Login();
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
  <title>Dashboard</title>
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
          <h1><i class="fas fa-cog" style="color:#27aae1;"></i> Dashboard</h1>
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
        <div class="col-lg-3 mb-2 ">
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
      <!-- Left Side Area Start -->
      <div class="col-lg-2 d-none d-md-block">
        <div class="card text-center bg-dark text-white mb-3">
          <div class="card-body">
            <h1 class="lead">Posts</h1>
            <h4 class="display-5">
              <i class="fab fa-readme"></i>
              <?php TotalPosts(); ?>
            </h4>
          </div>
        </div>

        <div class="card text-center bg-dark text-white mb-3">
          <div class="card-body">
            <h1 class="lead">Categories</h1>
            <h4 class="display-5">
              <i class="fas fa-folder"></i>
              <?php TotalCategories(); ?>
            </h4>
          </div>
        </div>

        <div class="card text-center bg-dark text-white mb-3">
          <div class="card-body">
            <h1 class="lead">Admins</h1>
            <h4 class="display-5">
              <i class="fas fa-users"></i>
              <?php TotalAdmins(); ?>
            </h4>
          </div>
        </div>
        <div class="card text-center bg-dark text-white mb-3">
          <div class="card-body">
            <h1 class="lead">Comments</h1>
            <h4 class="display-5">
              <i class="fas fa-comments"></i>
              <?php TotalComments(); ?>
            </h4>
          </div>
        </div>

      </div>
      <!-- Left Side Area End -->
      <!-- Right Side Area Start -->
      <div class="col-lg-10">
        <?php
        echo ErrorMessage();
        echo SuccessMessage();
        ?>
        <h1>Top Posts</h1>
        <table class="table table-striped table-hover">
          <thead class="thead-dark">
            <tr>
              <th>No.</th>
              <th>Title</th>
              <th>Date&Time</th>
              <th>Author</th>
              <th>Comments</th>
              <th>Details</th>
            </tr>
          </thead>
          <?php
          $SrNo = 0;
          global $ConnectingDB;
          $sql = "SELECT * FROM posts ORDER BY id desc LIMIT 0,6";
          $stmt = $ConnectingDB->query($sql);
          while ($DataRows = $stmt->fetch()) {
            $PostId = $DataRows["id"];
            $DateTime = $DataRows["datetime"];
            $Author  = $DataRows["author"];
            $Title = $DataRows["title"];
            $SrNo++;
          ?>
            <tbody>
              <tr>
                <td><?php echo $SrNo; ?></td>
                <td><?php echo $Title; ?></td>
                <td><?php echo $DateTime; ?></td>
                <td><?php echo $Author; ?></td>
                <td>
                  <?php $Total = ApproveCommentsAccordingtoPost($PostId);
                  if ($Total > 0) {
                  ?>
                    <span class="badge badge-success">
                      <?php
                      echo $Total; ?>
                    </span>
                  <?php  }   ?>
                  <?php $Total = DisApproveCommentsAccordingtoPost($PostId);
                  if ($Total > 0) {  ?>
                    <span class="badge badge-danger">
                      <?php
                      echo $Total; ?>
                    </span>
                  <?php  }  ?>
                </td>
                <td> <a target="_blank" href="FullPost.php?id=<?php echo $PostId; ?>">
                    <span class="btn btn-info">Preview</span>
                  </a>
                </td>
              </tr>
            </tbody>
          <?php } ?>

        </table>

      </div>
      <!-- Right Side Area End -->


    </div>
  </section>
  <!-- Main Area End -->

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