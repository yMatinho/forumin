<section class="registrar">
	<h2>Registrar</h2>
	<?php
		if(isset($_POST['acao'])) {
			$usuario = $_POST['usuario'];
			$senha = $_POST['senha'];
			$confirmar_senha = $_POST['confirmar_senha'];
			$nome = $_POST['nome'];

			if(preg_match('/[a-z0-9]+/', $usuario)) {

			if(!empty($usuario) && !empty($senha) && !empty($nome)) {
				$verifica = MySql::conectar()->prepare("SELECT * FROM `tb_forum.usuarios` WHERE usuario = ?");
				$verifica->execute(array($usuario));
				if($verifica->rowCount() == 1) {
					Site::alert('Esse usuário já existe!');
				} else {
					if($senha == $confirmar_senha) {
					$sql = MySql::conectar()->prepare("INSERT INTO `tb_forum.usuarios` VALUES(null,?,?,?,?)");
					$sql->execute(array($usuario, $senha, $nome,0));
					Site::alert('Registrado com sucesso!');
					Site::redirect(INCLUDE_PATH.'login');
				}
			} 
			} else {
				Site::alert('Campos vazios não são permitidos!');

			}
		} else {
			Site::alert('Usuário inválido!');
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
			<label>Confirmar Senha:</label>
			<input type="text" name="confirmar_senha">
		</div>
		<div class="form-group">
			<label>Nome:</label>
			<input type="text" name="nome">
		</div>
		<div class="form-group">
			<input type="submit" name="acao" value="Registrar">
		</div>
	</form>
</section>