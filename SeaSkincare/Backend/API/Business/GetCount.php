<?php
namespace SeaSkincare\Backend\API\Business;

include_once '../../Includes/CommonInclude.php';
include_once '../../Includes/SubscriptionInclude.php';
include_once '../../Includes/BusinessInclude.php';

use SeaSkincare\Backend\Controllers\BusinessController;
use SeaSkincare\Backend\Communication\Response;

header('Content-Type: text/html; charset=utf-8');
session_start();

$businessController = new BusinessController;

$search = null;
if (isset($_GET['search'])) {

	parse_str(http_build_query($_GET['search']), $search);

}

echo json_encode($businessController->getCount($search));
exit;

?>