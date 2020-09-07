<?php

function test_input($data) {
  $data = trim($data);
  $data = stripslashes($data);
  $data = htmlspecialchars($data);
  return $data;
}

$lang = $_GET['lang'];
$user_id = $_GET['user_id'];
$age = $gender = $place_of_birth = $place_of_residence = $l2 = $l3 = $l4 = $l5 = $l6 = "";

if ($_SERVER["REQUEST_METHOD"] == "POST") {
  $age = test_input($_POST["user_age"]);
  $gender = test_input($_POST["user_gender"]);
  $place_of_birth = test_input($_POST["user_pob"]);
  $place_of_residence = test_input($_POST["user_cpor"]);
  $l2 = test_input($_POST["user_l2"]);
  $l3 = test_input($_POST["user_l3"]);
  $l4 = test_input($_POST["user_l4"]);
  $l5 = test_input($_POST["user_l5"]);
  $l6 = test_input($_POST["user_l6"]);
}

$demo_full = array_map('str_getcsv', file("data/demographic_data.csv"));
array_walk($demo_full, function(&$a) use ($demo_full) {
  $a = array_combine($demo_full[0], $a);
});
array_shift($demo_full); # remove column header

$myfile = fopen("data/demographic_data.csv", "a") or die("Unable to open file!");
fwrite($myfile,'"'.$user_id.'","'.$age.'","'.$gender.'","'.$place_of_birth.'","'.$place_of_residence.'","'.$l2.'","'.$l3.'","'.$l4.'","'.$l5.'","'.$l6.'"'."\n");
fclose($myfile);

header('Location: recorder.php?lang='.$lang.'&user_id='.$user_id);
?>

