<?php
// commands.php
class Command {
    public function execute($args) {}
}

class AddCommand extends Command {
    public function execute($args) {
        $sum = 0;
        foreach ($args as $arg) {
            $sum += (int) $arg;
        }
        return $sum;
    }
}

class SortAscCommand extends Command {
    public function execute($args) {
        sort($args);
        return $args;
    }
}

class SubtractCommand extends Command {
    public function execute($args) {
        $result = (int) array_shift($args);
        foreach ($args as $arg) {
            $result -= (int) $arg;
        }
        return $result;
    }
}

class RepoDescCommand extends Command {
    public function execute($args) {
        $owner = $args[0];
        $repo = $args[1];
        $url = "https://api.github.com/repos/$owner/$repo";
        $response = json_decode(file_get_contents($url), true);
        return $response['description'];
    }
}

?>