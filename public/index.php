<?php

declare(strict_types = 1);

$root = dirname(__DIR__) . DIRECTORY_SEPARATOR;

define('APP_PATH', $root . 'app' . DIRECTORY_SEPARATOR);
define('FILES_PATH', $root . 'transaction_files' . DIRECTORY_SEPARATOR);
define('VIEWS_PATH', $root . 'views' . DIRECTORY_SEPARATOR);

require_once(APP_PATH . "App.php");

$csv_files = get_csv_files(FILES_PATH);
$transactions = extract_data($csv_files);
[$total_income_val, $total_expense_val] = calculate_total($transactions);
$net_total_val = $total_income_val - $total_expense_val;

// formatting
$total_income = "$" .  $total_income_val;
$total_expense = "-$" .  $total_expense_val;
$net_total = "$" .  $net_total_val;

require_once(VIEWS_PATH . "transactions.php");