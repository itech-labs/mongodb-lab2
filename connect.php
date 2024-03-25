<?php
$client = new MongoDB\Client("mongodb://localhost:27017");

$collection_tasks = $client->dbforlab->tasks;
$collection_projects = $client->dbforlab->projects;