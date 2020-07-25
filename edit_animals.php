<?php
ob_start();
session_start();
require_once 'php_actions/db_connect.php';

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
    <link rel="stylesheet" href="style/main.css">
    <link rel="stylesheet" href="style/admin.css">
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
            <li class="nav-item active">
                <a class="nav-link" href="admin.php">Admin panel<span class="sr-only">(current)</span></a>
            </li>
            <li class="nav-item">
                <a class="nav-link" href="index.php">Page preview</a>
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

<div class="row col-12">
    <nav class="sidebar-menu col-md-2 navbar-dark bg-dark pt-4">
        <ul class="navbar-nav">
            <li class="nav-item">
                <a class="nav-item nav-link" href="admin.php">Admin panel</a>
            </li>
            <li class="nav-item">
                <a class="nav-item nav-link active" href="edit_index.php">Edit content</a>
            </li>
            <li class="nav-item">
                <a class="nav-item nav-link" href="add_animals.php">Add content</a>
            </li>
            <?php if ($loggedSuperadmin) : ?>
                <li class="nav-item">
                    <a class="nav-item nav-link" href="edit_users.php">Edit users</a>
                </li>
            <?php endif; ?>
        </ul>
    </nav>

    <div class="col-md-10 pt-4 mx-auto">
        <div class="col-md-8 ml-3">
            <h1>Edit existing content</h1>
            <br>
            <p>Here you can edit the existing entries in the database.</p>
        </div>
        <div class="row ml-3 mt-5">
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
                $age = $row["age"];
                ?>

                <div class="col-md-5">
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
                        <dd><?= $age . " years old, <small class='text-secondary'><address>" . $date_of_birth . "</address></small>" ?></dd>
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
        </div>
        <div class="ml-3 mt-5">
            <hr>
            <h1>Edit form</h1>
        </div>

        <div class="row ml-3 mt-5">
            <form action="php_actions/a_update.php" class="col-md-8" method="post" enctype="multipart/form-data">
                <input type="hidden" name="id" value="<?= $id ?>">
                <div class="form-row">
                    <div class="col-md-6 mb-3">
                        <label for="name">Name:</label>
                        <input type="text" class="form-control" id="name" name="name" value="<?= $name ?>" required>
                    </div>
                    <div class="col-md-6 mb-3">
                        <label for="type">Animal type:</label>
                        <input type="text" class="form-control" id="type" name="type" value="<?= $type ?>">

                    </div>
                </div>
                <div class="form-row">
                    <div class="col-md-6 mb-3">
                        <label for="date_of_birth">Date of birth:</label>
                        <input type="date" class="form-control" id="date_of_birth" name="date_of_birth"
                               value="<?= $date_of_birth ?>" required>
                    </div>
                    <div class="col-md-6 mb-3">
                        <label for="gender">Gender:</label>
                        <select class="custom-select" id="gender" name="gender" required>
                            <option selected disabled>Choose...</option>
                            <option <?php if ($gender == "female") : ?> selected <?php endif; ?> >female</option>
                            <option <?php if ($gender == "male") : ?> selected <?php endif; ?> >male</option>
                        </select>
                    </div>
                </div>
                <div class="form-row">
                    <div class="col-md-6 mb-3">
                        <label for="location">Location:</label>
                        <input type="text" class="form-control" id="location" name="location" value="<?= $location ?>">
                    </div>
                    <div class="col-md-6 mb-3">
                        <label for="size">Animal size:</label>
                        <select class="custom-select" id="size" name="size" required>
                            <option selected disabled>Choose...</option>
                            <option <?php if ($size == "small") : ?> selected <?php endif; ?> >small</option>
                            <option <?php if ($size == "large") : ?> selected <?php endif; ?> >large</option>
                        </select>
                    </div>
                </div>
                <div class="form-row">
                    <div class="col-md-12 mb-3">
                        <label for="hobbies">Hobbies:</label>
                        <input type="text" class="form-control" id="hobbies" name="hobbies" value="<?= $hobbies ?>">
                        <small class="form-text text-muted">Optional</small>
                    </div>
                </div>

                <div class="form-row">
                    <div class="col-md-12 mb-3">
                        <label for="description">Short description</label>

                        <textarea class="form-control" id="description" rows="6"
                                  name="description"><?php echo htmlspecialchars($description); ?></textarea>
                        <small class="form-text text-muted">Optional</small>
                    </div>
                </div>
                <div class="form-row mt-3">
                    <div class="col-md-6 mb-3">
                        <label for="image">Upload image:</label>
                        <input type="file" id="image" name="image">
                        <small class="form-text text-muted">Optional</small>
                    </div>
                </div>

                <input class="btn btn-success my-5" type="submit" value="Update">
            </form>

            <form action="delete-confirm.php" class="col-md-4 text-right mb-5" method="post">
                <input type="hidden" name="id" value="<?= $id ?>">
                <input class="btn btn-danger" type="submit" value="Delete this entry">
            </form>
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
