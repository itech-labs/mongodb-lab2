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

$currentFile = $_SERVER["PHP_SELF"];

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?php echo($project_name)?></title>
    <link rel="stylesheet" href="./css/response.css">
    <script>
        const saveToLocalStorage = () => {
            const key = <?php echo("'$currentFile,$project_name,$date'")?>;
            const data = <?php echo(json_encode($projects))?>;
            if(data.length != 0){
                localStorage.setItem(key, JSON.stringify(data));
            }
        }
        
        const showSavedResults = (key) => {
            const data = JSON.parse(localStorage.getItem(key));
            const tableContainer = document.getElementById('savedResults');
            
            if (data) {
                const h2 = document.createElement('h2');
                h2.innerHTML = "Previously saved results from localstorage";
                tableContainer.appendChild(h2);
                const table = document.createElement('table');
                const thead = document.createElement('thead');
                const tbody = document.createElement('tbody');

                const headers = ['Project name', 'Title', 'Description', 'Workers', 'Manager', 'Responsible', 'Start time', 'End time'];
                const headerRow = document.createElement('tr');
                headers.forEach(header => {
                    const th = document.createElement('th');
                    th.textContent = header;
                    headerRow.appendChild(th);
                });
                thead.appendChild(headerRow);
                table.appendChild(thead);

                data.forEach(project => {
                    const row = document.createElement('tr');
                    Object.entries(project).forEach(([key, value]) => {
                        if(key != "_id"){
                            const cell = document.createElement('td');
                            cell.textContent = typeof value == "number" ? new Date(value*1000).toLocaleDateString() : value;
                            row.appendChild(cell);
                        }
                    });
                    tbody.appendChild(row);
                });
                table.appendChild(tbody);

                tableContainer.appendChild(table);
            } else {
                tableContainer.textContent = 'There are no previously saved results.';
            }
        }
        
        const onLoad = () => {
            showSavedResults(<?php echo("'$currentFile,$project_name,$date'")?>);
            saveToLocalStorage();
        }
        
        window.onload = onLoad;
    </script>
</head>
<body>
    <h2>Completed tasks for the <?php echo($project_name)?> on the <?php echo($date)?></h2>

    <?php
    if (count($projects) == 0) {
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

    <div id="savedResults" class="savedResults"></div>
</body>
</html>