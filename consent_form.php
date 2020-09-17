<?php
$allowed = array('eng', 'fra', 'pam', 'ceb','acf');
if (!isset($lang) && !($_GET["lang"]) || !in_array(($_GET["lang"]), $allowed)) {
    $lang = 'eng';
}
else {
    $lang = ($_GET['lang']);
}
require_once "language/".$lang."/main.php";
$worker="consent.php?lang=".$lang;
$consent_text = file_get_contents('language/'.$lang.'/consent.txt');
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Consent form</title>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css" integrity="sha384-Gn5384xqQ1aoWXA+058RXPxPg6fy4IWvTNh0E263XmFcJlSAwiGgFAW/dAiS6JXm" crossorigin="anonymous">
    <script src="https://code.jquery.com/jquery-3.2.1.slim.min.js" integrity="sha384-KJ3o2DKtIkvYIK3UENzmM7KCkRr/rE9/Qpg6aAZGJwFDMVNA/GpGFF93hXpG5KkN" crossorigin="anonymous"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.12.9/umd/popper.min.js" integrity="sha384-ApNbgh9B+Y1QKtv3Rn7W3mgPxhU9K/ScQsAP7hUibX39j7fakFPskvXusvfa0b4Q" crossorigin="anonymous"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/js/bootstrap.min.js" integrity="sha384-JZR6Spejh4U02d8jOt6vLEHfe/JQGiRRSQQxSfFWpi1MquVdAyjUar5+76PVCmYl" crossorigin="anonymous"></script>
</head>
<body>
<nav class="navbar navbar-dark bg-primary">
    <span class="navbar-brand m-1 h1"><?php echo($langar['ConsentTitle']); ?></span>
</nav>
<br>
<div class="card w-75 mx-auto">
    <div class="card-body p-3" style="font-size: 12pt; overflow-y: auto; max-height: 275px">
            <?php echo($consent_text); ?>
    </div>
</div>
<br>
<form action="<?php echo($worker); ?>" method="post">
<div class="container w-75 px-2">
    <div class="row">
        <div class="col">
            <h4><?php echo($langar['ConsentParticipation']); ?></h4>
            <p><?php echo($langar['ConsentParticipationText']); ?></p>
            <div class="input-group mb-3 w-75 mx-auto">
                <div class="input-group-prepend">
                    <span class="input-group-text"><?php echo($langar['ConsentName']); ?></span>
                </div>
                <input id="name" name="user_name" type="text" class="form-control" required>
            </div>
            <div class="input-group mb-3 w-75 mx-auto">
                <div class="input-group-prepend">
                    <span class="input-group-text"><?php echo($langar['ConsentEmail']); ?></span>
                </div>
                <input id="email" name="user_email" type="email" class="form-control" required>
            </div>
            <div class="form-check w-75 mx-auto">
                <input class="form-check-input" name="consent_box" type="checkbox" value="on" id="check_1" onchange="document.getElementById('c_button').disabled = !this.checked" required>
                <label class="form-check-label" for="check_1">
                    <?php echo($langar['ConsentParticipationConsent']); ?>
                </label>
            </div>
        </div>
        <div class="col">
            <h4><?php echo($langar['ConsentPublication']); ?></h4>
            <p><?php echo($langar['ConsentPublicationText1'].'['.$lang.'-1], ['.$lang.'-2]'.$langar['ConsentPublicationText2']); ?></p>
            <div class="form-check w-75 mx-auto">
                <input class="form-check-input" name="share_box" type="checkbox" value="on" id="check_2">
                <label class="form-check-label" for="check_2">
                    <?php echo($langar['ConsentPublicationConsent']); ?>
                </label>
            </div>
        </div>
    </div>
</div>

<div class="text-center">
<button type="submit" id="c_button" class="btn btn-primary" disabled>
    <?php echo($langar['Submit']); ?>
</button>
</div>
</form>
<br>
</body>
</html>
