Набор PHP-скриптов, использовавшихся при проведении конкурса Two Days Game 2.
https://twoweeks.github.io/games-db/?get=two-dg&comp=2

Большинство настроек вынесено в файл _config.php

info.php - "API", на которое со страницы конкурса раз в 3 секунды стучался скрипт и брал инфу
form.php - форма для отправки игр

На версии PHP 7.1 (скорее всего и раньше) присутсвует проблема, при которой если json_encode (form.php:70) принимает объект, где хоть у одного значения строка (написанная не латиницей) больше какой-то определённой длины, json_encode дропнет объект полностью и вернёт пустую строку.
Для решения добавлен флаг JSON_PARTIAL_OUTPUT_ON_ERROR, но тогда просто заместо значения вернётся null, что тоже не очень хорошо.
Потенциальное решение может быть здесь https://stackoverflow.com/q/19361282, но мне не помогло.

Использовались js-библиотеки github.com/github/fetch и github.com/tehcojam/kamina-js, а также Google reCAPTHA v2 (developers.google.com/recaptcha/docs/display).
