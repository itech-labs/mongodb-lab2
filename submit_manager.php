<?php
require_once __DIR__ . "/vendor/autoload.php";
include("connect.php");

$pr_manager = $_GET["pr_manager"];

$query = [];
$query["manager"] = $pr_manager;

$count = $collection_projects->count($query);

$cursor = $collection_projects->find($query, ["_id" => 0]);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?php echo($pr_manager)?></title>
    <link rel="stylesheet" href="./css/response.css">
</head>
<body>
    <h2>The number of projects of the <?php echo($pr_manager)?></h2>
    <h1><?php echo($count)?></h1>

    <?php
    if ($cursor->isDead()) {
        echo("<p>No projects of the $pr_manager.</p>");
    } else {
    ?>
        <table>
            <thead>
                <th>Project name</th>
                <th>Manager name</th>
            </thead>
            <tbody>
                <?php
                foreach ($cursor as $project) {
                    printf("<tr><td>%s</td>", $project["name"]);
                    printf("<td>%s</td></tr>", $project["manager"]);
                }
                ?>
            </tbody>
        </table>
    <?php
    }
    ?>
</body>
</html>