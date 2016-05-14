<?php
function _lang($lang){
  global $conf, $app;
  return $app['translator']->trans($lang);

}
_h($data){
	$salt = '12345';
	return hash('sha256', $data . $salt);
}