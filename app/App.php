<?php
declare(strict_types=1);

$transactionsFile = FILES_PATH . 'sample_1.csv';

function getTransactionsFiles(string $pathDir): array
{
    $files = [];
    foreach (scandir($pathDir) as $file) {
        if (is_dir($file))
            continue;
        $files[] = $pathDir . $file;
    }
    return $files;
}

function getTransactions(string $fileName, ?callable $transactionHandler = null): array
{
    $file = fopen($fileName, 'r');

    fgetcsv($file);

    $transactions = [];

    while (($transaction = fgetcsv($file)) !== false) {

        if ($transactionHandler !== null)
            $transaction = $transactionHandler($transaction);

        $transactions[] = $transaction;
    }

    fclose($file);

    return $transactions;
}

function extractTransaction(array $transaction): array
{

    [$date, $check, $description, $amount] = $transaction;

    $amount = str_replace(['$', ','], '', $amount);

    return [
        'date' => $date,
        'check' => $check,
        'description' => $description,
        'amount' => (float)$amount
    ];
}

function getTotals(array $transactions): array
{

    $totals = [
        'netTotal' => 0,
        'totalExpense' => 0,
        'totalIncome' => 0
    ];

    foreach ($transactions as $transaction) {
        $totals['netTotal'] += $transaction['amount'];

        if ($transaction['amount'] <= 0) {
            $totals['totalExpense'] += $transaction['amount'];
        } else
            $totals['totalIncome'] += $transaction['amount'];

    }

    return $totals;
}



