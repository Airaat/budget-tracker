<?php

declare(strict_types = 1);

/**
 * Extracts full paths of .csv files from the given directory.
 * 
 * @param string $dir Given directory.
 * @return array $files Full paths of .csv files.
 */
function get_csv_files(string $dir) {
    $files = [];
    $content = scandir($dir);

    foreach($content as $name) {

        if ($name === '.' || $name === '..') continue;

        $full_path = $dir . $name;
        $extension = substr($name, -4);

        if (is_file($full_path) && $extension === ".csv") {
            $files[] = $full_path;
        }

    }

    return $files;
}
?>