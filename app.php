<?php

require __DIR__ . '/src/Vlc.php';
require file_exists(__DIR__ . '/conf.php') ? __DIR__ . '/conf.php' : __DIR__ . '/default.conf.php';

$vlc = new \jcisio\VlcRemote\Vlc($host, $port, $password, $paths);
$items = $vlc->getFileList();
$action = isset($_REQUEST['action']) ? $_REQUEST['action'] : 'list';

switch ($action) {
  case 'list':
    $data = array();
    foreach ($items as $uri) {
      $data[] = array(pathinfo(urldecode($uri), PATHINFO_FILENAME));
    }
    die(json_encode(array('data' => $data)));
    break;

  case 'fullscreen':
  case 'pl_next':
  case 'pl_previous':
  case 'in_play':
  case 'in_enqueue':
    $options = array(
      'command' => $action,
    );
    if (isset($_REQUEST['id'])) {
      $id = (int) $_REQUEST['id'];
      $options['input'] = $items[$id];
    }
    $vlc->send('status', $options);
    return;

  case 'audio':
    $status = $vlc->send('status');
    foreach ($status->Streams as $s){};return;
    break;
}
