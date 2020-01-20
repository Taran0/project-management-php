<?php
require_once "include/db.php";

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <script src="https://kit.fontawesome.com/214f271038.js"></script>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css"
        integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">
    <link rel="stylesheet" href="css/style.css">
    <title>Projects</title>
</head>
<body>
    <nav id="main-nav" class="navbar navbar-expand-sm navbar-dark bg-dark py-4">
        <div class="container">
            <a href="index.html" class="navbar-brand">
                <img src="img/logo.png" alt="">
                <p class="d-inline mb-2">ProjectMaster</p>
            </a>
            <ul class="navbar-nav ml-auto">
                <li class="nav-item active"><a href="index.php" class="nav-link">Home</a></li>
                <li class="nav-item dropdown">
                    <a href="#" class="nav-link dropdown-toggle" data-toggle="dropdown">Active</a>
                    <div class="dropdown-menu">
                        <a href="" class="dropdown-item">PHP</a>
                    </div>
                </li>
                <li class="nav-item"><a href="#" class="nav-link">Planned</a></li>
                <li class="nav-item"><a href="#" class="nav-link">Archived</a></li>
            </ul>
        </div>
    </nav>
    <div class="container">
    <div class="row">
        <h1 class="display-4 col d-inline">Projects</h1>
        <a class="text-secondary col text-right align-text-bottom pt-4" href="#">
            <i class="fas fa-plus-square fa-3x"></i>
        </a>

    </div>


        <table class="table table-hover table-striped table-sm">
            <thead class="thead-dark">
                <tr>
                    <th>No.</th>
                    <th>Project name</th>
                    <th>Deadline</th>
                    <th>Do</th>
                    <th>Szerkeszt</th>
                </tr>
            </thead>
            <tbody>
                <?php
$connection->setAttribute(PDO::ATTR_DEFAULT_FETCH_MODE, PDO::FETCH_ASSOC);
$sql = "SELECT * FROM projects";
$stmt = $connection->query($sql);
$i = 1;

while ($row = $stmt->fetch()) {
    $id = $row['id'];
    $name = $row['project_name'];
    $deadline = $row['project_deadline'];

    ?>
                            <tr>
                                <th class="align-middle" scope="row"><?php echo $i; ?></th>
                                <td class="align-middle"><?php echo $name; ?></td>
                                <td class="align-middle"><?php echo $deadline; ?></td>
                                <td><a href="tasks.php?id=<?php echo $id; ?>&projectname=<?php echo $name; ?>" class="btn btn-outline-danger btn-block btn-sm">Do</a></td>
                                <td><a href="" class="btn btn-outline-primary btn-block btn-sm">Edit</a></td>
                            </tr>
                        <?php
$i++;
}
?>

            </tbody>
        </table>



    </div>

    <script src="https://code.jquery.com/jquery-3.4.1.min.js"
        integrity="sha256-CSXorXvZcTkaix6Yvo6HppcZGetbYMGWSFlBw8HfCJo=" crossorigin="anonymous"></script>
    <script src="https://code.jquery.com/jquery-3.3.1.slim.min.js"
        integrity="sha384-q8i/X+965DzO0rT7abK41JStQIAqVgRVzpbzo5smXKp4YfRvH+8abtTE1Pi6jizo" crossorigin="anonymous">
    </script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.7/umd/popper.min.js"
        integrity="sha384-UO2eT0CpHqdSJQ6hJty5KVphtPhzWj9WO1clHTMGa3JDZwrnQq4sF86dIHNDz0W1" crossorigin="anonymous">
    </script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js"
        integrity="sha384-JjSmVgyd0p3pXB1rRibZUAYoIIy6OrQ6VrjIEaFf/nJGzIxFDsf4x0xIM+B07jRM" crossorigin="anonymous">
    </script>
    <script>
        //get the current year for the copyright
        $('#year').text(new Date().getFullYear());
    </script>
</body>
</html>