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
            $errMSG = "Successfully registered, you may login now";
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
    <!DOCTYPE html>
    <html lang="en">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport"
              content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
        <meta http-equiv="X-UA-Compatible" content="ie=edge">
        <title>Login & Registration System</title>
        <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.0/css/bootstrap.min.css"
              integrity="sha384-9aIt2nRpC12Uk9gS9baDl411NQApFmC26EwAOH8WgZl5MYYxFfc+NcPb1dKGj7Sk"
              crossorigin="anonymous">
        <script
            src="https://code.jquery.com/jquery-3.4.0.min.js"
            integrity="sha256-BJeo0qm959uMBGb65z40ejJYGSgR7REI4+CW1fNKwOg="
            crossorigin="anonymous"></script>
        <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>
    </head>
    <body>
    <form method="post" action="<?php echo htmlspecialchars($_SERVER['PHP_SELF']); ?>" autocomplete="off">
        <h2>Sign Up.</h2>
        <hr/>

        <?php
        if (isset($errMSG)) {
            ?>
            <div class="alert alert-<?php echo $errTyp ?>">
                <?php echo $errMSG; ?>
            </div>
        <?php } ?>
        <label for="name">Name: </label>
        <input id="name" type="text" name="name" class="form-control" placeholder="Enter Name" maxlength="50"
               value="<?php echo $name ?>">
        <span class="text-danger"> <?php echo $nameError; ?> </span>
        <label for="uniqueEmailCheck">e-mail: </label>
        <input id="uniqueEmailCheck" type="email" name="email" class="form-control" placeholder="Enter Your Email"
               maxlength="40"
               value="<?php echo $email ?>"/>
        <span class="text-danger"> <?php echo $emailError; ?> </span>
        <span class="text-danger" id="resultEmailCheck"> </span>
        <label for="pass">Password: </label>
        <input id="pass" type="password" name="pass" class="form-control" placeholder="Enter Password" maxlength="15"/>
        <span class="text-danger"> <?php echo $passError; ?> </span>
        <label for="confirmPass">Confirm Password: </label>
        <input id="confirmPass" type="password" name="confirmPass" class="form-control" placeholder="Confirm Password"
               maxlength="15"/>
        <span class="text-danger"> <?php echo $confirmPassError; ?> </span>
        <div id="resultConfirmPass"></div>
        <span class="text-success"></span>

        <hr/>
        <button type="submit" class="btn btn-block btn-primary" name="btn-signup">Sign Up</button>
        <hr/>
        <a href="login.php">Sign in Here...</a>
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