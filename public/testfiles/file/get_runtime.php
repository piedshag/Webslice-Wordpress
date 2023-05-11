<?php

// Make sure a directory name is present
if ($_GET['runtime'] == "")
{
    header("HTTP/1.1 404 Not Found");
    die("Memory missing");
}

// Put the runtime in a variable
$runtime = $_GET['runtime'];

// Get the php version
$php_version = phpversion();

// Check the lambda php version updated
if (strstr($php_version, $runtime))
{
    header("HTTP/1.1 200 Memory correct");
    die("Memory is correct");
}
else
{
    header("HTTP/1.1 500 Memory lower");
    die("Invalid PHP version");
}
