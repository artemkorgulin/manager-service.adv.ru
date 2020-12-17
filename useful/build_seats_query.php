<?php

function build_seats_query(array $seats, string $lead_name)
{
	$chunks = array();

	if (count($seats) == 0) {
		$seats[] = null; // minimum count($seats) should be 1
	}

	for ($i = 0; $i < count($seats); $i++) {
		$chunks[] = implode(array(
			'&seats=', $seats[$i],
			'&names=', $lead_name,
			'&names2= ', // this space '= ' is very important, DO NOT TOUCH
		));
	}

	return implode($chunks);
}
