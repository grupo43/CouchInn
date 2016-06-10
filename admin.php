<?php 
session_start();
if (!isset ($_SESSION['admin'])):
	header("Location: admin_login.php");
else:
	$email = $_SESSION['admin'];
endif;

require_once 'resources/library/functions.php';
$db = connect();
?>

<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="utf-8">
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<!-- The above 3 meta tags *must* come first in the head; any other head content must come *after* these tags -->
	<link rel="icon" href="img/favicon.ico">
	<title>Couch Inn - Admin Dashboard</title>
	<link href="css/bootstrap.min.css" rel="stylesheet">
	<link href="css/dashboard.css" rel="stylesheet">
	<link href="css/style.css" rel="stylesheet">
</head>

<body>
	<!-- NAVBAR -->
	<?php include 'resources/templates/navbar_admin.php'; ?>

	<div class="container-fluid">
		<div class="row">
			<!-- SIDEBAR -->
			<?php include 'resources/templates/sidebar_admin.php'; ?>

			<!-- BODY -->
			<div class="main col-md-10 col-md-offset-2">
				<h1 class="page-header">Panel de control</h1>
				<?php
				//-- DASHBOARD --//
				if (empty ($_GET)):
					include 'resources/templates/dashboard.php';
				endif;

				//-- DATABASE --//
				if (isset ($_GET['database'])):
					include 'resources/templates/database.php';
				endif;

				//-- REPORTS --//
				if (isset ($_GET['reports'])):
					include 'resources/templates/reports.php';
				endif;
				?>
			</div>
		</div>
	</div>

	<script src="resources/library/jquery.min.js"></script>
	<script src="resources/library/bootstrap.min.js"></script>
	<script src="resources/library/functions.js"></script>
	<script src="js/couch-type-abm.js"></script>
	<!-- Just to make our placeholder images work. Remove at production! -->
	<script src="resources/library/holder.min.js"></script>
</body>
</html>
