<section class="regras">
	<h2>Regras</h2>
	<ul>
		<?php
			$regras = MySql::conectar()->prepare("SELECT * FROM `tb_forum.regras`");
			$regras->execute();
			$regras = $regras->fetchAll();
			foreach ($regras as $key => $value) {
		?>
		<li><?php echo $value['regra']; ?></li>
	<?php } ?>
	</ul>
</section>