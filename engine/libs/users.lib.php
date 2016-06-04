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
    $user = $app['db']->fetchAssoc('select * from `users` where `id` = 1');
    $password = _h($request->get('password') . $user['salt']);

    //Вытаскиваем из БД

    if($user['email'] == $email && $user['password'] == $password){
    	//Авторизован
    	$app['session']->set('user', array('email' => $email));
        return $app->redirect('/admin');
    }else{
    	//Не удалось авторизоваться
    	die("Данные не верны");
    }
    

});


//Восстановление пароля
$app->get('/forget', function() use($app){
   return "hello";
});