<?php
	//error_reporting(0);

	include '_config.php';

	header('Access-Control-Allow-Origin: *');
	header('Content-Type: application/json');

	$info = [
		'theme' => '',
		'theme_description' => '',
		'form' => ''
	];

	if (time() >= $contestTimes['start']) {
		$info['theme'] = $contestMeta['theme'];
		$info['theme_description'] = $contestMeta['theme-description'];

		if (time() >= ($contestTimes['end'] - $contestMeta['timeForm'] * 60 * 60)) {
			$info['form'] = $contestMeta['form'];
		}
	}

	echo json_encode($info, JSON_UNESCAPED_UNICODE);
?>
