<?php
/** Панелька админа*/
 $app->get('/admin', function(){
   if($app['session']->has('user')){
        
   }

   return $app->redirect('/error404');
 });