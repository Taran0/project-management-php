<?php
require_once "include/db.php";

if(isset($_GET['operate'])){
    if($_GET['operate'] == 'delete'){
        $connection;
    
        $sql = "DELETE FROM projects WHERE id={$_GET['id']}";
    
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
    <title>Projects</title>
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
    <div class="container">
        <div class="row">
            <h2 class="h3 col d-inline pt-4">Projects</h2>
            <a class="col text-info text-right align-text-bottom pt-4" href="" data-target="#newProjectModal" data-toggle="modal">
                <i class="fas fa-plus-square fa-3x"></i>
            </a>
        </div>
<?php
    if(isset($notification)){
        echo $notification;
    }
    if (isset($_POST['submit'])) {
        if (!empty($_POST['projectName']) && !empty($_POST['projectStatus']) && !empty($_POST['projectStartTime']) && 
        !empty($_POST['projectDeadline'])) {
            $projectName = $_POST['projectName'];
            $projectStatus = $_POST['projectStatus'];
            $projectStartTime = $_POST['projectStartTime'];
            $projectDeadline = $_POST['projectDeadline'];
            $plannedWorkingTimeHours = $_POST['plannedWorkingTimeHours'];
            $plannedWorkingTimeMinutes = $_POST['plannedWorkingTimeMinutes'];
            $projectNote = $_POST['projectNote'];
            
            //planned working time calculation
            $plannedWorkingTime = intval($plannedWorkingTimeHours) * 3600 + intval($plannedWorkingTimeMinutes) * 60;

            $connection;
            
            $sql = "INSERT INTO projects(project_name, project_starttime, project_deadline, 
            project_expectedtime, project_status, project_note)
            VALUES(:pname, :pstart, :pdeadl, :pexptime, :pstatus, :pnote)";
    
            //connectingDB objekt, metódusa a prepare
            $stmt = $connection->prepare($sql);
            
            //pdo-s value párosítása a változókkal
            $stmt->bindValue(':pname', $projectName);
            $stmt->bindValue(':pstart', $projectStartTime);
            $stmt->bindValue(':pdeadl', $projectDeadline);
            $stmt->bindValue(':pexptime', $plannedWorkingTime);
            $stmt->bindValue(':pstatus', $projectStatus);
            $stmt->bindValue(':pnote', $projectNote);   
            
            $execute = $stmt->execute();

            if($execute){
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
                    <th>Project name</th>
                    <th>Deadline</th>
                    <th>Do</th>
                    <th>Delete</th>
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
                                <td><a href="index.php?id=<?php echo $id; ?>&operate=delete" class="btn btn-outline-info btn-block btn-sm">Delete</a></td>
                            </tr>
                        <?php
$i++;
}
?>

            </tbody>
        </table>



    </div>

    <!-- new project modal -->
    <div class="modal" id="newProjectModal">
        <div class="modal-dialog">
            <div class="modal-content">                
                    <div class="modal-header bg-info">
                      <h5 class="modal-title">Add new project</h5>
                      <button class="close" data-dismiss="modal">&times;</button>
                    </div>
                    <div class="modal-body">
                        <form action="index.php" method="post">
                            <div class="row">
                                <div class="col-md-7">
                                    <div class="input-group">
                                        <div class="input-group-prepend">
                                            <span class="input-group-text">Project name</span>
                                        </div>
                                        <input name="projectName" type="text" class="form-control" required>
                                    </div>
                                </div>
                                <div class="col-md-5">
                                    <div class="input-group">
                                        <div class="input-group-prepend">
                                            <span class="input-group-text">Status</span>
                                        </div>
                                        <select name="projectStatus" class="form-control">
                                            <option value="active">Active</option>
                                            <option value="planned">Planned</option>
                                            <option value="archived">Archived</option>
                                        </select>
                                    </div>
                                </div>
                            </div>
                            <div class="row pt-3">
                                <div class="col">
                                    <div class="input-group">
                                        <div class="input-group-prepend">
                                            <span class="input-group-text">Project start</span>
                                        </div>
                                        <input name="projectStartTime" type="date" class="form-control" required>
                                    </div>
                                </div>
                            </div>
                            <div class="row py-3">
                                <div class="col">
                                    <div class="input-group">
                                        <div class="input-group-prepend">
                                            <span class="input-group-text">Deadline</span>
                                        </div>
                                        <input name="projectDeadline" type="date" class="form-control" required>
                                    </div>
                                </div>
                            </div>

                            <div class="row">
                                <div class="col-md-12 pb-3">
                                    <div class="input-group">
                                        <div class="input-group-prepend">
                                            <span class="input-group-text">Planned working time</span>
                                        </div>
                                        <input name="plannedWorkingTimeHours" class="form-control" type="number" placeholder="Hours">
                                        <input name="plannedWorkingTimeMinutes" class="form-control" type="number" min="0" max="59" placeholder="Mins">
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-12">
                                    <div class="form-group">
                                        <textarea name="projectNote" class="form-control" placeholder="Project note"></textarea>
                                    </div>
                                </div>
                            </div>
                            <input type="submit" name="submit" value="Create new project" class="btn btn-outline-danger btn-block">
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