<?php
namespace Emojione;
require APPPATH . '/third_party/emojione/vendor/autoload.php';

class LoadEmojione {
	public function convertImage($textEmoji) {
		$client = new Client(new Ruleset());
		$client->imagePathPNG = 'https://cdnjs.cloudflare.com/ajax/libs/emojione/2.1.4/assets/png/'; // defaults to jsdelivr's free CDN

		return $client->toImage($textEmoji);
	}
}