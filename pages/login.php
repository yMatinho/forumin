
<section class="registrar">
	<?php
	if(isset($_GET['logout'])) {
		Site::logout(INCLUDE_PATH.'login');
	}
		if(isset($_SESSION['login'])) {
			?>
			<h2>Você já está logado</h2>
			<a href="<?php echo INCLUDE_PATH; ?>login?logout">Logout</a>
	<?php
		} else {
	?>
	<h2>Login</h2>
	<?php
		if(isset($_POST['acao'])) {
			$usuario = $_POST['usuario'];
			$senha = $_POST['senha'];
			if(empty($_POST['usuario']) || empty($_POST['senha'])) {
				Site::alert('Campos vazios não são permitidos');
			} else {
				$verifica = MySql::conectar()->prepare("SELECT * FROM `tb_forum.usuarios` WHERE usuario = ? AND senha = ?");
				$verifica->execute(array($usuario, $senha));
				if($verifica->rowCount() == 1) {
					$user = $verifica->fetch();
					$_SESSION['usuario'] = $user['usuario'];
					$_SESSION['senha'] = $user['senha'];
					$_SESSION['nome'] = $user['nome'];
					$_SESSION['login'] = uniqid();
					$_SESSION['id'] = $user['id'];
					$_SESSION['cargo'] = $user['cargo'];
					Site::redirect(INCLUDE_PATH);
				} else {
					Site::alert('Usuário ou senha inválido!');
				}

			}
		}
	?>
	<form method="post">
		<div class="form-group">
			<label>Usuario:</label>
			<input type="text" name="usuario">
		</div>
		<div class="form-group">
			<label>Senha:</label>
			<input type="password" name="senha">
		</div>
		<div class="form-group">
			<input type="submit" name="acao" value="Login">
		</div>
	</form>
<?php } ?>
</section>