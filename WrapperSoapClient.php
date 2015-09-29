<?php

/**

SERVICE        : WSDL
PAYLOAD        : document/literal
TRANSPORT      : HTTP
AUTHENTICATION : NONE

*/
// http://php.net/manual/en/class.soapclient.php
// http://php.net/manual/en/ref.soap.php
// http://php.net/manual/en/book.xml.php
// http://stackoverflow.com/questions/18125751/php-nusoap-soap-request-not-working -- Adding soap Header
// http://php.net/manual/en/soapclient.setsoapheaders.php

require_once("./lib/nusoap.php");
//require_once("/tna_app/lib/mailer.php");
require_once("/tna_app/lib/config.php");


$path_parts = pathinfo(__FILE__);
//$log->changeLogger($path_parts['dirname']);
$filename = $path_parts['filename'] .".". $path_parts['extension'];

$proxyhost = isset($_POST['proxyhost']) ? $_POST['proxyhost'] : '';
$proxyport = isset($_POST['proxyport']) ? $_POST['proxyport'] : '';
$proxyusername = isset($_POST['proxyusername']) ? $_POST['proxyusername'] : '';
$proxypassword = isset($_POST['proxypassword']) ? $_POST['proxypassword'] : '';

class WrapperSoapClient {
		
	private $isSoapClientExists=FALSE;
	private $isAnySoapError=FALSE;
	private $webServiceUrl=NULL;
	private $header;
	private $client=NULL;
	private $getAllSubnetworkConnectionsResponse;
	private $getAllSubnetworkConnectionsRequest;
	
	private $getAllSNCNamesWithHigherOrderSNCResponse;
	private $getAllSNCNamesWithHigherOrderSNCRequest;
	
	function __construct( $webServiceUrl ) {
		
		
		$this->webServiceUrl = $webServiceUrl;
		
		if ( class_exists("nusoap_client") ) {
			
			
			$this->isSoapClientExists = TRUE;
			
			$this->client =new nusoap_client($this->webServiceUrl, 'wsdl',  $GLOBALS['proxyhost'],  $GLOBALS['proxyport'],  $GLOBALS['proxyusername'],  $GLOBALS['proxypassword']);
			$this->preapreHeader();
			
			$err = $this->client->getError();
			
			// Check for a SOAP ERROR
			if ($err) {
				$this->isAnySoapError=TRUE;
				echo "Soap Constructor error...";
				//log->writeLog("[$filename] : Soap Constructor error " . $err . " while calling service at " . $this->webServiceUrl );
			}
			
			// Check for a SOAP fault
			if ($this->client->fault) {
				$this->isAnySoapError=TRUE;
				echo " Soap fault present...";
				//log->writeLog("[$filename] : Soap fault present while calling service at " . $this->webServiceUrl );
			} else {
				echo "<h2> SUCCESS : in accessing service at : ". $this->webServiceUrl ."</h2>";
				//$log->writeLog("[$filename] : SUCCESS in accessing service at ". $this->webServiceUrl);
			}
		} else {
				echo "ERROR...";
				//$log->writeLog("[$filename] : Suitable Soap Client not present in namespace...");
		}
	}
	
	public function sendRequest($method, $params) {}
	
	public function wrapperGetAllSubnetworkConnections ( $bodyParm, $headerParam  ) {
		
		// function call($operation,$params=array(),$namespace='http://tempuri.org',$soapAction='',$headers=false,$rpcParams=null,$style='rpc',$use='encoded')

		$result=NULL;
		if ( $this->isSoapClientExists && !$this->isAnySoapError && !is_null ($bodyParm)) {
			
			 $result = $this->client->call('getAllSubnetworkConnections', $bodyParm, '', '', $headerParam, true);	
				
			 if ($this->client->fault) {
				echo '<h2>Fault while calling getAllSubnetworkConnections ...</h2><pre>';
				print_r($result);
				echo '</pre>';
			 }
			 echo "<h2>REQUEST :- > </h2><pre>" . htmlspecialchars($this->client->request, ENT_QUOTES). '</pre>';
			 echo "<h2>RESPONSE :- > </h2><pre>" . htmlspecialchars($this->client->response, ENT_QUOTES). '</pre>';
		} else {
			echo "<h2>Either soap client doesn't exist or any error in service call initializaton or provided soap body is NULL...</h2>";
			//$log->writeLog("[$filename] : Either soap client doesn't exist or any error in service call initializaton or provided soap body is NULL...");
		}
	}
	
	public function wrapperGetAllSNCNamesWithHigherOrderSNC ( $header, $body ) {
		
		if ( $this->isSoapClientExists && $this->isAnySoapError ) {
			
		} 
	}
	
	private function preapreHeader () {
		
		if ( !is_null($this->client) ) {
			
			/*
			
			
$ns                         = 'http://webservices.micros.com/og/4.3/Availability/'; //Namespace of the WS.//Body of the Soap Header.
$strHeaderComponent_Session = <<<XML
<OGHeader transactionID="005435" timeStamp="2008-12-09T13:26:56.4056250-05:00" xmlns="http://webservices.micros.com/og/4.3/Core/">
  <Origin entityID="OWS" systemType="WEB" />
  <Destination entityID="WEST" systemType="ORS" />
</OGHeader>
XML;
$objVar_Session_Inside      = new SoapVar($strHeaderComponent_Session, XSD_ANYXML, null, null, null);
$objHeader_Session_Outside  = new SoapHeader($ns , 'SessionHeader', $objVar_Session_Inside);

// More than one header can be provided in this array.
$client->__setSoapHeaders(array($objHeader_Session_Outside));


From Python Script :
-------------
    header = client.factory.create('ns11:header')
    header.security = 'xmluser:Xmluser1'
    header.communicationPattern.set('MultipleBatchResponse')
    header.communicationStyle.set('RPC')
    header.requestedBatchSize = 1000
    header.batchSequenceNumber = 1
    client.set_options(soapheaders=header)
    
    mlsnRef = client.factory.create('ns13:NamingAttributeType')
    for rnode in NODES:
        node = client.factory.create('ns13:rdn')
        node.type, node.value = rnode 
        mlsnRef.rdn.append(node)
    connectionRateList = client.factory.create('ns39:LayerRateListType')
    connectionRateList.layerRate.append('LR_Optical_Channel')
    
    msg = client.service.getAllSubnetworkConnections(mlsnRef, connectionRateList)
*/
		}
	}
	
}

?>