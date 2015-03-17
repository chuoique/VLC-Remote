<?php
//vlc-client configuration
$cfg['player_host'] = "192.168.1.44";
$cfg['player_port'] = "8080";
$cfg['player_pass'] = "1234";

//echo("<pre>" . vlc("pl_pause") . "</pre>");
echo vlc('');
function vlc($command) {
    global $cfg;
    $request  = 'GET /requests/status.xml?command=' . $command . ' HTTP/1.1' . "\r\n";
    $request .= 'Host: ' . $cfg['player_host'] . ':' . $cfg['player_port'] . "\r\n";
    $request .= 'Connection: Close' . "\r\n";
    $request .= 'Authorization: Basic ' . base64_encode(':' . $cfg['player_pass']) . "\r\n\r\n";
    
    $soket = @fsockopen($cfg['player_host'], $cfg['player_port'], $error_no, $error_string, 1) or die();
    @fwrite($soket, $request) or die();
    $content = stream_get_contents($soket);
    fclose($soket);
	
    $temp = explode("\r\n\r\n", $content, 2);
    if (isset($temp[1])) {
        $header = $temp[0];
        $content = $temp[1];
    }
    
    return $content;
}

