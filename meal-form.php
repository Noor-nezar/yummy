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



  <?php
  $id = null;

  if (!empty($_GET['id'])) {
    $id = $_REQUEST['id'];
    $conn =  mysqli_connect(env('DB_HOST'),  env('DB_USERNAME'),  env('DB_PASSWORD'),  env('DB_NAME'), env('DB_PORT'));
    $sql = "SELECT name, description FROM meals WHERE id = $id";
    $result = mysqli_query($conn, $sql);
    $row = mysqli_fetch_array($result, MYSQLI_ASSOC);
    $count = mysqli_num_rows($result);
    if ($count == 0) {
      header("Location: meals.php");
    } else {
      $name = $row['name'];
      $description = $row['description'];
    }
    mysqli_close($conn);
  }

  if (!empty($_POST) &&  $_POST['form'] == 'meal-form') {
    if (!empty($_POST['id'])) {
      $id =  $_POST['id'];
    }

    $name = $_POST['name'];
    $description = $_POST['description'];
    $nameError = null;
    $descriptionError = null;

    $valid = true;
    if (empty($name)) {
      $nameError = 'Please enter Name';
      $valid = false;
    }

    if (empty($description)) {
      $descriptionError = 'Please enter Description';
      $valid = false;
    }

    if ($valid) {
      $conn =  mysqli_connect(env('DB_HOST'),  env('DB_USERNAME'),  env('DB_PASSWORD'),  env('DB_NAME'), env('DB_PORT'));

      if (($id == null)) {
        mysqli_query($conn, "INSERT INTO meals (name, description)VALUES('$name', '$description')");
      } else {
        mysqli_query($conn, "UPDATE meals SET name='$name', description='$description' WHERE id= '$id' ");
      }

      mysqli_close($conn);
      header("Location: meals.php");
    }
  }
  ?>

  <div class="container">
    <div class="row">
      <div class="offset-3 col-6">
        <div class="pricing-header px-3 py-3 pt-md-5 pb-md-4 mx-auto text-center">
          <h1 class="display-4">


            <?php if (empty($id)) : ?>
              Create Meal
            <?php else : ?>
              Edit Meal
            <?php endif; ?>
          </h1>
        </div>
      </div>
    </div>


    <div class="mt-4">
      <div class="row">
        <div class="offset-3 col-6">
          <form method="POST" action="/meal-form.php">
            <input name="form" type="hidden" value="meal-form">

            <?php if (!empty($id)) : ?>
              <input name="id" type="hidden" value="<?php echo $id; ?>">
            <?php endif; ?>

            <fieldset>
              <div class="form-group">
                <label for="name">Name</label>
                <input class="form-control" name="name" <?php if (!empty($name)) : ?> value="<?php echo $name; ?>" <?php endif; ?> placeholder="Meal Name">
                <?php if (!empty($nameError)) : ?>
                  <small class="text-danger">
                    <?php echo $nameError; ?>
                  </small>
                <?php endif; ?>
              </div>
              <div class="form-group">
                <label for="description">Description</label>
                <textarea class="form-control" name="description" placeholder="Meal Description" rows="5"><?php if (!empty($description)) : ?><?php echo $description; ?><?php endif; ?></textarea>
                <?php if (!empty($descriptionError)) : ?>
                  <small class="text-danger">
                    <?php echo $descriptionError; ?>
                  </small>
                <?php endif; ?>
              </div>

              <div>
                <button type="submit" class="btn btn-primary" name="save">Save</button>
                <a href="/meals.php" class="btn btn-secondary">Cancel</a>
              </div>
            </fieldset>
          </form>
        </div>
      </div>
    </div>



  </div>

</body>

</html>