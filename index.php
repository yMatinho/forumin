<?php
	include('config.php');
	$full_url = @$_GET['url'];
	$url = explode('/', $full_url)
?>
<!DOCTYPE html>
<html>
<head>
	<title>Forumin - Framework para criar fóruns profissionais grátis!</title>
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<link rel="stylesheet" type="text/css" href="<?php echo INCLUDE_PATH; ?>estilo/style.css">
	<link rel="stylesheet" type="text/css" href="<?php echo INCLUDE_PATH; ?>estilo/all.min.css">
	<link rel="stylesheet" type="text/css" href="<?php echo INCLUDE_PATH; ?>estilo/fontawesome.min.css">
	<link href="https://fonts.googleapis.com/css?family=Jost:300,400,500,600,700,800&display=swap" rel="stylesheet">
</head>
<script type="text/javascript" src="<?php echo INCLUDE_PATH; ?>js/jquery.min.js"></script>
<script type="text/javascript" src="<?php echo INCLUDE_PATH; ?>js/menu.js"></script>
<!-- <script type="text/javascript" src="<?php echo INCLUDE_PATH; ?>js/menu.js"></script> -->
<body>
	<header>
		<div class="logo"><h2><i class="fas fa-comments"></i> Forumin</h2></div>
		<nav class="desktop">
			<ul>
				<li><a href="<?php echo INCLUDE_PATH; ?>">Home</a></li>
				<li><a href="<?php echo INCLUDE_PATH; ?>login">Login</a></li>
				<li><a href="<?php echo INCLUDE_PATH; ?>registrar">Registrar</a></li>
				<li><a href="<?php echo INCLUDE_PATH; ?>regras">Regras</a></li>
				<li><a href="<?php echo INCLUDE_PATH; ?>perfil">Perfil</a></li>
			</ul>
		</nav>
		<nav class="mobile">
			<i class="fas fa-bars"></i>
			<ul>
				<li><a href="<?php echo INCLUDE_PATH; ?>">Home</a></li>
				<li><a href="<?php echo INCLUDE_PATH; ?>login">Login</a></li>
				<li><a href="<?php echo INCLUDE_PATH; ?>registrar">Registrar</a></li>
				<li><a href="<?php echo INCLUDE_PATH; ?>regras">Regras</a></li>
				<li><a href="<?php echo INCLUDE_PATH; ?>perfil">Perfil</a></li>
			</ul>
		</nav>
	</header>
	<section class="forum-container">
		<?php
			if(!empty($url[0])) {
				if(isset($url[0])) {
					if(file_exists('pages/'.$url[0].'.php') && $url[0] != 'forum' && $url[0] != 'topico') {
						include('pages/'.$url[0].'.php');
					} else {
						$verifica = MySql::conectar()->prepare("SELECT * FROM `tb_forum.foruns` WHERE slug = ?");
						$verifica->execute(array($url[0]));
						if($verifica->rowCount() == 1) {
							if(isset($url[1])) {
								$verifica = MySql::conectar()->prepare("SELECT * FROM `tb_forum.topicos` WHERE slug = ?");
								$verifica->execute(array($url[1]));
								if($verifica->rowCount() == 1) {
									include('pages/topico.php');
								}
							} else {
								include('pages/forum.php');
							}
						} else {
							die('Não existe o fórum mencionado!');
						}
					}
				}

			} else {
				include('pages/home.php');
			}
		?>
	</section>
	<footer><p>Forumin</p></footer>
</body>
</html>