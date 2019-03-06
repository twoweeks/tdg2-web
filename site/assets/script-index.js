'use strict'

document.addEventListener('DOMContentLoaded', () => {
	let qs = selector => $make.qs(`[data-content="${selector}"]`)

	let getInfo = () =>
		fetch(`https://example.com/info.php?t=${Date.now()}`)
			.then(response => response.json())
			.then(data => {
				/*
				qs('theme').textContent =
					('theme' in data && data.theme != '')
						? data.theme
						: ''

				qs('theme-description').textContent =
					('theme_description' in data && data.theme_description != '')
						? data.theme_description
						: ''
				*/

				if ('form' in data && data.form != '') {
					qs('form').href = data.form
					qs('form-note').style.display = 'none'
				} else {
					qs('form').href = 'javascript:void(0)'
					qs('form-note').style.display = 'inline'
				}
			})
			.catch(e => console.warn(e))

	getInfo()

	let timer = setInterval(() => { getInfo() }, 3000)
})