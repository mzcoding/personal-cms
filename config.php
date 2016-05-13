<?php

//Проверка версии PHP > 5.3
if (version_compare(phpversion(), '5.3.10', '<')) {
    die("Обновите версию PHP до 5.3 или выше!");
}


/***  Основные настройки **/

$app['debug'] = true; //Дебаг
$app['theme'] = "default"; //Шаблон
$app['language'] = "ru"; //Язык
$app['asset.host'] = 'http://test.loc/';//Полный url