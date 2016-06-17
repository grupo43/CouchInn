<?php
require_once 'functions.php';
require_once 'paginator.php';

$db = connect();

$page = (isset($_GET['page'])) ? $_GET['page'] : 1;
$sql = '
	SELECT *
	FROM couch
	WHERE enabled = 1
	ORDER BY publication_date DESC
';

$Paginator = new Paginator($db, $sql);
$results = $Paginator->getData($page);

$couches = $results->data;
$couchesHtml = "";
for ($i = 0; $i < count($couches); $i++):
	$couch = $couches[$i];
	if (isPremium($couch['owner'])):
		$sql = "
			SELECT picture1
			FROM couch_picture
			WHERE couch_id = {$couch['id']}
		";
		$mainPicture = $db->query($sql)->fetch_row()[0];
		$img = 'img/couches/'.$mainPicture;
	else:
		$img = 'img/logo/couch.png';
	endif;
	$couchesHtml .= '<div class="couch col-lg-4">';
	$couchesHtml .= '<img class="img-circle" src="' . $img . '" alt="Couch image" width="140" height="140" />'; // Add picture
	$couchesHtml .= '<h3>' . substr($couch['title'], 0, 24) . '..</h3>'; // Couch title
	$couchesHtml .= '<p>' . substr($couch['description'], 0, 90) . '..</p>'; // Description
	$couchesHtml .= '<p><a class="btn btn-default" href="couch.php?id=' . $couch['id'] . '" role="button">Ver detalles &raquo;</a></p>'; // Details button
	$couchesHtml .= '</div>';
endfor;

$arrowsHtml = $Paginator->getArrows();

$return = ["couches" => $couchesHtml, "arrows" => $arrowsHtml];

header('Content-type: application/json; charset=utf-8');
echo json_encode($return);
?>
