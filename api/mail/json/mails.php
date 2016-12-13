<?php
require_once("../../../conf.php");

require_once(LIB_PATH . "/resume/view/json/jsonMailView.class.php");
require_once(LIB_PATH . "/resume/data/json/mailJsonProvider.class.php");

$provider = new ProgramXmlProvider(PROGRAM_JSON_FILE, null);
		
if (array_key_exists("id", $_REQUEST)) {
	$id = $_REQUEST["id"];
	$item = $provider->getById($id);
	$view = new JsonProgramView($item);
	header('Content-type: application/json; charset=utf-8');
	echo $view->getContent();
	exit();
}

if (!array_key_exists("offset", $_REQUEST) && !array_key_exists("limit", $_REQUEST)) {
	$data = $provider->getAll();
	$view = new JsonProgramsView($data, sizeof($data));
	header('Content-type: application/json; charset=utf-8');
	echo $view->getContent();
	exit();
}
		
if (!array_key_exists("offset", $_REQUEST) || (array_key_exists("offset", $_REQUEST) && $_REQUEST["offset"] == "")) $offset = null; else $offset = (int)$_REQUEST["offset"];
if (!array_key_exists("limit", $_REQUEST) || (array_key_exists("limit", $_REQUEST) && $_REQUEST["limit"] == "")) $limit = 100; else $limit = (int)$_REQUEST["limit"];
if (array_key_exists("filterName", $_REQUEST) && strcmp($_REQUEST["filterName"], "") != 0 &&
	array_key_exists("filterValue", $_REQUEST)) {
	$filters = array(array("name" => $_REQUEST["filterName"], "value" => $_REQUEST["filterValue"]));
} else {
	$filters = array(); 
}
if (array_key_exists("order", $_REQUEST)) {
	$order = array($_REQUEST["order"]);
} else {
	$order = array(); 
}

if (array_key_exists("orderType", $_REQUEST)) {
	$orderType = array($_REQUEST["orderType"]);
} else {
	$orderType = array(PROVIDER_ORDER_TYPE_ASC); 
}

$size = $provider->getSizeBy($filters);  
$data = $provider->getAllBy($offset, $limit, $filters, $order, $orderType);

$view = new JsonProgramsView($data, $size);
header('Content-type: application/json; charset=utf-8');
echo $view->getContent();

?>
