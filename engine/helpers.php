<?php
function _lang($lang){
  global $conf, $app;
  return $app['translator']->trans($lang);

}
function _h($data, $salt){
	return hash('sha256', $data . $salt);
}