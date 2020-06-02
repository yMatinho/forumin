<?php
	$slug = $url[0];
	$forum = MySql::conectar()->prepare("SELECT * FROM `tb_forum.foruns` WHERE slug = ?");
	$forum->execute(array($slug));
	$forum = $forum->fetch();

	if(isset($_POST['acao'])) {
		if(empty($_POST['nome'])) {
			Site::alert('Campos vazios não são permitidos!');
		} else {
			$sql = MySql::conectar()->prepare("INSERT INTO `tb_forum.topicos` VALUES(null,?,?,?,?,?)");
			$sql->execute(array($forum['id'], $_POST['nome'], Site::generateSlug($_POST['nome']), $_SESSION['usuario'], date('Y-m-d H:i:s')));
			Site::redirect(INCLUDE_PATH.$slug.'/'.Site::generateSlug($_POST['nome']));
		}
	}
?>
<section class="registrar">
	<h2>Criar tópico</h2>
	<form method="post">
		<div class="form-group">
			<label>Nome:</label>
			<input type="text" name="nome">
		</div>
		<div class="form-group">
			<input type="submit" name="acao" value="Criar tópico">
		</div>
	</form>
</section>
<div class="forum-info">
	<h2><?php echo $forum['titulo'] ?></h2>
	<div class="topico-container">
		<?php
			$topicos = MySql::conectar()->prepare("SELECT * FROM `tb_forum.topicos` WHERE forum_id = ? ORDER BY data DESC");
			$topicos->execute(array($forum['id']));
			$topicos = $topicos->fetchAll();
			foreach ($topicos as $key => $value) {
				$ultimo_post = MySql::conectar()->prepare("SELECT * FROM `tb_forum.posts` WHERE topico_id = ? ORDER BY data DESC LIMIT 1");
				$ultimo_post->execute(array($value['id']));
				$ultimo_post = $ultimo_post->rowCount() == 1 ? $ultimo_post->fetch() : 'Nenhum post ainda';
				$posts = MySql::conectar()->prepare("SELECT * FROM `tb_forum.posts` WHERE topico_id = ?");
				$posts->execute(array($value['id']));
				$posts = $posts->rowCount();
		?>
		<div class="topico-single">
			<h2 class="left"><a href="<?php echo INCLUDE_PATH.$forum['slug'].'/'.$value['slug']; ?>"><?php echo $value['titulo'] ?> - <autor><?php echo $value['autor']; ?></autor></a></h2>
			<div class="info right">
				<p><i class="fas fa-newspaper"></i> Fórum: <?php echo $forum['titulo']; ?></p>
				<p><i class="fas fa-user-tie"></i> Último Post por: : <?php echo $ultimo_post['autor']; ?></p>
				<p><i class="fas fa-newspaper"></i> Posts: <?php echo $posts; ?></p>
			</div>
			<div class="clear"></div>
			<p><?php echo date('d/m/Y H:i:s',strtotime($value['data'])); ?></p>
		</div>
	<?php } ?>
	</div>
</div>