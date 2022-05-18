<?php

function toWareki($date) {
	if(!$date){
		return "--";
	}
	$date = (int)$date;
	$year = date_format(date_create($date), 'Y');
    $jpyear = 0;
    if ( $date >= 20190501 ) {
        $wname = "R"; // 令和 Reiwa
        $jpyear = $year - 2018;
    } elseif ($date >= 19890108) { 
		$wname = "H"; // 平成 Heisei
		$jpyear = $year - 1988;
	} else if ($date >= 19261225) { 
		$wname = "S"; // 昭和 Shōwa
		$jpyear = $year - 1925;
	} else if ($date >= 19120730) {
		$wname = "T"; // 大正 Taishō
		$jpyear = $year - 1911;
	} else if ($date >= 18680125) {
		$wname = "M"; // 明治 Meiji
		$jpyear = $year - 1867;
	}
    return $wname . "(" . $jpyear . ") " . $year;
} 

function formattedMileage ($mileage,$mileage_unit_cd) {
	if (!$mileage) {
		return "--";
	}
	return number_format($mileage) . " ". $mileage_unit_cd;

}

function formattedOutColor ($out_color_name) {
	if (!$out_color_name) {
		return "--";
	}
	return (mb_strlen($out_color_name)>10)?mb_substr($out_color_name, 0,10)."...":$out_color_name;
}

function formattedShift ($shift_code,$shift_cnt,$shift_position) {
	if (!$shift_cnt) {
		$shift_cnt='';
	}
	return $shift_code.$shift_cnt.$shift_position;
}

function formattedSalePrice ($sale_price) {
	if (!$sale_price) {
		return "--";
	}
	return number_format($sale_price) . " 円";
}

function sortOrder ($current, $order_by, $sort_order) {
	if (!$order_by && !$sort_order) return "";
	if ($current==$order_by) {
		if($sort_order=="asc"){
			return "▲";
		} else {
			return "▼";
		}
	}else{
		return "";
	}
}

function getOrder ($current,$order_by, $sort_order) {
	$params = 'order_by='.$current.'&sort_order=';
	if (!$sort_order) {
		return $params."asc";
	}
	if ($current == $order_by) {
		if($sort_order=="asc"){
			return $params."desc";
		} else {
			return $params."asc";
		}
	}else{
		return $params."asc";
	}
}