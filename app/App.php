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

/**
 * Extracts data from .csv files into associative array.
 * 
 * @param array $csv_files
 * @param array $data
 */
function extract_data($csv_files) {
    $data = [];

    foreach ($csv_files as $filename) {

        if (($file = fopen($filename, "r")) !== false) {
            $headers = fgetcsv($file);
    
            while (($line = fgetcsv($file)) !== false) {
                // Date formatting
                $date = date_create($line[0]);
                $line[0] = date_format($date, "M j, Y");
    
                $data[] = array_combine($headers, $line);
    
            }
    
            fclose($file);
        }

    }

    return $data;
}
?>