<?php
require_once __DIR__ . "/vendor/autoload.php";

$collection_tasks = (new MongoDB\Client)->dbforlab->tasks;
$collection_projects = (new MongoDB\Client)->dbforlab->projects;
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
        <h2>Select completed tasks</h2>
        <label for="project">Select a project:</label>
        <select name="project" id="project">
        
        </select><br>
        <label for="date">Choose a date:</label>
        <input type="date" name="date" id="date"><br>
        <input type="submit" value="Submit">
    </form>

    <form method="post" action="submit_manager.php">
        <h2>Choose the number of projects</h2>
        <label for="pr_manager">Choose the manager of the projects:</label>
        <select name="pr_manager" id="pr_manager">
            <!--  -->
        </select><br>
        <input type="submit" value="Submit">
    </form>

    <form method="post" action="submit_workers.php">
        <h2>Select employees</h2>
        <label for="manager">Choose the manager of the employee:</label>
        <select name="manager" id="manager">
            <!--  -->
        </select><br>
        <input type="submit" value="Submit">
    </form>
</body>
</html>