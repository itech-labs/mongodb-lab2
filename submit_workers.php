<?php
require_once __DIR__ . "/vendor/autoload.php";
include("connect.php");

$pr_manager = $_GET["manager"];

$query = [];
$query["manager"] = $pr_manager;

$workers = $collection_tasks->distinct("workers", $query, ["_id" => 0]);
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
    <h2>Employees under the leadership of an <?php echo($pr_manager)?></h2>

    <?php
    if (($workers) == 0) {
        echo("<p>No employees under the leadership of an $pr_manager.</p>");
    } else {
    ?>
        <table>
            <thead>
                <th>Employees name</th>
            </thead>
            <tbody>
                <?php
                foreach ($workers as $worker) {
                    printf("<tr><td>%s</td></tr>", $worker);
                }
                ?>
            </tbody>
        </table>
    <?php
    }
    ?>
</body>
</html>