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


/**
 * Calculate total income, total expense from the given data.
 * 
 * @param array $data
 * @return array [$total_income, $total_expense] 
 */
function calculate_total($data) {
    $total_income = 0.0;
    $total_expense = 0.0;
    
    foreach ($data as $content) {
        $string = str_replace(",", "", $content["Amount"]);
        $sign = ($string[0] === '-') ? -1 : 1;
        $num = substr($string, strpos($string, '$') + 1);

        $val = $sign * doubleval($num);
        $total_income += ($val > 0) ? $val : 0.0;
        $total_expense += ($val < 0) ? $val : 0.0;
    }

    $total_expense = abs($total_expense);

    return [$total_income, $total_expense];
}
?>