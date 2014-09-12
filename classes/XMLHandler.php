<?php
class XMLHandler {

	/* private properties */
	private $mSecurityLevel = 0;
	private $mXMLDataSourcePath = "";
	private $mSimpleXMLElement = null;
	
	/* private methods */
	private function doSetSecurityLevel($pSecurityLevel){
		$this->mSecurityLevel = $pSecurityLevel;
	
		switch ($this->mSecurityLevel){
			case "0": // This code is insecure, we are not encoding output
			case "1": // This code is insecure, we are not encoding output
				break;
	
			case "2":
			case "3":
			case "4":
			case "5": // This code is fairly secure
				break;
		};// end switch
	}// end function

	// Thanks: Tim Tomes (Twitter: @LanMaster53)
	private function doWarpAttributes($attributes) {
		$ret = '';
		foreach($attributes as $a => $b) {
			$ret .= ' '.$a.'="'.$b.'"';
		};
		return $ret;
	}// end function WarpAttributes
	
	// Thanks: Tim Tomes (Twitter: @LanMaster53)
	private function doPrettyPrintXML( SimpleXMLElement $han, $prefix = "") {
		if( count( $han->children() ) < 1 ) {
			return $prefix . "&lt;" . $han->getName() . $this->doWarpAttributes($han->attributes()) . "&gt;" . $han . "&lt;/" . $han->getName() . "&gt;<br />";
		};
		$ret = $prefix . "&lt;" . $han->getName() . $this->doWarpAttributes($han->attributes()) . "&gt;<br />";
		foreach( $han->children() as $key => $child ) {
			$ret .= $this->doPrettyPrintXML($child, $prefix . "    " );
		};
		$ret .= $prefix . "&lt;/" . $han->getName() . "&gt;<br />";
		return $ret;
	}// end function PrettyPrintXML

	/* public methods */
	/* constructor */
	public function __construct($pPathToESAPI, $pSecurityLevel){
		$this->doSetSecurityLevel($pSecurityLevel);
	}// end function __construct

	public function GetDataSourcePath(){
		return $this->mXMLDataSourcePath;
	}// end function GetDataSourcePath
	
	public function SetDataSource($pDataSourcePath){
		$this->mXMLDataSourcePath = $pDataSourcePath;
		$this->mSimpleXMLElement = simplexml_load_file($this->mXMLDataSourcePath);
	}// end function SetDataSourcePath

	public function ExecuteXPATHQuery($pXPathQueryString){
	
		$lPrettyXML = "";
		$lXMLQueryResults = null;
		if($this->mSimpleXMLElement){
			$lXMLQueryResults = $this->mSimpleXMLElement->xpath($pXPathQueryString);
		}else{
			throw new Exception('XML datasource not loaded. This may be caused by failing to set XML datasource with call to SetDataSourcePath().');
		}// end if
		
		foreach ($lXMLQueryResults as $lXMLQueryResult) {
			$lPrettyXML .= $this->doPrettyPrintXML($lXMLQueryResult);
		}// end foreach

		return $lPrettyXML;

	}// end function ExecuteXPATHQuery

}// end class
?>
