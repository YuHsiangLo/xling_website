<?php
//session_start();
$lang = $_GET['lang'];
$user_id = $_GET['user_id'];
$reading_passage = file_get_contents('language/'.$lang.'/reading_passage.txt');
require_once "language/".$lang."/main.php";
?>

<!DOCTYPE html>
<html>
<head>
    <meta http-equiv="content-type" content="text/html; charset=UTF-8">
    <link rel="stylesheet" href="/bootstrap/css/bootstrap.min.css">
    <script src="/bootstrap/js/jquery.min.js"></script>
    <script src="/bootstrap/js/bootstrap.min.js"></script>
    <script src="js/audiodisplay.js"></script>
    <script src="js/recorderjs/recorder.js"></script>
    <script src="js/main.js"></script>
    <meta http-equiv="content-type" content="text/html; charset=windows-1252">
    <meta name="viewport" content="width=device-width,initial-scale=1">
    <title>Audio Recorder</title>
    <style>
        html { overflow: scroll; }
        body {
            font: 12pt Arial, sans-serif;
            background: lightgrey;
        // display: flex;
        // flex-direction: column;
            height: 100vh;
            width: 100%;
            margin: 0 0;
        }
        canvas {
            display: inline-block;
            background: #202020;
            width: 90%;
            height: 45%;
            box-shadow: 0px 0px 10px blue;
        }
        h4 {color: #337ab7;}

        #controls {
            display: flex;
            flex-direction: column;
            height: 15%;
            width: 100%;
            min-height: 160px;
        }
        #buttons {
            display: flex;
            flex-direction: row;
            text-align: center;
            align-items: center;
            padding: 10px 0px;
            width: 100%;
            justify-content: space-around;
        }
        #progresstext {
            padding: 10px 0px;
            text-align: center;
            margins: auto;
        }
        #record, #exit, #save img { max-height: 70px; height: 10vh; width: auto;}
        // #exit { height: 70px; }
        // #save, #save img { height: 70px; }
        #record.recording {
            background: red;
            background: -webkit-radial-gradient(center, ellipse cover, #ff0000 0%,lightgrey 75%,lightgrey 100%,#7db9e8 100%);
            background: -moz-radial-gradient(center, ellipse cover, #ff0000 0%,lightgrey 75%,lightgrey 100%,#7db9e8 100%);
            background: radial-gradient(center, ellipse cover, #ff0000 0%,lightgrey 75%,lightgrey 100%,#7db9e8 100%);
        }


        .column-container {display: flex; width: 100%; height: 100%; flex-direction: row; overflow: auto;}
        .second-column { display:flex; flex-direction: column; overflow: auto; }
        .first-column { flex: 1 1; border: none; margin: 0; padding: 0; overflow: auto; min-width: 375px;}
        .container { overflow:overlay; max-height: 85%; width:100%;}
        .btntext {max-width: 100px;}

        // #save, #save img { height: 10vh; }

        #save { opacity: 0.25;}
        #save[download] { opacity: 1;}
        #viz {
            margin-top: 10px;
            height: 55%;
            width: 100%;
            max-width: 350px;
            display: flex;
            flex-direction: column;
            justify-content: space-around;
            align-items: center;
        }
        @media (orientation: portrait) {
            .column-container { flex-direction: column; width: 100%; height: 100%;}
            .first-column { width: 100%; max-height: 55%; overflow: auto;}
            .second-column { width: 100%; min-width: 300px;}
            /*#viz { height: 150px; }*/
            #record, #exit, #save img { height: 10vw;}
            #controls { font-size: 3vw; }
        // #controls { flex-direction: column; height: 100%; width: 100%;}
        // #viz { height: 100%; width: 100%;}
        }
        object{  width: 100%;  height: 60%; font-family: arial, sans-serif;}
        table {  font-family: arial, sans-serif;  border-collapse: collapse;  width: 100%;}
    </style>

    <div id="dom-target" style="display: none;">
        <?php echo($user_id) ?>
    </div>
    <div id="errors" style="display: none;">
        <?php echo($langar['array']) ?>
    </div>
    <div id="b_err" style="display: none;">
        <?php echo($langar['b_err']) ?>
    </div>
    <script>
        var div = document.getElementById("dom-target");
        var errors = document.getElementById("errors");
        var user_id = div.innerText.trim();
        var array = errors.innerText.trim();
        array = array.split(',');
        var b_err = document.getElementById("b_err");
        var browserError = b_err.innerText.trim();
    </script>
</head>
<body>
<div class="column-container">
    <div class="first-column">

        <nav class="navbar navbar-primary bg-primary">
            <span class="navbar-brand mb-0 h1"><?php echo($langar['RecorderTitle'])?></span>
        </nav>
        <div class="container">
            <div class="panel-group" id="accordion">
                <div class="panel panel-default">
                    <div class="panel-heading">
                        <h4 class="panel-title">
                            <a data-toggle="collapse" data-parent="#accordion" href="#collapse1"><?php echo($langar['RecorderInstructionsTitle'])?></a>
                        </h4>
                    </div>
                    <div id="collapse1" class="panel-collapse collapse in">
                        <div class="panel-body"> <?php echo($langar['RecorderInstructions'])?></div>
                    </div>
                </div>
                <div class="panel panel-default">
                    <div class="panel-heading">
                        <h4 class="panel-title">
                            <a data-toggle="collapse" data-parent="#accordion" href="#collapse4"><?php echo($langar['RecorderTestTitle'])?></a>
                        </h4>
                    </div>
                    <div id="collapse4" class="panel-collapse collapse in">
                        <div class="panel-body"> <?php echo($langar['RecorderTest'])?></div>
                    </div>
                </div>
                <div class="panel panel-default">
                    <div class="panel-heading">
                        <h4 class="panel-title">
                            <a data-toggle="collapse" data-parent="#accordion" href="#collapse2"><?php echo($langar['RecorderReadingTitle'])?></a>
                        </h4>
                    </div>
                    <div id="collapse2" class="panel-collapse collapse">
                        <div class="panel-body"><?php echo $reading_passage ?></div>
                    </div>
                </div>
                <div class="panel panel-default">
                    <div class="panel-heading">
                        <h4 class="panel-title">
                            <a data-toggle="collapse" data-parent="#accordion" href="#collapse3"><?php echo($langar['RecorderSpontaneous'])?></a>
                        </h4>
                    </div>
                    <div id="collapse3" class="panel-collapse collapse">
                        <div class="panel-body"><?php echo($langar['RecorderList'])?></div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="second-column">
        <div id="viz">
            <canvas id="analyser" width="1000" height="150"></canvas>
            <canvas id="wavedisplay" width="1000" height="150"></canvas>
            <div id="audioplayer"></div>
        </div>
        <div id="controls">
            <div id="buttons">
                <div id="record-div" class="btntext">
                    <button id="recordButton" onclick="toggleRecording(document.getElementById('record'));" style="border: none; background-color: transparent;">
                        <img id="record" src="images/mic128.png" width="70" height="70">
                        <br/>
                        <div id="rectext"><?php echo($langar['RecorderRec'])?></div>
                    </button>
                </div>
                <div id="save-div" class="btntext">
                    <button id="save" href="#" onclick="startSubmit(this);" style="border: none; background-color: transparent;" disabled>
                        <img src="images/save.svg" width="70" height="70">
                        <br/>
                        <?php echo($langar['RecorderSave'])?>
                    </button>
                </div>
                <h4 id="rectime"><time>00:00:00</time></h4>
            </div>

            <div id="progresstext"><div style="color: red;"><?php echo($langar['RecorderNotYet'])?></div></div>
        </div>
    </div>
</div>
</body>

<script>
    const h1 = document.getElementById('rectime');
    const start = document.getElementById('record-div');
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
    /* Start button */
    start.onclick = function() {
        if (recording_in_progress) {
            clearTimeout(t);
            h1.textContent = "00:00:00";
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

</html>