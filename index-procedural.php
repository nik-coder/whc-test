<?php

require_once 'commands-procedural.php';

$commands = [
    'add' => 'executeAddCommand',
    'sort-asc' => 'executeSortAscCommand',
    'repo-desc' => 'executeRepoDescCommand',
    'subtract' => 'executeSubtractCommand',
];

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $input = $_POST['input'];
    $parts = explode(' ', $input);
    $commandName = $parts[0];
    $args = array_slice($parts, 1);

    if (!isset($commands[$commandName])) {
        echo 'Invalid command';
        exit;
    }

    try {
        $commandFunction = $commands[$commandName];
        $result = $commandFunction($args);
        echo json_encode(['result' => $result]);
    } catch (Exception $e) {
        echo json_encode(['error' => $e->getMessage()]);
    }
    exit;
}

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Command App</title>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css">
</head>
<body>
    <div class="container">
        <h1>Command App</h1>
        <form id="command-form">
            <div class="form-group">
                <label for="input">Enter command and arguments:</label>
                <input type="text" class="form-control" id="input" name="input">
                <div id="error" style="color: red;"></div>
            </div>
            <button type="submit" class="btn btn-primary" name="submit">Submit</button>
        </form>
        <div id="result"></div>
    </div>

    <script src="https://code.jquery.com/jquery-3.2.1.min.js"></script>
    <script>
        $(document).ready(function() {
            $('#command-form').submit(function(event) {
                event.preventDefault();
                var input = $('#input').val();
                var parts = input.split(' ');
                var commandName = parts[0];
                var args = parts.slice(1);

                $('#error').html(''); // Clear previous error message

                if (!commandName) {
                    $('#error').html('Please enter a command');
                    return false;
                }

                if (commandName !== 'add' && commandName !== 'sort-asc' && commandName !== 'repo-desc' && commandName !== 'subtract') {
                    $('#error').html('Invalid command');
                    return false;
                }

                if (commandName === 'add') {
                    for (var i = 0; i < args.length; i++) {
                        if (isNaN(args[i])) {
                            $('#error').html('Invalid argument for add command');
                            return false;
                        }
                    }
                }

                if (commandName === 'subtract') {
                    for (var i = 0; i < args.length; i++) {
                        if (isNaN(args[i])) {
                            $('#error').html('Invalid argument for subtract command');
                            return false;
                        }
                    }
                }

                if (commandName === 'repo-desc') {
                    if (args.length !== 2) {
                        $('#error').html('Invalid arguments for repo-desc command');
                        return false;
                    }
                }

                $.ajax({
                    type: 'POST',
                    url: '',
                    data: {input: input, submit: true},
                    dataType: 'json',
                    success: function(response) {
                        if (response.error) {
                            $('#result').html('<div class="alert alert-danger">' + response.error + '</div>');
                        } else {
                            $('#result').html('<div class="alert alert-success">' + response.result + '</div>');
                        }
                    }
                });
            });
        });
    </script>
</body>
</html>