<?php

require __DIR__ . '/src/Vlc.php';
require file_exists(__DIR__ . '/conf.php') ? __DIR__ . '/conf.php' : __DIR__ . '/default.conf.php';

$vlc = new \jcisio\Karaoke\Vlc('127.0.0.1', 8080, '1234', array('/media/hd2/Karaoke'));
$items = $vlc->getFileList();
$action = isset($_GET['action']) ? $_GET['action'] : 'list';

switch ($action) {
  case 'list':
    $data = array();
    foreach ($items as $key => $uri) {
      $data[] = array($key, pathinfo(urldecode($uri), PATHINFO_FILENAME));
    }
    die(json_encode(array('data' => $data)));
    break;

  case 'fullscreen':
    $vlc->send('status', array('command' => 'fullscreen'));
    return;

  case 'audio':
    $status = $vlc->send('status');
    foreach ($status->Streams as $s){};return;

  case 'play':
  case 'queue':
    $id = (int) $_GET['id'];
    $command = $action == 'play' ? 'in_play' : 'in_enqueue';
    $vlc->send('status', array(
      'command' => $command,
      'input' => $items[$id],
    ));
    break;
}
