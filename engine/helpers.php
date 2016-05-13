<?php
function _lang($lang){
  global $conf, $app;
  return $app['translator']->trans($lang);

}