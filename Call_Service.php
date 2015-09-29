<?php

require_once('WrapperSoapClient.php');
//require_once("/tna_app/lib/mailer.php");
//require_once("/tna_app/lib/config.php");
//require_once("/tna_app/lib/sql/cron/emw.cron.mysql.php");


$path_parts = pathinfo(__FILE__);
//$log->changeLogger($path_parts['dirname']);
$filename = $path_parts['filename'] .".". $path_parts['extension'];

date_default_timezone_set('Europe/Brussels');
$date_stamp = date("Ymd");

//$wsdl_All="http://localhost:8091/ConnectionRetrieval?wsdl";
//$wsdl_SNC = "http://localhost:8091/ConnectionRetrieval?wsdl";

$wsdl = "http://172.31.123.31:9997/ConnectionRetrieval?wsdl";

$header_ALL = NULL;
$header_ALL = array( 'communicationPattern' => 'MultipleBatchResponse' , 'communicationStyle' => 'RPC', 'requestedBatchSize' => '20000' );
//$header_ALL = array( 'v1:communicationStyle' => 'RPC', 'v1:requestedBatchSize' => '20000' );
//$header_ALL = "<v1:header> <v1:security>xmluser:Xmluser1</v1:security> <v1:communicationPattern>MultipleBatchResponse</v1:communicationPattern> <v1:communicationStyle>RPC</v1:communicationStyle> <v1:requestedBatchSize>20000</v1:requestedBatchSize>  <v1:batchSequenceNumber>1</v1:batchSequenceNumber></v1:header>";
$body_ALL = array( 'type' => 'MD', 'value' => 'Huawei/U2000', 'type' => 'MLSN', 'value' => '1', 'layerRate' => 'LR_Optical_Channel' );

try {
	$wrapperClient = new WrapperSoapClient($wsdl);
	$wrapperClient->wrapperGetAllSubnetworkConnections( $body_ALL , $header_ALL  );
} catch ( Exception $ex) {
	
	echo '!!!!! Caught exception: ',  $ex->getMessage(), "\n";
}

?>