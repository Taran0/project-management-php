<?php
require_once "include/db.php";

if (isset($_GET['id']) && isset($_GET['projectname'])) {
    $project_id = $_GET['id'];
    $project_name = $_GET['projectname'];

    setcookie("projectId", $project_id, time() + 3600);
    setcookie("projectName", $project_name, time() + 3600);

} else {
    $project_id = $_COOKIE['projectId'];
    $project_name = $_COOKIE['projectName'];
}

if(isset($_GET['operate'])){
    if($_GET['operate'] == 'delete'){
        $connection;
    
        $sql = "DELETE FROM tasks WHERE id={$_GET['id']}";
    
        $execute = $connection->query($sql);

        if($execute){
            $notification = "<span>Record has been deleted successfully</span>";
        }

    }
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
    <title>Tasks</title>
</head>
<body>
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
                        <a href="php.html" class="dropdown-item">PHP</a>
                    </div>
                </li>
                <li class="nav-item"><a href="#" class="nav-link">Planned</a></li>
                <li class="nav-item"><a href="#" class="nav-link">Archived</a></li>
            </ul>
        </div>
    </nav>
    <div class="container">
        <br>
        <div class="row">
            <span class="col">Tasks of</span>
        </div>
        <div class="row">
            <h2 class="h3 col d-inline"><?php echo $project_name; ?></h2>
            <!-- <h1 class="display-4 col d-inline"><?php echo $project_name; ?></h1> -->
            <a class="col text-info text-right" href="" data-target="#newTaskModal" data-toggle="modal">
                <i class="fas fa-plus-square fa-3x"></i>
            </a>

        </div>
    <?php
if(isset($notification)){
    echo $notification;
}
if (isset($_POST['submit'])) {
    if (!empty($_POST['taskName']) && !empty($_POST['taskStatus'])) {
        $taskName = $_POST['taskName'];
        $taskStatus = $_POST['taskStatus'];
        $plannedWorkingTimeHours = $_POST['plannedWorkingTimeHours'];
        $plannedWorkingTimeMinutes = $_POST['plannedWorkingTimeMinutes'];
        $taskNote = $_POST['taskNote'];

        //planned working time calculation
        $plannedWorkingTime = intval($plannedWorkingTimeHours) * 3600 + intval($plannedWorkingTimeMinutes) * 60;

        $connection;

        $sql = "INSERT INTO tasks(task_name, task_status, task_expectedtime,
            task_note, project_id)
            VALUES(:tname, :tstat, :texptime, :tnote, :prid)";

        //connectingDB objekt, metódusa a prepare
        $stmt = $connection->prepare($sql);

        //pdo-s value párosítása a változókkal
        $stmt->bindValue(':tname', $taskName);
        $stmt->bindValue(':tstat', $taskStatus);
        $stmt->bindValue(':texptime', $plannedWorkingTime);
        $stmt->bindValue(':tnote', $taskNote);
        $stmt->bindValue(':prid', $project_id);

        $execute = $stmt->execute();

        if ($execute) {
            echo "<span>Record has been added successfully</span>";
        }

    } else {
        echo "<span>please add the data</span>";
    }
}
?>

        <table class="table table-hover table-striped table-sm">
            <thead class="thead-dark">
                <tr>
                    <th>No.</th>
                    <th>Task name</th>
                    <th>Task status</th>
                    <th>Do</th>
                    <th>Delete</th>
                </tr>
            </thead>
            <tbody>
                <?php
$connection->setAttribute(PDO::ATTR_DEFAULT_FETCH_MODE, PDO::FETCH_ASSOC);
$sql = "SELECT * FROM tasks WHERE project_id={$project_id}";
$stmt = $connection->query($sql);
$i = 1;

while ($row = $stmt->fetch()) {

    $id = $row['id'];
    $name = $row['task_name'];
    $status = $row['task_status'];
    ?>
                            <tr>
                                <th class="align-middle" scope="row"><?php echo $i; ?></th>
                                <td class="align-middle"><?php echo $name; ?></td>
                                <td class="align-middle"><?php echo $status; ?></td>
                                <td><a href="do.php?taskid=<?php echo $id; ?>&taskname=<?php echo $name; ?>" class="btn btn-outline-danger btn-block btn-sm">Do</a></td>
                                <td><a href="tasks.php?id=<?php echo $id; ?>&operate=delete" class="btn btn-outline-primary btn-block btn-sm">Delete</a></td>
                            </tr>
                        <?php
$i++;
}
?>

            </tbody>
        </table>

<!-- new project modal -->
<div class="modal" id="newTaskModal">
        <div class="modal-dialog">
            <div class="modal-content">
                    <div class="modal-header bg-info">
                      <h5 class="modal-title">Add new task to <?php echo $project_name; ?></h5>
                      <button class="close" data-dismiss="modal">&times;</button>
                    </div>
                    <div class="modal-body">
                        <form action="tasks.php" method="post">
                            <div class="row">
                                <div class="col-md-7">
                                    <div class="input-group">
                                        <div class="input-group-prepend">
                                            <span class="input-group-text">Task name</span>
                                        </div>
                                        <input name="taskName" type="text" class="form-control" required>
                                    </div>
                                </div>
                                <div class="col-md-5">
                                    <div class="input-group">
                                        <div class="input-group-prepend">
                                            <span class="input-group-text">Status</span>
                                        </div>
                                        <select name="taskStatus" class="form-control">
                                            <option value="inprogress">InProgress</option>
                                            <option value="done">Done</option>
                                        </select>
                                    </div>
                                </div>
                            </div>


                            <div class="row pt-3">
                                <div class="col-md-12 pb-3">
                                    <div class="input-group">
                                        <div class="input-group-prepend">
                                            <span class="input-group-text">Planned working time</span>
                                        </div>
                                        <input name="plannedWorkingTimeHours" class="form-control" type="number" placeholder="Hours" required>
                                        <input name="plannedWorkingTimeMinutes" class="form-control" type="number" min="0" max="59" placeholder="Mins" required>
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-12">
                                    <div class="form-group">
                                        <textarea name="taskNote" class="form-control" placeholder="Task note"></textarea>
                                    </div>
                                </div>
                            </div>
                            <input type="submit" name="submit" value="Create new task" class="btn btn-outline-danger btn-block">
                        </form>
                    </div>
                    <div class="modal-footer">
                        <div class="form-group">
                            <button class="btn btn-secondary" data-dismiss="modal">Close</button>
                        </div>
                    </div>
            </div>
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