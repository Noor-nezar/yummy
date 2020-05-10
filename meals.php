<?php
include './load-env.php';

session_start();
if (!isset($_SESSION["loggedin"]) || $_SESSION["loggedin"] !== true) {
  header("location: admin.php");
}
?>

<?php
if (!empty($_POST) &&  $_POST['form'] == 'logout') {
  session_start();
  $_SESSION = array();
  session_destroy();
  header("location: admin.php");
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

  <nav class="navbar navbar-expand-lg navbar-dark bg-dark">
    <a class="navbar-brand" href="/">Yummy</a>
    <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarColor02" aria-controls="navbarColor02" aria-expanded="false" aria-label="Toggle navigation">
      <span class="navbar-toggler-icon"></span>
    </button>

    <div class="collapse navbar-collapse" id="navbarColor02">
      <ul class="navbar-nav mr-auto">
        <li class="nav-item active">
          <a class="nav-link" href="/meals.php">Meals<span class="sr-only">(current)</span></a>
        </li>
      </ul>
      <form class="form-inline my-2 my-lg-0" method="POST" action="/meals.php">
        <input name="form" type="hidden" value="logout">
        <button class="btn btn-sm  btn-success ml-2 my-2 my-sm-0" type="submit">Logout</button>
      </form>
    </div>
  </nav>

  <div class="container">
    <div class="row">
      <div class="offset-3 col-6">
        <div class="pricing-header px-3 py-3 pt-md-5 pb-md-4 mx-auto text-center">
          <h1 class="display-4">Meals List</h1>
        </div>
      </div>
    </div>

    <?php
    if (!empty($_POST) &&  $_POST['form'] == 'delete') {
      $id =  $_POST['id'];
      echo $id;
      $conn =  mysqli_connect(env('DB_HOST'),  env('DB_USERNAME'),  env('DB_PASSWORD'),  env('DB_NAME'), env('DB_PORT'));
      mysqli_query($conn, "DELETE FROM meals WHERE id= '$id' ");
      mysqli_close($conn);
      header("Location: meals.php");
    }
    ?>

    <div class="table-wrapper">
      <div class="table-title">
        <div class="d-flex justify-content-between">
          <div>
            <h2>Manage Meals</h2>
          </div>
          <div>
            <a href="/meal-form.php" class="btn btn-success" data-toggle="modal">
              <span>Create Meal</span>
            </a>
          </div>
        </div>
      </div>

      <table class="table table-striped table-hover table-bordered">
        <thead>
          <tr>
            <th>Name</th>
            <th>Description</th>
            <th>Actions</th>
          </tr>
        </thead>
        <tbody>
          <tr>
            <?php
            $conn =  mysqli_connect(env('DB_HOST'),  env('DB_USERNAME'),  env('DB_PASSWORD'),  env('DB_NAME'), env('DB_PORT'));
            $sql = 'SELECT * FROM meals ORDER BY id DESC';
            foreach (mysqli_query($conn, $sql) as $row) {
              echo '<tr>';
              echo '<td>' . $row['name'] . '</td>';
              echo '<td>' . $row['description'] . '</td>';
              echo '
              <td style="width: 200px;">
                <div class="d-flex">
                  <div>
                    <a href="/meal-form.php?id=' . $row['id'] . '" class="btn btn-info" data-toggle="modal">
                      Edit
                    </a>
                  </div>
                  <div class="pl-1">
                    <form method="POST" action="/meals.php">
                      <input name="id" type="hidden" value="' . $row['id'] . '">
                      <input name="form" type="hidden" value="delete">
                      <button type="submit" class="btn btn-danger">Delete</button>
                    </form>
                  </div>
                </div>
              </td>';
              echo '</tr>';
            }
            mysqli_close($conn);
            ?>
            </td>
          </tr>
        </tbody>
      </table>
    </div>
  </div>
</body>

</html>