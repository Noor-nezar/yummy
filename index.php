<?php
include './load-env.php';
session_start();
if (!isset($_SESSION["DB-loaded"]) || $_SESSION["DB-loaded"] !== true) {
  include './db-init.php';
}

$loggedin = false;
if (isset($_SESSION["loggedin"]) && $_SESSION["loggedin"] === true) {
  $loggedin = true;
}

$search = '';
if (!empty($_GET['search'])) {
  $search = $_REQUEST['search'];
}
?>

<?php
if (!empty($_POST) &&  $_POST['form'] == 'search') {
  $search = $_POST['search'];
  header("location: index.php?search=$search");
}
?>

<?php
if (!empty($_POST) &&  $_POST['form'] == 'logout') {
  session_start();
  $_SESSION = array();
  session_destroy();
  header("location: index.php");
  exit;
}
?>



<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Yummy</title>

  <link rel="stylesheet" href="./css/bootstrap.min.css">
</head>

<body>

  <nav class="navbar navbar-expand-lg navbar-dark bg-primary">
    <a class="navbar-brand" href="/">Yummy</a>
    <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarColor01" aria-controls="navbarColor01" aria-expanded="false" aria-label="Toggle navigation">
      <span class="navbar-toggler-icon"></span>
    </button>

    <div class="collapse navbar-collapse" id="navbarColor01">
      <ul class="navbar-nav mr-auto">
        <li class="nav-item active">
          <a class="nav-link" href="/admin.php"></a>
        </li>
        <li class="nav-item">
          <a class="nav-link" href="/admin.php">Admin</a>
        </li>
      </ul>
      <form class="form-inline my-2 my-lg-0" method="POST" action="/index.php">
        <input name="form" type="hidden" value="search">
        <input class="form-control mr-sm-2" type="text" <?php if (!empty($search)) : ?> value="<?php echo $search; ?>" <?php endif; ?> name="search" placeholder="Search">
        <button class="btn btn-secondary my-2 my-sm-0" type="submit">Search</button>
      </form>

      <?php if ($loggedin == true) : ?>
        <form class="form-inline my-2 my-lg-0" method="POST" action="/index.php">
          <input name="form" type="hidden" value="logout">
          <button class="btn btn-sm  btn-primary ml-2 my-2 my-sm-0" type="submit">Logout</button>
        </form>
      <?php endif; ?>
    </div>
  </nav>

  <div class="container">
    <div class="row">
      <div class="offset-3 col-6">
        <div class="pricing-header px-3 py-3 pt-md-5 pb-md-4 mx-auto text-center">
          <h1 class="display-4">Yummy Restaurant</h1>
          <h3 class="lead mt-5">Our Meals</h3>
        </div>
      </div>
    </div>
    <div class="row">

      <?php
      $conn =  mysqli_connect(env('DB_HOST'),  env('DB_USERNAME'),  env('DB_PASSWORD'),  env('DB_NAME'), env('DB_PORT'));
      $sql = 'SELECT * FROM meals where name like "%' . $search . '%" ORDER BY id DESC';
      foreach (mysqli_query($conn, $sql) as $row) {
        echo '
          <div class="col-4">
            <div class="card mt-4">
              <div class="card-body">
                <h3 class="card-title">' . $row['name'] . '</h5>
                  <hr>
                  <p class="card-text">' . $row['description'] . '</p>
              </div>
            </div>
          </div>
        ';
      }
      mysqli_close($conn);
      ?>
    </div>
  </div>

</body>

</html>