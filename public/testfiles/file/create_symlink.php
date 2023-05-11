<?php

include_once('helper.php');

// Make sure we have a source and a target
$source = getQueryParameter('source');
$target = getQueryParameter('target');

// Make sure source exists
if (!file_exists($source))
{
    header("HTTP/1.1 500 File '" . $source . "' missing");
    die("File '" . $source . "' missing");
}

// Make sure the target doesnt exist
if (file_exists($target))
{
    header("HTTP/1.1 500 File '" . $target . "' already exists");
    die("File '" . $target . "' already exists");
}

if (!chdir(dirname($source))) {
    header("HTTP/1.1 500 Unable to create symlink");
    die("Unable to create symlink");
}

// Create the symlink
if (!symlink(basename($source), $target))
{
    header("HTTP/1.1 500 Unable to create symlink");
    die("Unable to create symlink");
}
