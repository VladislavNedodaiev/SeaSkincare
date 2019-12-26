<?php

if (!isset($business_subscriptions) || empty($business_subscriptions))
	return null;

$result = array();

foreach ($business_subscriptions as $key => &$value) {

	if (date('Y-m-d') > $value->finishDate) {
		if (!isset($result[$key])) {
			$result[$key] = $value;
		}
	}

}

return $result;

?>