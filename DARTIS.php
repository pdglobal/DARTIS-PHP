<?php
error_reporting(0);
include_once 'keys.php';
include_once 'construct.php';
include_once 'time.php';
include_once 'strings.php';
include_once 'math.php';
include_once 'crypt.php';

echo "<center><h2>DARTIS DEBUGGER AND PERFORMANCE ANALYZER</h2><hr/>";
$start = microtime(true);
$key_ob = new keys();
$key = $key_ob->generate();
$total = round((microtime(true) - $start) * 1000, 4);
echo "Generated key in " . $total . " milliseconds" . "<br/>Key MD5: " . MD5($key) . "<br/>Key Size: " . (strlen($key) / 1000 / 1000) . " MB<hr/>";

$start2 = microtime(true);
$construct_ob = new construct();
$loaded_key = $construct_ob->load($key);
$total = round((microtime(true) - $start2) * 1000, 4);
echo "Loaded key in " . $total . " milliseconds" . "<br/>Blueprint Elements:" . number_format(count($loaded_key)) . "<hr/>";

$time_ob = new time();
$timestamp = $time_ob->getTimestamp(count($loaded_key) - 2, rand());
echo "Current TimeStamp: ";
$timehash = "";
foreach ($timestamp as $timeblock) {
    $timehash .= $timeblock . "-";
}
echo trim($timehash, "-");
echo "<hr/>";

$start3 = microtime(true);
$data = "Running DARTIS Operations test at " . (isset($_SERVER['HTTPS']) ? "https" : "http") . "://$_SERVER[HTTP_HOST]$_SERVER[REQUEST_URI]";
$crypt_ob = new crypt();
/* NOTICE: As a result of the way computers measure time, it is nessecary to pass a value to the crypt function in order to generate a unqinue
 * timestamp for every possible measurment. It is reccomended that if you operate this function in a loop, that you define a value somewhere
 * on the computer/server and increment that value each time you encrypt data, then pass the value to the crypt function as the 3rd value.
 * You can reset the number back to 0 every 250 ms so that it doesn't grow unreasonably large, or you can just reset it after it has reached
 * a value of at least 1000 */
$result = $crypt_ob->inject($data, $loaded_key);
$total = round((microtime(true) - $start3) * 1000, 4);
Echo "Encrypting: '" . $data . "' (" . strlen($data) . " Bytes)<br/>Constructed Encrypted Hologram in " . $total . " miliseconds.<br/><br/>Result:<br/>";
echo '<textarea cols="40" rows="10" wrap="hard">' . $result . '</textarea> <style> textarea { width: 100%; } </style><hr/>';
$start4 = microtime(true);
$deresult = $crypt_ob->extract($result, $loaded_key);
$total = round((microtime(true) - $start4) * 1000, 4);
Echo "Decrypting data. (" . strlen($result) . " Bytes)<br/>Extracted data in " . $total . " miliseconds.<br/><br/>Result:<br/>";
echo '<textarea cols="40" rows="10" wrap="hard">' . $deresult . '</textarea> <style> textarea { width: 100%; } </style>';

echo "<hr/></center>";
?>