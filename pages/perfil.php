<section class="registrar">
	<?php
		if(!isset($_SESSION['login'])) {
			die('<h2>Você precisa estar logado para continuar</h2>');
		}
	?>
	<h2>Editar Perfil</h2>
	<?php
		if(isset($_POST['acao'])) {
			if(empty($_POST['nome']) || empty($_POST['senha'])) {
				Site::alert('Campos vazios não são permitidos!');
			} else {
				if($_POST['senha'] ==  $_POST['confirmar_senha']) {
					$sql = MySql::conectar()->prepare("UPDATE `tb_forum.usuarios` SET nome = ?, senha = ? WHERE id = ?");
					$sql->execute(array($_POST['nome'], $_POST['senha'], $_SESSION['id']));
					$_SESSION['nome'] = $_POST['nome'];
					$_SESSION['senha'] = $_POST['senha'];
				}
			}
		}
	?>
	<form method="post">
		<div class="form-group">
			<label>Nome:</label>
			<input type="text" name="nome" value="<?php echo $_SESSION['nome']?>">
		</div>
		<div class="form-group">
			<label>Senha:</label>
			<input type="password" name="senha" value="<?php echo $_SESSION['senha']; ?>">
		</div>
		<div class="form-group">
			<label>Confirmar Senha:</label>
			<input type="password" name="confirmar_senha" value="<?php echo $_SESSION['senha']; ?>">
		</div>
		<div class="form-group">
			<input type="submit" name="acao" value="Atualizar">
		</div>
	</form>
</section>