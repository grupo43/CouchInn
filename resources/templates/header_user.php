<nav class="navbar navbar-default navbar-fixed-top">
	<div class="container">
		<div class="navbar-header">
			<a href="/"><img src="img/logo/couchinn_logo_tiny.png" /></a>
		</div>
		<?php
		if (isset($email)):
			include 'resources/templates/navbar_logged_user.php';
		else:
			include 'resources/templates/navbar_user.php';
		endif;
		?>
	</div>
</nav>