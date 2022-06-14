<?php
ini_set('display_errors', 1);
error_reporting(E_ALL);

$root = dirname(__DIR__) . DIRECTORY_SEPARATOR;

define('APP_PATH', $root . 'app' . DIRECTORY_SEPARATOR);
define('FILES_PATH', $root . 'transactions_files' . DIRECTORY_SEPARATOR);
define('VIEWS_PATH', $root . 'views' . DIRECTORY_SEPARATOR);


require APP_PATH . 'Helpers.php';
require APP_PATH . 'App.php';

$files = getTransactionsFiles(FILES_PATH);

$transactions = [];
foreach ($files as $file)
    $transactions = array_merge($transactions, getTransactions($file, 'extractTransaction'));

$totals = getTotals($transactions);


include_once VIEWS_PATH . 'transactions.php';



