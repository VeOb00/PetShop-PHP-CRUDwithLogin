<?php
ob_start();
session_start(); // start a new session or continues the previous
if (isset($_SESSION['user']) != "") {
    header("Location: index.php"); // redirects to home.php
}
include_once 'php_actions/db_connect.php';
$error = false;
if (isset($_POST['btn-signup'])) {

    // sanitize user input to prevent sql injection
    $name = trim($_POST['name']);

    //trim - strips whitespace (or other characters) from the beginning and end of a string
    $name = strip_tags($name);

    // strip_tags — strips HTML and PHP tags from a string
    $name = htmlspecialchars($name);
    // htmlspecialchars converts special characters to HTML entities
    $email = trim($_POST['email']);
    $email = strip_tags($email);
    $email = htmlspecialchars($email);

    $pass = trim($_POST['pass']);
    $pass = strip_tags($pass);
    $pass = htmlspecialchars($pass);

    $confirmPass = trim($_POST['confirmPass']);
    $confirmPass = strip_tags($confirmPass);
    $confirmPass = htmlspecialchars($confirmPass);

    // basic name validation
    if (empty($name)) {
        $error = true;
        $nameError = "Please enter your full name.";
    } else if (strlen($name) < 3) {
        $error = true;
        $nameError = "Name must have at least 3 characters.";
    } else if (!preg_match("/^[a-zA-Z ]+$/", $name)) {
        $error = true;
        $nameError = "Name must contain alphabets and space.";
    }

    //basic email validation
    if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $error = true;
        $emailError = "Please enter valid email address.";
    } else {
        // checks whether the email exists or not
        $query = "SELECT userEmail FROM cr11_vedrana_petadoption.users WHERE userEmail='$email'";
        $result = mysqli_query($conn, $query);
        $count = mysqli_num_rows($result);
        if ($count != 0) {
            $error = true;
            $emailError = "Provided Email is already in use.";
        }
    }
    // password validation
    if (empty($pass)) {
        $error = true;
        $passError = "Please enter password.";
    } else if (strlen($pass) < 6) {
        $error = true;
        $passError = "Password must have at least 6 characters long.";
    } else if ($pass != $confirmPass) {
        $error = true;
        $confirmPassError = "Passwords don't match. Please try again.";
    }

    // password hashing for security
    $password = hash('sha256', $pass);

    // if there's no error, continue to signup
    if (!$error) {

        $query = "INSERT INTO cr11_vedrana_petadoption.users(userName,userEmail,userPass) VALUES('$name','$email','$password')";
        $res = mysqli_query($conn, $query);

        if ($res) {
            $errTyp = "success";
            $errMSG = "Successfully registered, you may <a href=\"login.php\">login </a>now";
            unset($name);
            unset($email);
            unset($pass);
        } else {
            $errTyp = "danger";
            $errMSG = "Something went wrong, try again later...";
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
        <script
                src="https://code.jquery.com/jquery-3.4.0.min.js"
                integrity="sha256-BJeo0qm959uMBGb65z40ejJYGSgR7REI4+CW1fNKwOg="
                crossorigin="anonymous"></script>
        <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>
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
            <h2 class="text-center">Sign Up</h2>
            <p class="text-center h5">or <b><a href="login.php">sign in here </a></b>if you already have a account.</p>
            <hr/>
            <?php
            if (isset($errMSG)) {
                ?>
                <div class="alert text-<?php echo $errTyp ?> text-center">
                    <?php echo $errMSG; ?>
                </div>
            <?php } ?>
            <div class="form-group">
                <label for="name">Name: </label>
                <input id="name" type="text" name="name" class="form-control" placeholder="Enter Name" maxlength="50"
                       value="<?php echo $name ?>">
                <span class="text-danger"> <?php echo $nameError; ?> </span>
            </div>
            <div class="form-group">
                <label for="uniqueEmailCheck">e-mail: </label>
                <input id="uniqueEmailCheck" type="email" name="email" class="form-control"
                       placeholder="Enter Your Email"
                       maxlength="40"
                       value="<?php echo $email ?>"/>
                <span class="text-danger"> <?php echo $emailError; ?> </span>
                <span class="text-danger" id="resultEmailCheck"> </span>
            </div>
            <div class="form-group">
                <label for="pass">Password: </label>
                <input id="pass" type="password" name="pass" class="form-control" placeholder="Enter Password"
                       maxlength="15"/>
                <span class="text-danger"> <?php echo $passError; ?> </span>
            </div>
            <div class="form-group">
                <label for="confirmPass">Confirm Password: </label>
                <input id="confirmPass" type="password" name="confirmPass" class="form-control"
                       placeholder="Confirm Password"
                       maxlength="15"/>
                <span class="text-danger"> <?php echo $confirmPassError; ?> </span>
                <div id="resultConfirmPass"></div>
                <span class="text-success"></span>
            </div>
            <div class="form-group mb-5">
                <button type="submit" class="btn btn-block btn-primary" name="btn-signup">Sign Up</button>
            </div>
        </form>

        <script>
            $("#uniqueEmailCheck").blur(function (event) {
                let request;
                event.preventDefault();
                if (request) {
                    request.abort();
                }
                var $form = $(this);
                var $inputs = $form.find("input, select, button, textarea");
                var serializedData = $form.serialize();
                var uniqueEmailCheck = document.getElementById("uniqueEmailCheck").value;
                if (uniqueEmailCheck.length > 0) {
                    $inputs.prop("disabled", true);
                    request = $.ajax({
                        url: "php_actions/uniqueEmailCheck.php",
                        type: "post",
                        data: serializedData
                    });
                    request.done(function (response) {
                        document.getElementById("resultEmailCheck").innerHTML = response;
                    });
                    request.fail(function (jqXHR, textStatus, errorThrown) {
                        console.error(
                            "The following error occurred: " + textStatus, errorThrown
                        );
                    });
                } else {
                    document.getElementById("resultEmailCheck").innerHTML = " ";
                }
            });

            $("#confirmPass").keyup(function (event) {
                let request;
                event.preventDefault();
                if (request) {
                    request.abort();
                }
                var password = document.getElementById("pass").value;
                var confirmPass = document.getElementById("confirmPass").value;

                if (confirmPass !== password) {
                    document.getElementById("resultConfirmPass").innerHTML = "<span class='text-danger'>&#x2717; Password does not match</span>";
                } else {
                    document.getElementById("resultConfirmPass").innerHTML = "<span class='text-success'>&#10003; Matching password</span>";
                }
            });
        </script>
    </body>
    </html>
<?php ob_end_flush(); ?>