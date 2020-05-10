<?php
include './load-env.php';

session_start();
if (isset($_SESSION["loggedin"]) && $_SESSION["loggedin"] === true) {
  header("location: meals.php");
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
          <a class="nav-link" href="/admin.php">Admin <span class="sr-only">(current)</span></a>
        </li>
      </ul>
    </div>
  </nav>

  <?php
  if (!empty($_POST)) {
    $email = $_POST['email'];
    $password = $_POST['password'];
    $emailError = null;
    $passwordError = null;
    $loginError = null;

    $valid = true;
    if (empty($email)) {
      $emailError = 'Please enter Email';
      $valid = false;
    }

    if (empty($password)) {
      $passwordError = 'Please enter Password';
      $valid = false;
    }

    if ($valid) {
      $conn =  mysqli_connect(env('DB_HOST'),  env('DB_USERNAME'),  env('DB_PASSWORD'),  env('DB_NAME'), env('DB_PORT'));
      $sql = "SELECT  id FROM users WHERE email = '$email' AND password='$password'";
      $result = mysqli_query($conn, $sql);
      $count = mysqli_num_rows($result);

      if ($count == 1) {
        session_start();
        $_SESSION["loggedin"] = true;
        header("Location: meals.php");
      } else {
        $loginError = 'Wrong email or password';
      }

      mysqli_close($conn);
    }
  }


  ?>

  <div class="container">

    <div class="container">
      <div class="row">
        <div class="offset-3 col-6">
          <div class="pricing-header px-3 py-3 pt-md-5 pb-md-4 mx-auto text-center">
            <h1 class="display-4">Admin Login</h1>
          </div>
        </div>
      </div>

      <div class="mt-4">
        <div class="row">
          <div class="offset-3 col-6">
            <form action="admin.php" method="POST">
              <fieldset>
                <div class="form-group">
                  <label for="exampleInputEmail1">Email address</label>
                  <input type="text" name="email" class="form-control" <?php if (!empty($email)) : ?> value="<?php echo $email; ?>" <?php endif; ?> placeholder="Enter email">
                  <?php if (!empty($emailError)) : ?>
                    <small class="text-danger">
                      <?php echo $emailError; ?>
                    </small>
                  <?php endif; ?>
                </div>
                <div class="form-group">
                  <label for="exampleInputPassword1">Password</label>
                  <input type="password" name="password" class="form-control" <?php if (!empty($password)) : ?> value="<?php echo $password; ?>" <?php endif; ?> placeholder="Password">
                  <?php if (!empty($passwordError)) : ?>
                    <small class="text-danger">
                      <?php echo $passwordError; ?>
                    </small>
                  <?php endif; ?>
                </div>
                <div>
                  <?php if (!empty($loginError)) : ?>
                    <small class="text-danger">
                      <?php echo $loginError; ?>
                    </small>
                  <?php endif; ?>
                </div>
                <div>
                  <button type="submit" class="btn btn-primary">Submit</button>
                </div>
              </fieldset>
            </form>
          </div>
        </div>
      </div>



    </div>

  </div>

</body>

</html>