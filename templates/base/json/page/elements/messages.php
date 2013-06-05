<?php

$errors = Site::getSiteMessages('error');
$system = Site::getSiteMessages('system');
$success = Site::getSiteMessages('success');
$debug = Site::getSiteMessages('debug');

$messages = array();

if ($success) {
    foreach ($success as $message)
        $messages[] = array('status' => 'success', 'message' => $message);
}
if ($errors) {
    foreach ($errors as $message)
        $messages[] = array('status' => 'error', 'message' => $message);
}

if ($system) {
    foreach ($system as $message)
        $messages[] = array('status' => 'system', 'message' => $message);
}

if ($debug) {
    foreach ($debug as $message)
        $messages[] = array('status' => 'debug', 'message' => $message);
}

echo json_encode($messages);