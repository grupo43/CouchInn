<?php
$sql = "
	SELECT id, title, description
	FROM couch
	WHERE owner = '{$_SESSION['user']}'
";
$couches = $db->query($sql);

?>
<h1 class="page-header">Mis Couches</h1>
<br />
<?php
if ($couches->num_rows):
	foreach ($couches as $index => $couch):
		$sql = "
			SELECT picture1
			FROM couch_picture
			WHERE couch_id = {$couch['id']}
		";
		$img = $db->query($sql)->fetch_row()[0]; ?>
		<?php if (($index) % 3 == 0): ?>
		<div class="row">
		<?php endif; ?>
			<div class="col-md-4 text-center">
				<img class="couch img-circle center-block" src="<?php echo $img ?>" alt="Couch image" width="160" height="160" />
				<h3><?php echo substr($couch['title'], 0, 24) ?> ..</h3>
				<p><?php echo substr($couch['description'], 0, 80) ?> ..</p>
				<p><a class="btn btn-primary" href="couch?id=<?php echo $couch['id'] ?>" role="button">Ver detalles &raquo;</a></p>
			</div>
		<?php if (($index + 1) % 3 == 0): ?>
		</div>
		<br />
		<?php endif;
	endforeach;
else: ?>
	<div class="col-md-6">
		<div class="alert alert-info text-center">Aún no has publicado ningún couch, <a href="javascript:void(0)" data-toggle="modal" data-target="#add-couch-modal">¿qué estás esperando?</a></div>
	</div>
<?php endif; ?>
