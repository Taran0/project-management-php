<?php
//calculated variables
$project_time = $row['project_deadline'] - $row['project_start'];
$planned_progress = 1 - ($project_deadline - time()) / $project_time;
$real_progress;
