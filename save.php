<?php
// Muaz Khan     - www.MuazKhan.com
// MIT License   - https://www.webrtc-experiment.com/licence/
// Documentation - https://github.com/muaz-khan/RecordRTC

function selfInvoker()
{
    if (!isset($_POST['audio-filename']) && !isset($_POST['video-filename'])) {
        error_log ('Empty file name');
        echo 'Empty file name.';
        return;
    }

    // do NOT allow empty file names
    if (empty($_POST['audio-filename']) && empty($_POST['video-filename'])) {
        error_log ('Empty file name');
        echo 'Empty file name.';
        return;
    }

    // do NOT allow third party audio uploads
    if (isset($_POST['audio-filename']) && strrpos($_POST['audio-filename'], "RecordRTC-") !== 0) {
        error_log ('Audio File name must start with RecordRTC-, filename is '.$_POST['audio-filename']);
        echo 'File name must start with "RecordRTC-"';
        return;
    }

    // do NOT allow third party video uploads
    if (isset($_POST['video-filename']) && strrpos($_POST['video-filename'], "RecordRTC-") !== 0) {
        error_log ('Video File name must start with RecordRTC-');
        echo 'File name must start with "RecordRTC-"';
        return;
    }

    $fileName = '';
    $tempName = '';
    $file_idx = '';

    if (!empty($_FILES['audio-blob'])) {
        $file_idx = 'audio-blob';
        $fileName = $_POST['audio-filename'];
        $tempName = $_FILES[$file_idx]['tmp_name'];
    } else {
        $file_idx = 'video-blob';
        $fileName = $_POST['video-filename'];
        $tempName = $_FILES[$file_idx]['tmp_name'];
    }

    if (empty($fileName) || empty($tempName)) {
        if(empty($tempName)) {
            error_log ('Invalid temp_name: '.$tempName);
            echo 'Invalid temp_name: '.$tempName;
            return;
        }
        error_log('Invalid file name: '.$fileName);
        echo 'Invalid file name: '.$fileName;
        return;
    }

    $participant_folder = $_POST['participant_folder'];

    if (!file_exists('uploads/'.$participant_folder)) {
        mkdir('uploads/'.$participant_folder, 0777, true);
    }

    $filePath = 'uploads/'.$participant_folder.$fileName;

    // make sure that one can upload only allowed audio/video files
    $allowed = array('webm', 'wav', 'mp4', 'mkv', 'mp3', 'ogg');
    $extension = pathinfo($filePath, PATHINFO_EXTENSION);
    if (!$extension || empty($extension) || !in_array($extension, $allowed)) {
        error_log('Invalid file extension: '.$extension);
        echo 'Invalid file extension: '.$extension;
        return;
    }

    if (!move_uploaded_file($tempName, $filePath)) {
        error_log('Problem saving file: '.$tempName.','.$filePath);
        echo 'Problem saving file: '.$tempName;
        return;
    }

    echo 'success';
}

selfInvoker();
?>
