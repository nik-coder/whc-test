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
    
    // Set up stream context with User-Agent header
    $opts = [
        'http' => [
            'method' => 'GET',
            'header' => [
                'User-Agent: PHP Script',
                'Accept: application/json'
            ]
        ]
    ];
    
    $context = stream_context_create($opts);
    $response = json_decode(file_get_contents($url, false, $context), true);
    
    return $response['description'] ?? 'No description available';
}


function executeSubtractCommand($args) {
    $result = (int) array_shift($args);
    foreach ($args as $arg) {
        $result -= (int) $arg;
    }
    return $result;
}

?>