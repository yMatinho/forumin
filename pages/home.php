<div class="center">
	<?php
		if(isset($_GET['deletar-forum'])) {
			$sql = MySql::conectar()->prepare("DELETE FROM `tb_forum.foruns` WHERE id = ?");
			$sql->execute(array($_GET['deletar-forum']));
			$sql = MySql::conectar()->prepare("DELETE FROM `tb_forum.topicos` WHERE forum_id = ?");
			$sql->execute(array($_GET['deletar-forum']));
			$sql = MySql::conectar()->prepare("DELETE FROM `tb_forum.posts` WHERE forum_id = ?");
			$sql->execute(array($_GET['deletar-forum']));
		}
		if(isset($_GET['deletar-secao'])) {
			$sql = MySql::conectar()->prepare("DELETE FROM `tb_forum.secoes` WHERE id = ?");
			$sql->execute(array($_GET['deletar-secao']));
		}
		if(isset($_POST['acao_secao'])) {
			if(empty($_POST['nome'])) {
				Site::alert('Campos vazios não são permitidos!');
			} else {
				$sql = MySql::conectar()->prepare("INSERT INTO `tb_forum.secoes` VALUES(null,?,?)");
				$sql->execute(array($_POST['nome'], Site::generateSlug($_POST['nome'])));
			}
		}
		if(isset($_POST['acao_forum'])) {
			if(empty($_POST['nome']) || empty($_POST['descricao']) || empty($_POST['icone'])) {
				Site::alert('Campos vazios não são permitidos!');
			} else {
				$sql = MySql::conectar()->prepare("INSERT INTO `tb_forum.foruns` VALUES(null,?,?,?,?,?)");
				$sql->execute(array($_POST['secao'], $_POST['nome'], $_POST['descricao'], Site::generateSlug($_POST['nome']), $_POST['icone']));
			}
		}
	?>
	<?php
		if(isset($_SESSION['login']) && @$_SESSION['cargo'] >= 2) {
	?>
	<section class="registrar">
		<form method="post">
			<div class="form-group">
				<label>Nome da seção</label>
				<input type="text" name="nome">
			</div>
			<div class="form-group">
				<input type="submit" name="acao_secao" value="Criar Seção">
			</div>
		</form>
		<form method="post">
			<div class="form-group">
				<label>Nome do fórum</label>
				<input type="text" name="nome">
			</div>
			<div class="form-group">
				<label>Descrição</label>
				<textarea name="descricao"></textarea>
			</div>
			<div class="form-group">
				<label>Icone</label>
				<input type="text" name="icone">
			</div>
			<div class="form-group">
				<label>Seção</label>
				<select name="secao">
					<?php
						$secoes = MySql::conectar()->prepare("SELECT * FROM `tb_forum.secoes`");
						$secoes->execute();
						$secoes = $secoes->fetchAll();
						foreach ($secoes as $key => $value) {
					?>
					<option value="<?php echo $value['id']; ?>"><?php echo $value['nome']; ?></option>
				<?php } ?>
				</select>
			</div>
			<div class="form-group">
				<input type="submit" name="acao_forum" value="Criar fórum">
			</div>
		</form>
	</section>
<?php } ?>
		<?php
			$secoes = MySql::conectar()->prepare("SELECT * FROM `tb_forum.secoes`");
			$secoes->execute();
			$secoes = $secoes->fetchAll();
			foreach ($secoes as $key => $value) {
		?>
		<div class="secao">
			<h2><?php echo $value['nome']; ?></h2>
			<?php
				if(@$_SESSION['cargo'] >= 2) {
			?>
			<a href="<?php echo INCLUDE_PATH; ?>?deletar-secao=<?php echo $value['id']; ?>">Deletar Seção</a>
		<?php } ?>
			<?php
				$foruns = MySql::conectar()->prepare("SELECT * FROM `tb_forum.foruns` WHERE secao_id = ?");
				$foruns->execute(array($value['id']));
				$foruns = $foruns->fetchAll();
				foreach ($foruns as $key => $value_forum) {
			?>
			<div class="forum-single">
				<div class="avatar left">
					<i class="<?php echo $value_forum['icone']; ?>"></i>
				</div>
				<div class="content left">
					<h2><a href="<?php echo INCLUDE_PATH.$value_forum['slug']; ?>"><?php echo $value_forum['titulo']; ?></a></h2>
					<p><?php echo substr($value_forum['descricao'], 0, 100).'...'; ?></p>
				</div>
				<div class="info left">
					<?php
						$info = array();
						$sql = MySql::conectar()->prepare("SELECT * FROM `tb_forum.posts` WHERE forum_id = ? ORDER BY data DESC LIMIT 1");
						$sql->execute(array($value_forum['id']));
						$info['ultimo_post'] = $sql->rowCount() != 1 ? 'Nenhum post ainda' : $sql->fetch()['autor'];
						$sql = MySql::conectar()->prepare("SELECT * FROM `tb_forum.posts` WHERE forum_id = ?");
						$sql->execute(array($value_forum['id']));
						$info['posts'] = $sql->rowCount();
						$sql = MySql::conectar()->prepare("SELECT * FROM `tb_forum.topicos` WHERE forum_id = ?");
						$sql->execute(array($value_forum['id']));
						$info['topicos'] = $sql->rowCount();
					?>
					<p><i class="fas fa-user-tie"></i> Ultimo Post por: <?php echo $info['ultimo_post']; ?></p>
					<p><i class="fas fa-newspaper"></i> Posts: <?php echo $info['posts'] ?></p>
					<p><i class="fas fa-newspaper"></i> Tópicos: <?php echo $info['topicos']; ?></p>
					<?php
						if(@$_SESSION['cargo'] >= 2) {
					?>
					<a href="<?php echo INCLUDE_PATH; ?>?deletar-forum=<?php echo $value_forum['id']; ?>">Deletar</a>
				<?php } ?>
				</div>
				<div class="clear"></div>
			</div>
			<div class="clear"></div>
		<?php } ?>
		</div>
	<?php } ?>
	</div>