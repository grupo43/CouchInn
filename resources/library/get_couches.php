<?php
require_once 'functions.php';
require_once 'paginator.php';

$db = connect();

$page = (isset($_GET['page'])) ? $_GET['page'] : 1;
$sql =	"SELECT * FROM couch
		ORDER BY publication_date DESC";

$Paginator = new Paginator($db, $sql);
$results = $Paginator->getData($page);

$couches = $results->data;
$couchesHtml = "";
for ($i = 0; $i < count($couches); $i++):
	$couch = $couches[$i];
	if (isPremium($couch['owner'])):
		$img = 'img/couches/'.$couch['picture'];
	else:
		$img = 'img/logo/couch.png';
	endif;
	$couchesHtml .= '<div class="couch col-lg-4"><img class="img-circle" src="'.$img.'" alt="Couch image" width="140" height="140"><h3>'.substr($couch['title'], 0, 24).'..</h3><p>'.substr($couch['description'], 0, 128).'..</p><p><a class="btn btn-default" href="#" role="button">Ver detalles &raquo;</a></p></div>';
endfor;

$arrowsHtml = $Paginator->getArrows();

$result = ["couches" => $couchesHtml, "arrows" => $arrowsHtml];

header('Content-type: application/json; charset=utf-8');
echo json_encode($result);
?>
