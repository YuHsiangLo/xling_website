<?php
//session_start();
$lang = $_GET['lang'];
$user_id = $_GET['user_id'];
$reading_passage = file_get_contents('language/'.$lang.'/reading_passage.txt');
require_once "language/".$lang."/main.php";
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css" integrity="sha384-Gn5384xqQ1aoWXA+058RXPxPg6fy4IWvTNh0E263XmFcJlSAwiGgFAW/dAiS6JXm" crossorigin="anonymous">
    <script src="https://code.jquery.com/jquery-3.2.1.slim.min.js" integrity="sha384-KJ3o2DKtIkvYIK3UENzmM7KCkRr/rE9/Qpg6aAZGJwFDMVNA/GpGFF93hXpG5KkN" crossorigin="anonymous"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.12.9/umd/popper.min.js" integrity="sha384-ApNbgh9B+Y1QKtv3Rn7W3mgPxhU9K/ScQsAP7hUibX39j7fakFPskvXusvfa0b4Q" crossorigin="anonymous"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/js/bootstrap.min.js" integrity="sha384-JZR6Spejh4U02d8jOt6vLEHfe/JQGiRRSQQxSfFWpi1MquVdAyjUar5+76PVCmYl" crossorigin="anonymous"></script>
    <script src="js/audiodisplay.js"></script>
    <script src="js/recorderjs/recorder.js"></script>
    <script src="js/main.js"></script>
    <title>Audio Recorder</title>
    <style>
        canvas {
            display: inline-block;
            background: #202020;
            width: 95%;
            height: 50%;
            box-shadow: 0 0 10px #007bff;
        }
        #record.recording {
            background: red;
            background: -webkit-radial-gradient(center, ellipse cover, #ff0000 0%, lightgrey 75%, lightgrey 100%, #7db9e8 100%);
            background: -moz-radial-gradient(center, ellipse cover, #ff0000 0%, lightgrey 75%, lightgrey 100%, #7db9e8 100%);
            background: radial-gradient(center, ellipse cover, #ff0000 0%, lightgrey 75%, lightgrey 100%, #7db9e8 100%);
        }
        h5 {
            color: #007bff;
            margin-top: 1em;
            margin-bottom: 1em;
        }
    </style>
</head>
<body>
<nav class="navbar navbar-dark bg-primary">
    <span class="navbar-brand m-1 h1"><?php echo($langar['RecorderTitle']); ?></span>
</nav>
<br>
<div class="container-fluid">
    <div class="row">
        <div class="col-9">
            <div class="card">
                <div class="card-header">
                    <ul class="nav nav-tabs card-header-tabs">
                        <li class="nav-item">
                            <a class="nav-link active" data-toggle="tab" href="#instructions"><?php echo($langar['RecorderInstructionsTitle']); ?></a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" data-toggle="tab" href="#test"><?php echo($langar['RecorderTestTitle']); ?></a>
                        </li>
                        <?php
                        if ($langar['RecorderReadingTitle']) {
                            echo '<li class="nav-item">',
                            '<a class="nav-link" data-toggle="tab" href="#read">',
                            $langar['RecorderReadingTitle'],
                            '</a>',
                            '</li>';
                        }
                        ?>
                        <li class="nav-item">
                            <a class="nav-link" data-toggle="tab" href="#spontaneous"><?php echo($langar['RecorderSpontaneous']); ?></a>
                        </li>
                    </ul>
                </div>
                <div class="card-body">
                    <div class="tab-content mt-3">
                        <div class="tab-pane active" id="instructions">
                            <p class="card-text">
                                <?php echo($langar['RecorderInstructions']); ?>
                            </p>
                        </div>
                        <div class="tab-pane" id="test">
                            <p class="card-text">
                                <?php echo($langar['RecorderTest']); ?>
                            </p>
                        </div>
                        <?php
                        if ($langar['RecorderReadingTitle']) {
                            echo '<div class="tab-pane" id="read">',
                            '<p class="card-text">',
                            $reading_passage,
                            '</p>',
                            '</div>';
                        }
                        ?>
                        <div class="tab-pane" id="spontaneous">
                            <p class="card-text">
                                <?php echo($langar['RecorderList']); ?>
                            </p>
                        </div>
                    </div>
                </div>
            </div>

        </div>
        <div class="col-3 text-center">
            <div>
                <canvas id="analyser"></canvas>
                <canvas id="wavedisplay"></canvas>
                <div id="audioplayer"></div>
            </div>
            <br>
            <button id="recordButton" class="btn bg-transparent p-0 mx-3">
                <img id="record" src="images/mic128.png" width="50px" height="50px">
                <div id="rectext" style="max-width: 100px; white-space: normal"><?php echo($langar['RecorderRec']); ?></div>
            </button>
            <button id="save" type="button" class="btn bg-transparent p-0 mx-3" onclick="startSubmit(this);" disabled>
                <img id="save" src="images/save.svg" width="50px" height="50px">
                <div style="max-width: 100px; white-space: normal"><?php echo($langar['RecorderSave']); ?></div>
            </button>
            <br>
            <br>
            <h4 id="rectime"><time>00:00:00</time></h4>
            <br>
            <div id="progresstext"><?php echo($langar['RecorderNotYet']); ?></div>
        </div>
    </div>
</div>
<script>
    const user_id = <?php echo(json_encode($user_id)); ?>;
    let array = <?php echo(json_encode($langar['array'])); ?>;
    array = array.split(',');
    const browserError = <?php echo(json_encode($langar['b_err'])); ?>;
    const h1 = document.getElementById('rectime');
    const start = document.getElementById('recordButton');
    var recording_in_progress;
    var seconds = 0;
    var minutes = 0;
    var hours = 0;
    var t;

    function add() {
        seconds++;
        if (seconds >= 60) {
            seconds = 0;
            minutes++;
            if (minutes >= 60) {
                minutes = 0;
                hours++;
            }
        }
        h1.textContent = (hours ? (hours > 9 ? hours : "0" + hours) : "00") + ":" + (minutes ? (minutes > 9 ? minutes : "0" + minutes) : "00") + ":" + (seconds > 9 ? seconds : "0" + seconds);
        timer();
    }

    function timer() {
        t = setTimeout(add, 1000);
    }

    timer();

    window.onload = function() {
        clearTimeout(t);
        h1.textContent = "00:00:00";
        seconds = 0;
        minutes = 0;
        hours = 0;
        recording_in_progress = false;
    }

    start.onclick = function() {
        toggleRecording(document.getElementById('record'));

        if (recording_in_progress) {
            clearTimeout(t);
            h1.textContent = '00:00:00';
            seconds = 0;
            minutes = 0;
            hours = 0;
            recording_in_progress = false;
        } else {
            timer();
            recording_in_progress = true;
        }
    }
</script>
</body>
</html>