<?php
//-----------------------------------------------------------------------------
// Build the ipfilter page
//		In: Unparsed template
//		Out: Parsed template
//-----------------------------------------------------------------------------
class AdminIPFilterPageController
{
	public function __construct(&$output)
	{	
		$result = GetBlockedAddresses();
		$ipfilterentry = LogicTag("{LOOP}", "{/LOOP}", $output);
		while(list($ip_id, $address, $timestamp) = GetDatabase()->GetRow($result))
		{
			$tags = [
				"{IP}" => $address,
				"{TIMESTAMP}" => date(DATE_FORMAT, $timestamp)
			];
			$temp = $ipfilterentry;
			ParseTags($tags, $temp);
			$temp .= "\n{IPFILTERENTRY}";
			ReplaceTag("{IPFILTERENTRY}", $temp, $output);				
		}
		RemoveLogicTag("{LOOP}", "{/LOOP}", $output);
		ReplaceTag("{IPFILTERENTRY}", "", $output);
	}
}
?>