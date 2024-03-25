<?php
require_once __DIR__ . "/vendor/autoload.php";

$client = new MongoDB\Client("mongodb://localhost:27017");

$collection_tasks = $client->dbforlab->tasks;
$collection_projects = $client->dbforlab->projects;

$distinctManagers = $collection_projects->distinct("manager");
$distinctProjects = $collection_projects->distinct("name");
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="./main.css">
    <title>Tasks</title>
</head>
<body>
    <form method="post" action="submit_project_date.php">
        <h2>Completed tasks for the selected project on the specified date</h2>
        <label for="project">Choose a project:</label>
        <select name="project" id="project">
        <?php
            foreach ($distinctProjects as $project) {
                echo "<option value='$project'>$project</option>";
            }
        ?>
        </select><br>
        <label for="date">Choose a date:</label>
        <input type="date" name="date" id="date"><br>
        <input type="submit" value="Submit">
    </form>

    <form method="post" action="submit_manager.php">
        <h2>The number of projects of the specified manager</h2>
        <label for="pr_manager">Choose the manager of the projects:</label>
        <select name="pr_manager" id="pr_manager">
            <?php
                foreach ($distinctManagers as $Manager) {
                    echo "<option value='$Manager'>$Manager</option>";
                }
            ?>
        </select><br>
        <input type="submit" value="Submit">
    </form>

    <form method="post" action="submit_workers.php">
        <h2>Employees under the leadership of an selected manager</h2>
        <label for="manager">Choose the manager of the employee:</label>
        <select name="manager" id="manager">
        <?php
            foreach ($distinctManagers as $manager) {
                echo "<option value='$manager'>$manager</option>";
            }
        ?>
        </select><br>
        <input type="submit" value="Submit">
    </form>
</body>
</html>