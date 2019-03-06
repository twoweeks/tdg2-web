<?php
	include '_config.php';

	$statusString = '';

	if ($_SERVER['REQUEST_METHOD'] == 'POST' && count($_POST) > 0) {
		header('Content-Type: application/json; charset=UTF-8');

		if (time() <= $contestTimes['end']) {
			$captchaCondition = false;

			if (isset($_POST['g-recaptcha-response']) && !isset($_GET[$contestConfig['no-captcha-query']])) {
				$recaptchaResponse = file_get_contents(
					'https://www.google.com/recaptcha/api/siteverify?secret='
						. $recaptcha['secret']
						. '&response=' . $_POST['g-recaptcha-response']
						//. '&remoteip=' . $_SERVER['REMOTE_ADDR']
				);

				$recaptchaResponseData = json_decode($recaptchaResponse);

				if (
					$recaptchaResponseData->success == true &&
					$recaptchaResponseData->hostname == $_SERVER['SERVER_NAME']
				) {
					$statusString = 'реКапча пройдена';
					$captchaCondition = true;
				} else {
					$statusString = 'реКапча не пройдена!';
				}
			} else if (isset($_GET[$contestConfig['no-captcha-query']])) {
				$captchaCondition = true;
			}

			if (
				$captchaCondition == true &&
				isset($_POST['title'])            && !empty($_POST['title'])            && strval($_POST['title']) &&
				isset($_POST['description'])      && !empty($_POST['description'])      && strval($_POST['description']) &&
				isset($_POST['screenshot_link'])  && !empty($_POST['screenshot_link'])  && strval($_POST['screenshot_link']) &&
				isset($_POST['game_link'])        && !empty($_POST['game_link'])        && strval($_POST['game_link']) &&
				isset($_POST['email'])            && !empty($_POST['email'])            && strval($_POST['email']) &&
				isset($_POST['un_string'])        && !empty($_POST['un_string'])        && strval($_POST['un_string']) &&
				isset($_POST['rules'])
			) {
				$_crudeInfo = [
					'title' =>            substr(strval($_POST['title']), 0, 150),
					'genre' =>            substr(strval($_POST['genre']), 0, 150),
					'description' =>      substr(strval($_POST['description']), 0, 280),
					'screenshot_link' =>  substr(strval($_POST['screenshot_link']), 0, 100),
					'game_link' =>        substr(strval($_POST['game_link']), 0, 100),
					'email' =>            substr(strval($_POST['email']), 0, 50),
					'un_string' =>        substr(strval($_POST['un_string']), 0, 50)
				];

				$_gameID = md5($_crudeInfo['email'] . '+' . $_crudeInfo['un_string'] . '+tdg2');

				$_info = [
					'title' =>			  $_crudeInfo['title'],
					'genre' =>			  $_crudeInfo['genre'],
					'description' =>	  $_crudeInfo['description'],
					'screenshot_link' =>  $_crudeInfo['screenshot_link'],
					'game_link' =>		  $_crudeInfo['game_link'],
					'email' =>			  $_crudeInfo['email']
				];

				file_put_contents(
					$contestConfig['json-path'] . '/' . $_gameID . '.json'
					json_encode($_info, JSON_UNESCAPED_UNICODE | JSON_PARTIAL_OUTPUT_ON_ERROR)
				);

				$statusString .= '; Игра успешно отправлена.';
			} else {
				$statusString .= $captchaCondition ? '; При отправке игры где-то возникла ошибка, попробуйте ещё раз.' : '';
			}
		} else {
			$statusString .= 'Вы, к сожалению, опоздали. Но, возможно, организатор ещё может принять вашу игру по почте в течение пары часов после окончания конкурса.';
		}

		echo json_encode([
			'status' => $statusString,
			//'rc' => $recaptchaResponseData
		], JSON_UNESCAPED_UNICODE);

		exit();
	}

	//header('Content-Type: text/html; charset=UTF-8');
?>
<!DOCTYPE HTML>
<html lang="ru"><head>
	<meta charset="utf-8">
	<title>Отправка игры на TDG2</title>

	<link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Ubuntu:400,500&subset=cyrillic-ext">
	<link rel="stylesheet" href="./assets/style.css">

	<?php if (!isset($_GET[$contestConfig['no-captcha-query']])) { echo '<script src="https://www.google.com/recaptcha/api.js" async defer>'; } else { echo '<script>var grecaptcha = { getResponse: () => 123, reset: () => 456 }'; } echo '</script>'; ?>
</head><body>
	<header>
		<h1>Отправка игры на TDG2</h1>
	</header>

	<main>
		<form action="" method="post" accept-charset="UTF-8">
			<table>
				<tr>
					<td><label for="title">Название</label><br><span class="label-des">(макс. 150 символов)</span></td>
					<td><input id="title" name="title" type="text" maxlength="150" required></td>
				</tr>
				<tr>
					<td><label for="genre">Жанр</label><br><span class="label-des">Необязательно<br>(макс. 150 символов)</span></td>
					<td><input id="genre" name="genre" type="text" maxlength="150"></td>
				</tr>
				<tr>
					<td><label for="description">Описание</label><br><span class="label-des">Краткий сюжет, про что она<br>(макс. 280 символов)</span></td>
					<td><textarea id="description" name="description" maxlength="280" required></textarea></td>
				</tr>
				<tr>
					<td><label for="screenshot_link">Ссылка на скриншот</label><br><span class="label-des">(макс. 100 символов)</span></td>
					<td><input id="screenshot_link" name="screenshot_link" type="url" pattern="https://.*" maxlength="100" required><br><span class="label-des">Нужно дать <b>прямую ссылку</b> на картинку. Загружать желательно на imgur.com или mixtape.moe и подобные хостинги.</span></td>
				</tr>
				<tr>
					<td><label for="game_link">Ссылка на архив с игрой</label><br><span class="label-des">(макс. 100 символов)</span></td>
					<td><input id="game_link" name="game_link" type="url" pattern="https://.*" maxlength="100" required><br><span class="label-des">Загружать желательно на Яндекс.Диск, Google Drive, itch.io, mixtape.moe и подобные хостинги.</span></td>
				</tr>
				<tr>
					<td><label for="email">Почта для связи</label><br><span class="label-des">(макс. 50 символов)</span></td>
					<td><input id="email" name="email" type="email" maxlength="50" required></td>
				</tr>
				<tr>
					<td><label for="un_string">Уникальное слово</label><br><span class="label-des">(макс. 50 символов)</span></td>
					<td><input id="un_string" name="un_string" type="text" maxlength="50" required><br><span class="label-des">В случае чего, вы можете <q>отредактировать</q> игру, если введёте те же уникальное слово и почту, что и в прошлый раз.</span></td>
				</tr>
				<tr>
					<td colspan="2" style="text-align: center">
						<p><input type="checkbox" id="rules" name="rules" required> <label for="rules">Я ознакомлен с <a href="https://gdjams.ru/tdg2/#rules" target="_blank">правилами</a> и точно-точно всё проверил перед отправкой игры</label></p>
					</td>
				</tr>
				<tr>
					<td colspan="2" style="text-align: center">
						<div class="g-recaptcha" data-sitekey="<?=$recaptcha['site']?>"></div>
					</td>
				</tr>
				<tr>
					<td colspan="2" style="text-align: center">
						<button type="submit" id="submit" class="btn">Отправить!</button>
					</td>
				</tr>
				<tr>
					<td colspan="2" style="text-align: center"><p data-status-text></p></td>
				</tr>
			</table>
		</form>
	</main>

	<script src="https://cdn.jsdelivr.net/npm/whatwg-fetch@2.0.4/fetch.min.js" defer></script>
	<script src="https://cdn.jsdelivr.net/npm/kamina-js@1.3.1/dist/kamina.min.js" defer></script>

	<script src="./assets/script.js?3" defer></script>
</body></html>
