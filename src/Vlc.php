<?php
/**
 * @file
 *
 */

namespace jcisio\VlcRemote;


class Vlc {

  private $host;
  private $port;
  private $password;
  private $paths;

  public function __construct($host, $port, $password, $paths) {
    $this->host = $host;
    $this->port = $port;
    $this->password = $password;
    $this->paths = $paths;
  }

  public function send($action, $args = array()) {
    $url = 'http://' . $this->host . ':' . $this->port . '/requests/' . $action . '.json';
    if ($args) {
      $url .= '?' . http_build_query($args, '', '&', PHP_QUERY_RFC3986);
    }

    $ch = curl_init();
    curl_setopt($ch, CURLOPT_URL, $url);
    curl_setopt($ch, CURLOPT_TIMEOUT, 300);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
    curl_setopt($ch, CURLOPT_HTTPAUTH, CURLAUTH_BASIC);
    curl_setopt($ch, CURLOPT_USERPWD, ':' . $this->password);
    $result = curl_exec($ch);
    curl_close($ch);
    return json_decode($result);
  }

  protected function searchFiles($path) {
    $items = array();
    $result = $this->send('browse', array('dir' => $path));
    foreach ($result->element as $item) {
      if ($item->type == 'file') {
        $items[] = $item->uri;
        continue;
      }

      if ($item->name == '..') {
        continue;
      }

      $items = array_merge($items, $this->searchFiles($item->path));
    }

    return $items;
  }

  public function buildFileList() {
    $filename = 'data/' . $this->host . '.txt';
    if (file_exists($filename)) {
      return $filename;
    }

    $items = array();
    foreach ($this->paths as $path) {
      $items = array_merge($items, $this->searchFiles($path));
    }

    file_put_contents($filename, implode("\n", $items));
    return $filename;
  }

  public function getFileList() {
    $filename = $this->buildFileList();
    $items = explode("\n", file_get_contents($filename));
    return $items;
  }

}
