<?php
$lang = $_GET['lang'];
$user_id = $_GET['user_id'];
$extract_data = '/demographic.php?lang='.$lang.'&user_id='.$user_id;
require_once 'language/'.$lang.'/main.php';
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Demographic questionnaire</title>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css" integrity="sha384-Gn5384xqQ1aoWXA+058RXPxPg6fy4IWvTNh0E263XmFcJlSAwiGgFAW/dAiS6JXm" crossorigin="anonymous">
    <script src="https://code.jquery.com/jquery-3.2.1.slim.min.js" integrity="sha384-KJ3o2DKtIkvYIK3UENzmM7KCkRr/rE9/Qpg6aAZGJwFDMVNA/GpGFF93hXpG5KkN" crossorigin="anonymous"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.12.9/umd/popper.min.js" integrity="sha384-ApNbgh9B+Y1QKtv3Rn7W3mgPxhU9K/ScQsAP7hUibX39j7fakFPskvXusvfa0b4Q" crossorigin="anonymous"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/js/bootstrap.min.js" integrity="sha384-JZR6Spejh4U02d8jOt6vLEHfe/JQGiRRSQQxSfFWpi1MquVdAyjUar5+76PVCmYl" crossorigin="anonymous"></script>
</head>
<body>
<nav class="navbar navbar-dark bg-primary">
    <span class="navbar-brand m-1 h1"><?php echo($langar['DemoTitle']); ?></span>
</nav>
<br>
<form class="w-50 mx-auto" action="<?php echo $extract_data; ?>" method="post">
    <div class="form-row">
        <div class="form-group col-md-6">
            <label for="age"><?php echo($langar['Age']); ?></label>
            <input type="number" class="form-control" id="age" name="user_age" min="0" required>
        </div>
        <div class="form-group col-md-6">
            <label for="gender"><?php echo($langar['Gender']); ?></label>
            <input type="text" class="form-control" id="gender" name="user_gender" required>
        </div>
    </div>
    <div class="form-group">
        <label for="pob"><?php echo($langar['PoB']); ?></label>
        <input type="text" class="form-control" id="pob" name="user_pob" required>
    </div>
    <div class="form-group">
        <label for="cpor"><?php echo($langar['Location']); ?></label>
        <input type="text" class="form-control" id="cpor" name="user_cpor" required>
    </div>
    <div class="form-group">
        <label><?php echo($langar['SpokenLanguages']); ?></label>
        <input type="text" class="form-control m-0" name="user_l2">
        <input type="text" class="form-control m-0" name="user_l3">
        <input type="text" class="form-control" name="user_l4">
        <input type="text" class="form-control" name="user_l5">
        <input type="text" class="form-control" name="user_l6">
    </div>
    <div class="text-center">
        <button type="submit" class="btn btn-primary">
            <?php echo($langar['Next']); ?>
        </button>
    </div>
</form>
</body>
</html>
