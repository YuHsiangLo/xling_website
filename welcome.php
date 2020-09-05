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
    <link rel="stylesheet" href="/bootstrap/css/bootstrap.min.css">
    <style>
        h4 {
            margin: 0 auto;
            margin-top: 3%;
            padding: 10px;
            width: 75%;
            border: 1px solid #CCC;
            border-radius: 1em;
        }
    </style>
    <script src="/bootstrap/js/bootstrap.min.js"></script>
    <script src="/bootstrap/js/jquery.min.js"></script>
    <script>
        function initAudio() {
            console.log(navigator);
            // Older browsers might not implement mediaDevices at all, so we set an empty object first
            if (navigator.mediaDevices === undefined) {
                navigator.mediaDevices = {};
            }

            // Some browsers partially implement mediaDevices. We can't just assign an object
            // with getUserMedia as it would overwrite existing properties.
            // Here, we will just add the getUserMedia property if it's missing.

            if (navigator.mediaDevices.getUserMedia === undefined) {
                navigator.mediaDevices.getUserMedia = function(constraints) {

                    // First get ahold of the legacy getUserMedia, if present
                    var getUserMedia = navigator.webkitGetUserMedia || navigator.mozGetUserMedia;

                    // Some browsers just don't implement it - return a rejected promise with an error
                    // to keep a consistent interface
                    if (!getUserMedia) {
                        window.alert("Sorry, your web browser does not seem to support Web Audio API. The online recorder will not function. Please try upgrading your browser, or try a different browser.");
                        return Promise.reject(new Error('getUserMedia is not implemented in this browser'));
                    }

                    // Otherwise, wrap the call to the old navigator.getUserMedia with a Promise
                    return new Promise(function(resolve, reject) {
                        getUserMedia.call(navigator, constraints, resolve, reject);
                    });
                }
            }

            // TODO: what's the purpose of the following code?
            if (!navigator.cancelAnimationFrame) {
                console.log(navigator.webkitCancelAnimationFrame);
                console.log(navigator.mozCancelAnimationFrame);
                navigator.cancelAnimationFrame = navigator.webkitCancelAnimationFrame || navigator.mozCancelAnimationFrame;
            }

            console.log(!navigator.cancelAnimationFrame)

            if (!navigator.requestAnimationFrame) {
                navigator.requestAnimationFrame = navigator.webkitRequestAnimationFrame || navigator.mozRequestAnimationFrame;
            }

            //TODO: the following code throws an error: gotStream not defined
            navigator.mediaDevices.getUserMedia({"audio": true}).then(function(stream) {
                return gotStream(stream);
            }).catch(function(e) {
                console.log(e);
            });
        }

        console.log(navigator)

        window.addEventListener('load', initAudio);
    </script>
</head>
<body>
<nav class="navbar navbar-primary bg-primary">
    <span class="navbar-brand mb-0 h1"><?php echo($langar['IndexTitle']); ?></span>
</nav>
<h4><?php echo($langar['IndexText']); ?></h4>
<h4>
    <a class=button href=<?php echo('consent_form.php?lang='.$lang); ?>><?php echo($langar['IndexLink']); ?></a>
</h4>
</body>
</html>
