<?php
//https://www.youtube.com/watch?v=mYi2-UZHa6E
//https://github.com/vikas62081/material-table-YT/blob/serverSidePaginationSearchFilterSorting/src/App.js
include('config.php');
include('functions.php');
header('Access-Control-Allow-Origin: *');

$data = array();

$q = !empty(@$_GET['q']) ? @$_GET['q'] : '';
$sort = !empty(@$_GET['_sort']) ? @$_GET['_sort'] : 'id';
$order = !empty(@$_GET['_order']) ? @$_GET['_order'] : 'asc';
$limit = !empty(@$_GET['_limit']) ? @$_GET['_limit'] : 10;
$page = !empty(@$_GET['_page']) ? @$_GET['_page'] : ''; 

$where = "Destination LIKE '%".$q."%' OR stateprovince LIKE '%".$q."%' OR country LIKE '%".$q."%'";
$sql = "select id, Destination as athlete, stateprovince as age, country as country from hotels_city_list ";
if(!empty($q)) {
	$sql .= "where $where ";
}
if(!empty($sort) && !empty($order)) {
	$sql .= "order by $sort $order ";
}
if(!empty($limit)) {
	if(empty($page)) {
		$sql .= "limit $limit ";
	}
} else {
	if(empty($page)) {
		$sql .= "limit 10 ";
	}
}
if(!empty($page)) {
	if(empty($q)) {
		$page_first_result = ($page-1) * $limit; 
		$sql .= "limit " . $page_first_result . ',' . $limit;
	}
}
//echo $sql; exit;

$result = $mysqli->query($sql);
if($result->num_rows > 0){
	while($row = $result->fetch_assoc()){
		$data[] = $row;
	}
}

$sql2 = "select count(id) as total from hotels_city_list";
$result2 = $mysqli->query($sql2);
$row2 = $result2->fetch_assoc();

if( count($data) > 0 ){
	echo json_encode(array('page'=>$page, 'data'=>$data, 'per_page'=>$limit, 'total'=>$row2['total'], 'total_pages'=>round($row2['total']/$limit)));
} else {
	echo json_encode(array('status'=>'0', 'data'=>'', 'message'=>'No data'));
}


?>