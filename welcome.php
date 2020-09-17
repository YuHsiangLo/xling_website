<?php
$allowed = array('eng', 'fra');
if (!isset($lang) && !($_GET['lang']) && !in_array(($_GET['lang']), $allowed)) {
    $lang = 'eng';
} else {
    $lang = ($_GET['lang']);
}
require_once 'language/'.$lang.'/main.php';
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Xling</title>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css" integrity="sha384-Gn5384xqQ1aoWXA+058RXPxPg6fy4IWvTNh0E263XmFcJlSAwiGgFAW/dAiS6JXm" crossorigin="anonymous">
    <script src="https://code.jquery.com/jquery-3.2.1.slim.min.js" integrity="sha384-KJ3o2DKtIkvYIK3UENzmM7KCkRr/rE9/Qpg6aAZGJwFDMVNA/GpGFF93hXpG5KkN" crossorigin="anonymous"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.12.9/umd/popper.min.js" integrity="sha384-ApNbgh9B+Y1QKtv3Rn7W3mgPxhU9K/ScQsAP7hUibX39j7fakFPskvXusvfa0b4Q" crossorigin="anonymous"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/js/bootstrap.min.js" integrity="sha384-JZR6Spejh4U02d8jOt6vLEHfe/JQGiRRSQQxSfFWpi1MquVdAyjUar5+76PVCmYl" crossorigin="anonymous"></script>
</head>
<body>
<nav class="navbar navbar-dark bg-primary">
    <span class="navbar-brand m-1 h1">
        <?php echo($langar['IndexTitle']); ?>
    </span>
</nav>
<br>
<div class="card w-75 mx-auto">
    <div class="card-body" style="font-size: 14pt;">
        <?php echo($langar['IndexText']); ?>
    </div>
</div>
<div class="text-center">
    <a href="<?php echo('consent_form.php?lang='.$lang); ?>" class="btn btn-outline-secondary btn-lg m-3 w-75" role="button">
        <?php echo($langar['IndexLink']); ?>
    </a>
</div>
</body>
</html>
