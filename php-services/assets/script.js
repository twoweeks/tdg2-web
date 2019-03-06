document.addEventListener('DOMContentLoaded', () => {
	let data = {}

	let storageItemName = 'tdg2-data' // имя переменной для localStorage

	if ($storage.test()) {
		if ($storage.get(storageItemName)) {
			data = JSON.parse($storage.get(storageItemName))
		}

		// значение "уникальной строки" не запоминается специально
		let inputs = $make.qs('input[type=text]:not(#un_string), input[type=url], input[type=email], textarea', ['a'])

		inputs.forEach(input => {
			if (Object.keys(data).includes(input.id)) {
				input.value = data[input.id]
			}

			input.addEventListener('input', () => {
				data[input.id] = input.value
			})

			input.addEventListener('change', () => {
				$storage.set(storageItemName, JSON.stringify(data))
			})
		})
	}

	$make.qs('form').addEventListener('submit', e => {
		e.preventDefault()

		if (grecaptcha.getResponse() == '') {
			$make.qs('p[data-status-text]').textContent = 'Пройдите реКапчу, пожалуйста.'
		} else {
			fetch(document.URL, {
				method: 'POST',
				body: new FormData(e.target)
			})
			.then(response => response.json())
			.then(data => {
				$make.qs('input#un_string').value = ''
				$make.qs('p[data-status-text]').textContent = data.status
				alert(data.status) // алерт для наглядности
				grecaptcha.reset()

				console.log(data)
			})
			.catch(e => console.log(e))
		}
	})
})
