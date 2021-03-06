<?php
$app = new Silex\Application();
require __DIR__ . '/helpers.php'; //Хелперы
require_once __DIR__.'/../config.php';
/** Регистраторы */
//Инициализация твига
$app->register(new Silex\Provider\TwigServiceProvider(), array(
    'twig.path' => __DIR__.'/../templates/' . $app['theme'],
));
//Языковые параметры
$app->register(new Silex\Provider\LocaleServiceProvider());
$app->register(new Silex\Provider\TranslationServiceProvider(), array(
    'locale_fallbacks' => array($app['language']),
    'translator.domains' => array(
       'messages' => array(
           'en' => include('lang/en/messages.lang.php'),
           'ru' => include('lang/ru/messages.lang.php'),
       	),
    'translator.message_selector' => array(
        'messages' =>  array(
           'en' => include('lang/en/messages.lang.php'),
           'ru' => include('lang/ru/messages.lang.php'),
       	),
    ),   
    )
));
//Сессии
$app->register(new Silex\Provider\SessionServiceProvider());
//БД
$app->register(new Silex\Provider\DoctrineServiceProvider(), array(
    'db.options' => array(
        'driver'   => 'pdo_mysql',
        'host'     => $app['host'], 
        'dbname'   => $app['dbname'],
        'user'     => $app['dbuser'],
        'password' => $app['dbpassword'],
        'charset'  => 'utf8',
        'port'     => 3306, 
    ),
));




/** Роуты */
$app->get('/', function(){
   return "Hello World";
});

require __DIR__ . '/libs/users.lib.php';

$app->run();