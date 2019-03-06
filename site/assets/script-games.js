'use strict'

// а что вы делаете в моём холодильнике?

document.addEventListener('DOMContentLoaded', () => {
	let container = $make.qs('.games-container')
	
	const GAMES = [
		{
			title: 'Путешествие на Hardbass',
			genre: 'Сrawling',
			description: 'Время выдвигаться на пати',
			screenshot_link: './assets/screenshots/hardbass.jpg',
			game_link: 'https://yadi.sk/d/sMK7wDKZ3YyXJi'
		}, {
			title: 'CrazyBubbles',
			genre: 'Головоломка, пазл, аркада',
			description: 'Сумасшедшие пузырьки вырываются наружу и творят непристойности. Игроку предстоит ловить их в центральную воронку из раза в раз, набивая очки, но с каждым уровнем это сделать сложнее.',
			screenshot_link: './assets/screenshots/crazybubbles.jpg',
			game_link: 'https://yadi.sk/d/R9B1ri_s3YyXHv'
		}, {
			title: 'SamoZbor 2: The Fall of Dimasik',
			genre: 'Puzzle',
			description: 'Если оно заполнится до краёв, то проломится дно. Выдержит ли Димасик?',
			screenshot_link: './assets/screenshots/samozbor2.jpg',
			game_link: 'https://yadi.sk/d/sJgM-5Jf3YyXKg'
		}, {
			title: 'Lust for cows',
			description: 'Михаил долгие годы поднимал собственное хозяйство на окраине. Небольшое стадо коров - его гордость. Сегодня к нему приедут репортеры главного журнала о разведении коров из райцентра, чтобы рассказать историю о нем и его невероятной дородной телочке - Марьке. Что же можнет пойти не так?',
			screenshot_link: './assets/screenshots/lust-for-cows.png',
			game_link: 'https://yadi.sk/d/KkSy6XKU3YyXLF'
		}, {
			title: 'Бизысходнацть',
			genre: 'Кликер',
			description: 'Волны жизни смывают твои потуги донести до человечества свои боль и страдания. Просто кликай или нажимай клавиатуру букв слова внизу экрана.',
			screenshot_link: './assets/screenshots/despair.png',
			game_link: 'https://yadi.sk/d/B5B8aWXE3YyXHG'
		}, {
			title: 'The Heater',
			description: 'Прыгаешь по платформам, пытаешься не умереть от холода, собираешь мусор, но рано или поздно всё равно умираешь',
			screenshot_link: './assets/screenshots/the-heater.png',
			game_link: 'https://yadi.sk/d/477j-EpT3YyXLt'
		}, {
			title: 'TDG BOY',
			genre: 'Симулятор платформера',
			description: '1993 год. Молодой программист создаёт игру на портативное игровое устройство TDG BOY, но так-как он ужасный геймдизайнер игру невозможно пройти. Вам предстоит стать тестером и из-за кучи багов, которые наделал недалекий программист, постоянно начинать все сначала.',
			screenshot_link: './assets/screenshots/tdg-boy.png',
			game_link: 'https://yadi.sk/d/WfPsP8aX3Yz3so'
		}, {
			title: 'The witch and her cat',
			description: 'Юная ведьма потеряла кота, чтобы его вернуть, нужно выполнить некоторые действия в правильной последовательности, иначе начинаете все сначала.',
			screenshot_link: './assets/screenshots/the-witch-and-her-cat.png',
			game_link: 'https://yadi.sk/d/oddpuiFJ3Yz3sA'
		}, {
			title: 'RAGEQUIT',
			genre: 'Адвенчура с попыткой в хардкорность.',
			description: 'Юная археолог наконец нашла древний храм и пытается пробраться к свитку истины.',
			screenshot_link: './assets/screenshots/ragequit.png',
			game_link: 'https://yadi.sk/d/aCFwqJTV3Yz38t'
		}, {
			title: 'TankEscape',
			description: 'Суть игры - пройти до конца. В процессе будут встречаться какие-то препятствия и ловушки, из-за которых можно будет потерять все жизни - и придётся начинать сначала. Но можно пройти и сразу первой попытки всё, не зная даже что будет впереди. ',
			screenshot_link: './assets/screenshots/tankescape.png',
			game_link: 'https://yadi.sk/d/4GiI1Flg3Yz3rM'
		}, {
			title: 'Heartworm',
			description: '"Прочь! Убирайся откуда пришел!" — кричали они, зловеще сотрясая в воздухе мачеты и косы. Еще бы, все знают что человек с червем в сердце принесёт горе в деревню. Тот, на ком лежит проклятье, будет гоним отовсюду. Остается одно — последовать по пути древнего героя, который по легенде обрел исцеление, отправившись в Опустевшие Залы...',
			screenshot_link: './assets/screenshots/heartworm.png',
			game_link: 'https://yadi.sk/d/AWkvISEa3Yz37v'
		}
	]

	container.textContent = ''

	GAMES.forEach(game => {
		let gameBlock = $create.elem('div', '', 'game _whitebg')

		let gameBlockPicture = $create.elem('picture', '', 'game__picture')

		// пикча

		let _picture = $create.elem('img')
			_picture.src = game.screenshot_link

		gameBlockPicture.appendChild(_picture)

		let gameBlockInfo = $create.elem('div', '', 'game__info')

		// название игры

		let _infoTitle = $create.elem('h3', game.title, 'game__info--title')
		gameBlockInfo.appendChild(_infoTitle)

		// жанр

		if ('genre' in game && game.genre != '') {
			let _infoGenre = $create.elem('p', game.genre, 'game__info--genre')
			gameBlockInfo.appendChild(_infoGenre)
		}

		// описание

		let _infoDescription = $create.elem('p', ('description' in game && game.description != '') ? game.description : 'Описания нет.', 'game__info--description')
		gameBlockInfo.appendChild(_infoDescription)

		// ссылка на загрузку

		let _infoLink = $create.elem('a', '<span>скачать</span>', 'game__info--link')
			_infoLink.href = game.game_link

		gameBlockInfo.appendChild(_infoLink)

		gameBlock.appendChild(gameBlockPicture)
		gameBlock.appendChild(gameBlockInfo)

		container.appendChild(gameBlock)
	})
})