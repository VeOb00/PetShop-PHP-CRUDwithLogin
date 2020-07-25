<?php
require_once 'db_connect.php';

$search = $_POST["search"];
// $search = isset($_POST["search"]) ? $_POST["search"] : "null"

$sql = "SELECT *, TIMESTAMPDIFF(YEAR, date_of_birth, CURDATE()) AS age FROM cr11_vedrana_petadoption.animals WHERE name LIKE '%$search%' or type like '%$search%' or location like '%$search%' or size like '%$search%'";

$resultAnimals = mysqli_query($conn, $sql);
?>
<div class="container">
    <div class="row">
        <?php
        if ($resultAnimals->num_rows == 0) {
            echo "Sorry, there is nothing in the database";
        } else if ($resultAnimals->num_rows == 1) {
            $row = $resultAnimals->fetch_assoc();
            {
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
                <div class="col-md-6 col-xl-4 box card-group">
                    <div class="mb-3 card shadow-sm ">
                        <img src="<?= "upload/" . $image ?>" class="card-img-top"
                             alt="<?= $name ?> image">
                        <div class="card-body">
                            <h3 class="card-title">
                                <?= $name; ?>
                                <?php if ($gender == "female") : ?>
                                    <img src="media/female.png" class="logo" alt="female">
                                <?php endif; ?>
                                <?php if ($gender == "male") : ?>
                                    <img src="media/male.png" class="logo" alt="male">
                                <?php endif; ?>
                            </h3>
                            <hr>
                            <p>Location: <?= $location ?></p>
                            <p>Hobbies: <?= $hobbies ?></p>
                        </div>
                        <div class="card-footer d-flex justify-content-between align-items-center">
                            <p class="mb-0">Age: <span class="font-weight-bolder"><?= $age ?></span> years</p>
                            <a href="animal_info.php?id=<?= $id ?>">
                                <button class="btn btn-light btn-outline-secondary btn-sm">More info</button>
                            </a>
                        </div>
                    </div>
                </div>
                <?php
            }
        } else {
            $rows = $resultAnimals->fetch_all(MYSQLI_ASSOC);
            foreach ($rows as $value) {
                $id = $value["id"];
                $name = $value["name"];
                $date_of_birth = $value["date_of_birth"];
                $image = $value["image"];
                $size = $value["size"];
                $type = $value["type"];
                $location = $value["location"];
                $gender = $value["gender"];
                $description = $value["description"];
                $hobbies = $value["hobbies"];
                $age = $value["age"];
                ?>

                <div class="col-md-6 col-xl-4 box card-group">
                    <div class="mb-3 card shadow-sm ">
                        <img src="<?= "upload/" . $image ?>" class="card-img-top"
                             alt="<?= $name ?> image">
                        <div class="card-body">
                            <h3 class="card-title">
                                <?= $name; ?>
                                <?php if ($gender == "female") : ?>
                                    <img src="media/female.png" class="logo" alt="female">
                                <?php endif; ?>
                                <?php if ($gender == "male") : ?>
                                    <img src="media/male.png" class="logo" alt="male">
                                <?php endif; ?>
                            </h3>
                            <hr>
                            <p>Location: <?= $location ?></p>
                            <p>Hobbies: <?= $hobbies ?></p>
                        </div>
                        <div class="card-footer d-flex justify-content-between align-items-center">
                            <p class="mb-0">Age: <span class="font-weight-bolder"><?= $age ?></span> years</p>
                            <a href="animal_info.php?id=<?= $id ?>">
                                <button class="btn btn-light btn-outline-secondary btn-sm">More info</button>
                            </a>
                        </div>
                    </div>
                </div>

                <?php
            }
        }

        ?>
    </div>
</div>
