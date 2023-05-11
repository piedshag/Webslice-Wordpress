<?php

include_once('helper.php');

// Make sure a directory name is present
if (!array_key_exists('memory', $_GET) || $_GET['memory'] == '') {
    header("HTTP/1.1 404 Not Found");
    die("Memory missing");
}

// Put the memory name in a variable
$memory = convert_to_bytes($_GET['memory'], 'MB');

// Get the max memory (20% of the set memory).
//
// At the time we're writing this test AWS is allocating 1226MB to a 1024MB lambda.
// The scale as we increase the memory limit goes up inconsistently so if we choose
// to test a larger size the max_memory of a 20% increase may not be enough.
$max_memory = $memory * 1.2;

// get the memory information
if (($mem_info = get_mem_info()) === false) {
	header('HTTP/1.1 500 Unable to read meminfo');
	die('Unable to read meminfo');
}

// get the total memory metric
if (!array_key_exists('MemTotal', $mem_info)) {
	header('HTTP/1.1 500 Unable to read total memory');
	die('Unable to read total_memory');
}

$total_memory = $mem_info['MemTotal'];

// Check if the lambda memory is less than expected
if ($total_memory < $memory) {
	header("HTTP/1.1 500 Memory lower (" . $total_memory . ")");
	die("Memory lower (" . $total_memory . ")");
}

// Check if the lambda memory is more than expected
if ($total_memory > $max_memory) {
    header("HTTP/1.1 500 Memory Higher (" . $total_memory . ")");
    die("Total memory (" . $total_memory . ") should be less than " . $max_memory);
}

header("HTTP/1.1 200 Memory correct");
die("Memory is correct");
