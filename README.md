# Introduction 

VLC supports remote control via its web interface. However current tools are not optimized for very large media collection (a few thousands of files). When VLC open a directory with thousands of files, especially on a network mounted partition, it takes a few dozens of seconds and freezes the program.

This tool provides a web interface to build and cache file lists, allows files to be searched and played/queued easily. It was built to use VLC as a karaoke player with very large song list (10,000+ mp4 files) however it can be used for other purpose.

# Installation

## Requirements

- PHP 5.3+ with standard extensions: curl, json.
- A web server

## Configuration

- Open VLC and enable HTTP interface (see [VLC website](https://wiki.videolan.org/Documentation:Modules/http_intf/#VLC_2.0.0_and_later))
- Copy default.conf.php into conf.php 
- Open index.html in a web browser
