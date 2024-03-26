<?php
require_once __DIR__ . "/vendor/autoload.php";
include("connect.php");

$pr_manager = $_GET["manager"];

$query = [];
$query["manager"] = $pr_manager;

$workers = $collection_tasks->distinct("workers", $query, ["_id" => 0]);

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
            const data = <?php echo(json_encode($workers))?>;
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

                const headers = ['Employees name'];
                const headerRow = document.createElement('tr');
                headers.forEach(header => {
                    const th = document.createElement('th');
                    th.textContent = header;
                    headerRow.appendChild(th);
                });
                thead.appendChild(headerRow);
                table.appendChild(thead);

                data.forEach(worker => {
                    const row = document.createElement('tr');
                    const cell = document.createElement('td');
                    cell.textContent = worker;
                    row.appendChild(cell);
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

    <div id="savedResults" class="savedResults"></div>
</body>
</html>