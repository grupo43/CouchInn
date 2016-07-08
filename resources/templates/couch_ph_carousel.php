<div id="couchPhCarousel" class="carousel slide" data-ride="carousel">
	<ol class="carousel-indicators">
		<?php foreach ($pictures as $index => $picture): ?>
			<li <?php if ($index == 0): echo 'class="active"'; endif; ?> data-target="#couchPhCarousel" data-slide-to="<?php echo $index ?>"></li>
		<?php endforeach; ?>
	</ol>
	<div class="container">
		<div class="carousel-caption">
			<h1><?php echo $couch['title'] ?></h1>
			<input id="couch-score" type="number" class="rating" value="<?php echo $couchScore ?>">
			<br />
			<?php if (isset($_SESSION['user']) && $_SESSION['user'] != $couch['owner']): ?>
				<p><a class="btn btn-lg btn-primary" href="#" data-toggle="modal" data-target="#book-couch-modal">Reservar couch</a></p>
			<?php endif; ?>
		</div>
	</div>
	<div class="carousel-inner" role="listbox">
		<?php foreach ($pictures as $index => $picture): ?>
			<div class="cover-image item<?php if ($index == 0): echo ' active'; endif; ?>" style="background-image:url(<?php echo $picture ?>)">
			</div>
		<?php endforeach; ?>
	</div>
	<a class="left carousel-control" href="#couchPhCarousel" role="button" data-slide="prev">
		<span class="glyphicon glyphicon-chevron-left" aria-hidden="true"></span>
	</a>
	<a class="right carousel-control" href="#couchPhCarousel" role="button" data-slide="next">
		<span class="glyphicon glyphicon-chevron-right" aria-hidden="true"></span>
	</a>
</div>
