<?php
class Site {
	public static function alert($mensagem) {
		echo '<script>alert("'.$mensagem.'")</script>';
	}
	public static function redirect($link) {
		echo '<script>location.href="'.$link.'"</script>';
	}
	public static function generateSlug($str) {
		$str = mb_strtolower($str);
		$str = preg_replace('/(á|à|ã|â)/', 'a', $str);
		$str = preg_replace('/(é|ê)/', 'e', $str);
		$str = preg_replace('/(ó|ô|õ)/', 'o', $str);
		$str = preg_replace('/(í|î)/', 'i', $str);
		$str = preg_replace('/(ú)/', 'u', $str);
		$str = preg_replace('/( )/', '-', $str);
		$str = preg_replace('/(\?|\/|!|_|#)/', '', $str);
		$str = preg_replace('/(ç)/', 'c', $str);
		$str = preg_replace('/(,)/', '-', $str);
		$str = preg_replace('/(-[-]{1,})/', '-', $str);
		$str = strtolower($str);
		return $str;
	}
	public static function logout($redirect) {
		session_destroy();
		self::redirect($redirect);
	}
}
?>