<?php
ob_start();
session_start();
require_once 'db_connect.php';

if (!isset($_SESSION['admin']) && !isset($_SESSION['superadmin'])) {
    header("Location: index.php");
    exit;
}

$loggedAdmin = false;
if (isset($_SESSION["admin"])) {
    $loggedAdmin = true;
}
$loggedSuperadmin = false;
if (isset($_SESSION["superadmin"])) {
    $loggedSuperadmin = true;
}

$loggedIn = $loggedAdmin || $loggedSuperadmin;


// select logged-in users details

if ($loggedAdmin) {
    $res = mysqli_query($conn, "SELECT * FROM cr11_vedrana_petadoption.users WHERE id=" . $_SESSION['admin']);
    $userRow = mysqli_fetch_array($res, MYSQLI_ASSOC);
} else if ($loggedSuperadmin) {
    $res = mysqli_query($conn, "SELECT * FROM cr11_vedrana_petadoption.users WHERE id=" . $_SESSION['superadmin']);
    $userRow = mysqli_fetch_array($res, MYSQLI_ASSOC);
}
$resultAnimals = mysqli_query($conn, "Select * from cr11_vedrana_petadoption.animals");

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
    <link rel="stylesheet" href="../style/main.css">
    <link rel="stylesheet" href="../style/admin.css">
</head>
<body>

<nav class="navbar sticky-top navbar-expand-lg navbar-light bg-light">
    <a class="navbar-brand" href="../index.php">pet-adopt</a>
    <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarNavDropdown"
            aria-controls="navbarNavDropdown" aria-expanded="false" aria-label="Toggle navigation">
        <span class="navbar-toggler-icon"></span>
    </button>
    <div class="collapse navbar-collapse" id="navbarNavDropdown">
        <ul class="navbar-nav mr-auto mt-2 mt-lg-0">
            <li class="nav-item active">
                <a class="nav-link" href="../admin.php">Admin panel<span class="sr-only">(current)</span></a>
            </li>
            <li class="nav-item">
                <a class="nav-link" href="../index.php">Page preview</a>
            </li>
        </ul>

        <?php if ($loggedAdmin) : ?>
            <span class="navbar-text text-right mr-5">Logged in as admin: <b><?php echo $userRow['useremail']; ?></b></span>
        <?php endif; ?>
        <?php if ($loggedSuperadmin) : ?>
            <span class="navbar-text text-right mr-5">Logged in as superadmin: <b><?php echo $userRow['useremail']; ?></b></span>
        <?php endif; ?>

        <ul class="navbar-nav">
            <?php if (!$loggedIn) : ?>
                <li class="nav-item">
                    <a class="nav-item nav-link" href="../login.php">Login</a>
                </li>
            <?php else: ?>
                <li class="nav-item">
                    <a class="nav-item nav-link mr-auto text-right" href="../logout.php?logout">Logout</a>
                </li>
            <?php endif; ?>
        </ul>
    </div>
</nav>

<div class="row col-12">
    <nav class="sidebar-menu col-md-2 navbar-dark bg-dark pt-4">
        <ul class="navbar-nav">
            <li class="nav-item">
                <a class="nav-item nav-link" href="../admin.php">Admin panel</a>
            </li>
            <li class="nav-item">
                <a class="nav-item nav-link active" href="../edit_index.php">Edit content</a>
            </li>
            <li class="nav-item">
                <a class="nav-item nav-link" href="../add_animals.php">Add content</a>
            </li>
        </ul>
    </nav>
    <div class="col-md-10 pt-4 mx-auto">
        <div class="col-md-8 ml-3">
            <h1>Edit existing content</h1>
            <br>
            <p>Here you can edit the existing entries in the database.</p>
        </div>
        <div class="row ml-3 mt-5">

                <?php

                function getDatabaseCompatibleValue($parameter)
                {
                    $value = $_POST[$parameter];
                    if (isset($value) || $value != "") {
                        $trimed_string = trim($value);
                        $stripped_string = strip_tags($trimed_string);
                        $htmlspecialchars_string = htmlspecialchars($stripped_string);
                        $replaced_string = str_replace("'", "\'", $htmlspecialchars_string);
                        return $replaced_string;
                    }
                    return "null";
                }

                if ($_POST) {
                    $name = getDatabaseCompatibleValue('name');
                    $date_of_birth = getDatabaseCompatibleValue('date_of_birth');
                    $image = getDatabaseCompatibleValue('image');
                    $size = getDatabaseCompatibleValue('size');
                    $type = getDatabaseCompatibleValue("type");
                    $location = getDatabaseCompatibleValue('location');
                    $gender = getDatabaseCompatibleValue('gender');
                    $description = getDatabaseCompatibleValue('description');
                    $hobbies = getDatabaseCompatibleValue('hobbies');
                    $id = $_POST['id'];
                }

                if (isset($_FILES["image"]) && $_FILES["image"]["error"] != UPLOAD_ERR_NO_FILE) {
                    $basename = basename($_FILES["image"]["name"]);
                    $uploaded_file_path = "../upload/" . $basename;
                    move_uploaded_file($_FILES["image"]["tmp_name"], $uploaded_file_path);
                    $sql = "UPDATE cr11_vedrana_petadoption.animals 
                SET 
                    name = '$name',
                    date_of_birth = '$date_of_birth',
                    size = '$size',
                    type = '$type',
                    location = '$location',
                    gender ='$gender',
                    description = '$description',
                    hobbies = '$hobbies',
                    image = '$basename',
                WHERE
                    id = $id";
                } else {
                    $sql = "UPDATE cr11_vedrana_petadoption.animals 
                SET 
                    name = '$name',
                    date_of_birth = '$date_of_birth',
                    size = '$size',
                    type = '$type',
                    location = '$location',
                    gender ='$gender',
                    description = '$description',
                    hobbies = '$hobbies' 
                WHERE
                    id = $id";
                }

                if (mysqli_query($conn, $sql)) {
                    echo "<div class=\"col-md-8\">
                <h3 class='text-success'>Entry successfully updated!</h3>
                <p>You are being redirected to the edit content page</p></div>";
                    header("Refresh:2; url=../edit_index.php");
                } else {
                    echo "<div class=\"col-md-8\"><h3 class='text-danger'>There has been an error, please try again later!</h3>
               <p>go back to <a href='../index.php'>homepage</a></p></div>";
                }
                $conn->close();

                ?>

        </div>


    </div>

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
