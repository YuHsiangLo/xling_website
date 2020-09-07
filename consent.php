<?php
// define functions

function test_input($data) {
    $data = trim($data);
    $data = stripslashes($data);
    $data = htmlspecialchars($data);
    return $data;
}

// define variables and set to empty values
$name = $email = $code = $public = "";

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $name = test_input($_POST["user_name"]);
    $email = test_input($_POST["user_email"]);
    $public = test_input($_POST["share_box"]);
    $language = $_GET["lang"];
}

$consent_full = array_map('str_getcsv', file("data/consent.csv"));
array_walk($consent_full, function(&$a) use ($consent_full) {
    $a = array_combine($consent_full[0], $a);
});
array_shift($consent_full); # remove column header

$myfile = fopen("data/consent.csv", "a") or die("Unable to open file!");
if (sizeof($consent_full) == 0) {
    $curr_code = 1;
} else {
    $last_code = (int) filter_var($consent_full[sizeof($consent_full)-1]["code"], FILTER_SANITIZE_NUMBER_INT);
    //$last_code = (int) filter_var(array_count_values(array_column($consent_full, 'code'))[$language], FILTER_SANITIZE_NUMBER_INT);
    $curr_code = $last_code + 1;
}

//from: https://stackoverflow.com/questions/4356289/php-random-string-generator
function generateRandomString($length = 10) {
    $characters = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
    $charactersLength = strlen($characters);
    $randomString = '';
    for ($i = 0; $i < $length; $i++) {
        $randomString .= $characters[rand(0, $charactersLength - 1)];
    }
    return $randomString;
}

$user_id = generateRandomString();
fwrite($myfile, '"'.$name.'","'.$email.'","'.$language.'_'.$user_id.'","'.$public.'"'."\n");
fclose($myfile);

header('Location: demographic_questionnaire.php?lang='.$language.'&user_id='.$language.'_'.$user_id);
?>