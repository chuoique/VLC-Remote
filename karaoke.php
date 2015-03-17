<?php

require __DIR__ . '/src/Vlc.php';
$vlc = new \jcisio\Karaoke\Vlc('192.168.1.44', 8080, '1234', array('/media/hd2/Karaoke'));

$items = $vlc->getFileList();

if (isset($_GET['ajax'])) {
  $data = array();
  foreach ($items as $key => $uri) {
    $data[] = array($key, pathinfo(urldecode($uri), PATHINFO_FILENAME));
  }
  die(json_encode(array('data' => $data)));
}
