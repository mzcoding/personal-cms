<?php
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

//Авторизация
$app->get('/{_locale}/login', function () use ($app) {
	 $title = _lang('login');

     return $app['twig']->render('login.twig', array(
        'title' => $title,
        'loc' => $app['language']
    ));
});
$app->post('/{_locale}/login', function(Request $request) use ($app){
    $email = strip_tags($request->get('email'));
    $password = md5($request->get('password'));

    print_r($email);
    die;
});
//Восстановление пароля
$app->get('/forget', function() use($app){
   return "hello";
});