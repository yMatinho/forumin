<?php
	$topico = MySql::conectar()->prepare("SELECT * FROM `tb_forum.topicos` WHERE slug = ?");
	$topico->execute(array($url[1]));
	$topico = $topico->fetch();
	$forum = MySql::conectar()->prepare("SELECT * FROM `tb_forum.foruns` WHERE slug = ?");
	$forum->execute(array($url[0]));
	$forum = $forum->fetch();

	if(isset($_POST['acao'])) {
		if(isset($_SESSION['login'])) {
			if(!empty($_POST['post'])) {
				$sql = MySql::conectar()->prepare("INSERT INTO `tb_forum.posts` VALUES(null,?,?,?,?,?)");
				$sql->execute(array($topico['id'], $forum['id'], $_POST['post'], $_SESSION['usuario'], date("Y-m-d H:i:s")));
			} else {
				echo 'Campos vazios não são permitidos!';
			}
		} else {
			Site::alert('Precisa estar logado para postar!');
		}
	}
?>
<div class="cadastrar-post">
	<form method="post">
		<div class="form-group">
			<label>Post:</label>
			<textarea name="post"></textarea>
		</div>
		<div class="form-group">
			<input type="submit" name="acao" value="Postar">
		</div>
	</form>
</div>
<div class="title-card">
	<h2>Posts de <?php echo $topico['titulo']; ?></h2>
</div>
<?php
	$posts = MySql::conectar()->prepare("SELECT * FROM `tb_forum.posts` WHERE topico_id = ? ORDER BY data ASC");
	$posts->execute(array($topico['id']));
	$posts = $posts->fetchAll();
	foreach ($posts as $key => $value) {
?>
<div class="post-single">
	<div class="user left">
		<i class="fas fa-user"></i>
		<p><?php echo $value['autor']; ?></p>
		<p><?php echo date('d/m/Y H:i:s',strtotime($value['data'])); ?></p>
	</div>
	<div class="content left">
		<p><?php echo $value['conteudo']; ?></p>
	</div>
	<div class="clear"></div>
</div>
<?php } ?>