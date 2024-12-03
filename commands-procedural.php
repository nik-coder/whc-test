<?php
// commands.php
function executeAddCommand($args) {
    $sum = 0;
    foreach ($args as $arg) {
        $sum += (int) $arg;
    }
    return $sum;
}

function executeSortAscCommand($args) {
    sort($args);
    return $args;
}

function executeRepoDescCommand($args) {
    $owner = $args[0];
    $repo = $args[1];
    $url = "https://api.github.com/repos/$owner/$repo";
    $response = json_decode(file_get_contents($url), true);
    return $response['description'];
}

function executeSubtractCommand($args) {
    $result = (int) array_shift($args);
    foreach ($args as $arg) {
        $result -= (int) $arg;
    }
    return $result;
}

?>