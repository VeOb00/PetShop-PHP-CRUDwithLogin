<?php
ob_start();
session_start();
require_once 'php_actions/db_connect.php';

if (!isset($_SESSION['user']) && !isset($_SESSION['admin']) && !isset($_SESSION['superadmin'])) {
    if (isset($_GET["id"])) {
        $id = $_GET["id"];
        $query = "?id=$id";
    }
    $_SESSION['redirectTo'] = "animal_info.php$query";
    header("Location: login.php");
    exit;
}

$loggedUser = false;
if (isset($_SESSION["user"])) {
    $loggedUser = true;
}
$loggedAdmin = false;
if (isset($_SESSION["admin"])) {
    $loggedAdmin = true;
}

$loggedSuperadmin = false;
if (isset($_SESSION["superadmin"])) {
    $loggedSuperadmin = true;
}

$loggedIn = $loggedUser || $loggedAdmin || $loggedSuperadmin;

// select logged-in users details

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

$resultAnimals = mysqli_query($conn, "Select *, TIMESTAMPDIFF(YEAR, date_of_birth, CURDATE()) AS age from cr11_vedrana_petadoption.animals");

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
                    <li class="nav-item">
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
        <div class="row">
            <?php
            if ($_GET["id"]) {
            $id = $_GET["id"];

            $sql = "SELECT *, TIMESTAMPDIFF(YEAR, date_of_birth, CURDATE()) AS age from cr11_vedrana_petadoption.animals where id = $id";
            $resultAnimals = mysqli_query($conn, $sql);


            $row = $resultAnimals->fetch_assoc();
            $id = $row["id"];
            $name = $row["name"];
            $date_of_birth = $row["date_of_birth"];
            $image = $row["image"];
            $size = $row["size"];
            $type = $row["type"];
            $location = $row["location"];
            $gender = $row["gender"];
            $description = $row["description"];
            $hobbies = $row["hobbies"];
            $description = $row["description"];
            $age = $row["age"];
            ?>

            <div class="col-md-7">
                <img class="" src="<?= "upload/" . $image ?>" alt="<?= $name ?> image">
            </div>
            <div class="col-md-5">
                <h3 class=""><?= $name; ?>
                    <?php if ($gender == "female") : ?>
                        <img src="media/female.png" class="logo" alt="female">
                    <?php endif; ?>
                    <?php if ($gender == "male") : ?>
                        <img src="media/male.png" class="logo" alt="male">
                    <?php endif; ?>
                </h3>
                <h5><?= $type ?></h5>
                <hr>
                <dl>
                    <dt>Age:</dt>
                    <dd><?= $age . " years old, <br><small class='text-secondary'>date of birth: " . $date_of_birth . "</small>" ?></dd>
                    <dt>Animal size:</dt>
                    <dd><?= $size ?></dd>
                    <dt>Gender:</dt>
                    <dd><?= $gender ?></dd>
                    <dt>Location:</dt>
                    <dd><?= $location ?></dd>
                    <dt>Hobbies:</dt>
                    <dd><?= $hobbies ?></dd>
                </dl>
                <hr>
                <p> <?= $description ?> </p>

            </div>
        </div>

        <?php
        }
        ?>
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