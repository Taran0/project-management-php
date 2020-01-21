<?php
require_once "include/db.php";

if (isset($_GET['taskid']) && isset($_GET['taskname'])) {
    $task_id = $_GET['taskid'];
    $task_name = $_GET['taskname'];

    setcookie("taskId", $task_id, time() + 3600);
    setcookie("tasktName", $task_name, time() + 3600);

} else {
    $project_id = $_COOKIE['taskId'];
    $project_name = $_COOKIE['taskName'];
}

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
    <script type="text/javascript" src="js/script.js"></script>
    <title>In progress: <?php echo $task_name; ?></title>
</head>
<body>
    <!-- navbar -->
    <nav id="main-nav" class="navbar navbar-expand-sm navbar-dark bg-dark py-4">
        <div class="container">
            <a href="index.php" class="navbar-brand">
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
    <div class="container py-4 col-6">
    <div class="card text-center">
            <div class="card-header bg-danger text-white">
                <div>In progress: </div>
                <div class="h2"><?php echo $task_name; ?></div>
                
            </div>
            <div class="card-body">
                <div class="display-4" id="display">
                    00:00:00
                </div>
                <div class="buttons">
                    <button id="startStop" onclick="startStop()">Start</button>
                    <button id="reset" onclick="reset()">Reset</button>
                </div>
            </div>
            <div class="card-footer text-muted">
                fragments...
            </div>
        </div>

        
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