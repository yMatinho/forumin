<?php

class MySql {
	private static $pdo;
	public static function conectar() {
		try {
			self::$pdo = new PDO('mysql:host='.HOST.';dbname='.DATABASE, USER, PASSWORD);
			self::$pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);	
		} catch(Exception $e) {
			echo 'Erro ao conectar';
		}
		return self::$pdo;
	}
}

?>