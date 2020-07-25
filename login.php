<?php
ob_start();
session_start();
require_once 'php_actions/db_connect.php';

if (isset($_SESSION['user']) != "") {
    header("Location: index.php");
    exit;
}
if (isset($_SESSION['admin'])) {
    header('Location: admin.php');
    exit;
}
if (isset($_SESSION['superadmin'])) {
    header('Location: admin.php');
    exit;
}

$redirectTo = "index.php";
if (isset($_SESSION["redirectTo"])) {
    $redirectTo = $_SESSION["redirectTo"];
}

if ($loggedUser) {
    $res = mysqli_query($conn, "SELECT * FROM cr11_vedrana_petadoption.users WHERE id=" . $_SESSION['user']);
    $userRow = mysqli_fetch_array($res, MYSQLI_ASSOC);
} else if ($loggedAdmin) {
    $res = mysqli_query($conn, "SELECT * FROM cr11_vedrana_petadoption.users WHERE id=" . $_SESSION['admin']);
    $userRow = mysqli_fetch_array($res, MYSQLI_ASSOC);
} else if ($loggedSuperadmin) {
    $res = mysqli_query($conn, "SELECT * FROM cr11_vedrana_petadoption.users WHERE id=" . $_SESSION['superadmin']);
    $userRow = mysqli_fetch_array($res, MYSQLI_ASSOC);
}


$error = false;


if (isset($_POST['btn-login'])) {

    // prevent sql injections/ clear user invalid inputs
    $email = trim($_POST['email']);
    $email = strip_tags($email);
    $email = htmlspecialchars($email);

    $pass = trim($_POST['pass']);
    $pass = strip_tags($pass);
    $pass = htmlspecialchars($pass);
    // prevent sql injections / clear user invalid inputs

    if (empty($email)) {
        $error = true;
        $emailError = "Please enter your email address.";
    } else if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $error = true;
        $emailError = "Please enter valid email address.";
    }

    if (empty($pass)) {
        $error = true;
        $passError = "Please enter your password.";
    }

    // if there's no error, continue to login
    if (!$error) {

        $password = hash('sha256', $pass); // password hashing

        $res = mysqli_query($conn, "SELECT id as userId, userName, userPass, status FROM cr11_vedrana_petadoption.users WHERE userEmail='$email'");
        $row = mysqli_fetch_array($res, MYSQLI_ASSOC);
        $count = mysqli_num_rows($res); // if uname/pass is correct it returns must be 1 row

        if ($count == 1 && $row['userPass'] == $password) {
            switch ($row['status']) {
                case "admin":
                    $_SESSION['admin'] = $row['userId'];
                    header("Location: admin.php");
                    break;
                case "superadmin":
                    $_SESSION['superadmin'] = $row['userId'];
                    header("Location: admin.php");
                    break;
                default:
                    $_SESSION['user'] = $row['userId'];
                    header("Location: $redirectTo");
            }
        } else {
            $errMSG = "Incorrect Credentials, Try again...";
            $errTyp = "warning";
        }
    }
}
?>

    <!doctype html>
    <html lang="en">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport"
              content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
        <meta http-equiv="X-UA-Compatible" content="ie=edge">
        <title>pet-adopt</title>
        <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.0/css/bootstrap.min.css"
              integrity="sha384-9aIt2nRpC12Uk9gS9baDl411NQApFmC26EwAOH8WgZl5MYYxFfc+NcPb1dKGj7Sk"
              crossorigin="anonymous">
        <link rel="stylesheet" href="style/main.css">
    </head>
    <body>

    <nav class="navbar sticky-top navbar-expand-lg navbar-light bg-light">
        <a class="navbar-brand" href="index.php">pet-adopt</a>
        <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarNavDropdown"
                aria-controls="navbarNavDropdown" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="navbarNavDropdown">
            <ul class="navbar-nav mr-auto mt-2 mt-lg-0">
                <?php if ($loggedAdmin || $loggedSuperadmin) : ?>
                    <li class="nav-item">
                        <a class="nav-link text-info" href="admin.php">Admin panel</a>
                    </li>
                <?php endif; ?>
                <?php if (!$loggedAdmin) : ?>
                    <li class="nav-item active">
                        <a class="nav-link" href="index.php">Home<span class="sr-only">(current)</span></a>
                    </li>
                <?php endif; ?>
                <?php if ($loggedIn) : ?>
                    <li class="nav-item">
                        <a class="nav-link" href="large_animals.php">Large animals</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="small_animals.php">Small animals</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="senior_animals.php">Senior animals</a>
                    </li>
                    <li class="nav-item ">
                        <a class="nav-link" href="general.php">Under 8 Years</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="search_animals.php">Search</a>
                    </li>
                <?php endif; ?>
            </ul>

            <?php if ($loggedUser) : ?>
                <span class="navbar-text text-right mr-5">Logged in as user: <b><?php echo $userRow['useremail']; ?></b></span>
            <?php endif; ?>
            <?php if ($loggedAdmin) : ?>
                <span class="navbar-text text-right mr-5">Logged in as admin: <b><?php echo $userRow['useremail']; ?></b></span>
            <?php endif; ?>
            <?php if ($loggedSuperadmin) : ?>
                <span class="navbar-text text-right mr-5">Logged in as superadmin: <b><?php echo $userRow['useremail']; ?></b></span>
            <?php endif; ?>

            <ul class="navbar-nav">
                <?php if (!$loggedIn) : ?>
                    <li class="nav-item">
                        <a class="nav-item nav-link" href="login.php">Login</a>
                    </li>
                <?php else: ?>
                    <li class="nav-item">
                        <a class="nav-item nav-link mr-auto text-right" href="logout.php?logout">Logout</a>
                    </li>
                <?php endif; ?>
            </ul>
        </div>
    </nav>

    <div class="jumbotron jumbotron-fluid">
        <div class="container">
            <h1 class="display-4 mt-3">Adopt don't shop!</h1>
            <p class="lead">Lorem ipsum dolor sit amet, consectetur adipisicing elit. Ad animi eos harum obcaecati
                perspiciatis. Architecto consectetur fugit, iure laboriosam magni minima non quia rerum similique
                voluptas?
                Ducimus eaque molestias quo!</p>
        </div>
    </div>

    <div class="container">
        <?php if (!$loggedIn) : ?>
            <div class="row">
                <div class="col-8 m-auto">
                    <p class="text-center">Please login or register if you want to get more info about our precious
                        pets.</p>
                </div>
            </div>
        <?php endif; ?>


        <form class="col-md-6 mx-auto mt-5" method="post" action="<?php echo htmlspecialchars($_SERVER['PHP_SELF']); ?>"
              autocomplete="off">
            <h2 class="text-center">Sign In</h2>
            <p class="text-center h5">or <b><a href="register.php">sign up here </a></b>if you are a new user.</p>
            <hr>
            <div class="alert text-<?php echo $errTyp ?> text-center">
                <?php
                if (isset($errMSG)) {
                    echo $errMSG; ?>
                <?php } ?>
            </div>
            <div class="form-group">
                <label for="email">e-mail:</label>
                <input type="email" name="email" class="form-control" placeholder="Your Email"
                       value="<?php echo $email; ?>"
                       maxlength="40"/>
                <span class="text-danger"><?php echo $emailError; ?></span>
            </div>
            <div class="form-group">
                <label for="pass">Password</label>
                <input type="password" name="pass" class="form-control" placeholder="Your Password" maxlength="15"/>
                <span class="text-danger"><?php echo $passError; ?></span>
            </div>
            <button class="btn-block btn btn-primary" type="submit" name="btn-login">Sign In</button>
        </form>

    </div>

    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"
            integrity="sha384-DfXdz2htPH0lsSSs5nCTpuj/zy4C+OGpamoFVy38MVBnE+IbbVYUew+OrCXaRkfj"
            crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.0/dist/umd/popper.min.js"
            integrity="sha384-Q6E9RHvbIyZFJoft+2mJbHaEWldlvI9IOYy5n3zV9zzTtmI3UksdQRVvoxMfooAo"
            crossorigin="anonymous"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.0/js/bootstrap.min.js"
            integrity="sha384-OgVRvuATP1z7JjHLkuOU7Xw704+h835Lr+6QL9UvYjZE3Ipu6Tp75j7Bh/kR0JKI"
            crossorigin="anonymous"></script>
    </body>
    </html>
<?php ob_end_flush(); ?>