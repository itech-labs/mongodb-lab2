<?php
require_once __DIR__ . "/vendor/autoload.php";
include("connect.php");

$project_name = $_GET["project"];
$date = $_GET["date"];
$dateUnix = strtotime($_GET["date"]);

$query = [];
$query["project"] = $project_name;
$query["end_time"] = ['$lte' => $dateUnix];

$cursor = $collection_tasks->find($query, ["_id" => 0]);

$projects = [];
foreach ($cursor as $project) {
    $projects[] = $project;
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?php echo($project_name)?></title>
    <link rel="stylesheet" href="./css/response.css">
</head>
<body>
    <h2>Completed tasks for the <?php echo($project_name)?> on the <?php echo($date)?></h2>

    <?php
    if (($projects) == 0) {
        echo("<p>No completed tasks for the $project_name.</p>");
    } else {
    ?>
        <table>
            <thead>
                <th>Project name</th>
                <th>Title</th>
                <th>Description</th>
                <th>Workers</th>
                <th>Manager</th>
                <th>Responsible</th>
                <th>Start time</th>
                <th>End time</th>
            </thead>
            <tbody>
                <?php
                foreach ($projects as $project) {
                    printf("<tr><td>%s</td>", $project["project"]);
                    printf("<td>%s</td>", $project["title"]);
                    printf("<td>%s</td>", $project["description"]);
                    printf("<td>%s</td>", implode(", ", iterator_to_array($project["workers"])));
                    printf("<td>%s</td>", $project["manager"]);
                    printf("<td>%s</td>", $project["responsible"]);
                    printf("<td>%s</td>", date('Y-m-d H:i:s', $project["start_time"]));
                    printf("<td>%s</td></tr>", date('Y-m-d H:i:s', $project["end_time"]));
                }
                ?>
            </tbody>
        </table>
    <?php
    }
    ?>
</body>
</html>