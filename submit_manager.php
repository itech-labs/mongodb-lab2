<?php
require_once __DIR__ . "/vendor/autoload.php";
include("connect.php");

$pr_manager = $_GET["pr_manager"];

$query = [];
$query["manager"] = $pr_manager;

$cursor = $collection_projects->find($query, ["_id" => 0]);

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
    <title><?php echo($pr_manager)?></title>
    <link rel="stylesheet" href="./css/response.css">
    <script>
        const saveToLocalStorage = () => {
            const key = <?php echo("'$currentFile,$pr_manager'")?>;
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
                const h1 = document.createElement('h1');
                h2.innerHTML = "Previously saved results from localstorage";
                h1.innerHTML = data.length;
                tableContainer.appendChild(h2);
                tableContainer.appendChild(h1);
                const table = document.createElement('table');
                const thead = document.createElement('thead');
                const tbody = document.createElement('tbody');

                const headers = ['Project name', 'Manager name'];
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
                            cell.textContent = value;
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
            showSavedResults(<?php echo("'$currentFile,$pr_manager'")?>);
            saveToLocalStorage();
        }
        
        window.onload = onLoad;
    </script>
</head>
<body>
    <h2>The number of projects of the <?php echo($pr_manager)?></h2>
    <h1><?php echo(count($projects))?></h1>

    <?php
    if (count($projects) == 0) {
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
                foreach ($projects as $project) {
                    printf("<tr><td>%s</td>", $project["name"]);
                    printf("<td>%s</td></tr>", $project["manager"]);
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