<?php 
require APPPATH . '/third_party/emojione/LoadEmojione.php';
use Emojione\LoadEmojione;

$class = new LoadEmojione();
echo $class->convertImage(':slight_smile:');