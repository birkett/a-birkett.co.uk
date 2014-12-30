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
		new AdminBasePageController($output, "ipfilter");
		$result = GetBlockedAddresses();
		$ipfilterentry = LogicTag("{LOOP}", "{/LOOP}", $output);
		while(list($ip_id, $address, $timestamp) = GetDatabase()->GetRow($result))
		{
			$tags = [
				"{ADMINFOLDER}" => ADMIN_FOLDER,
				"{IP}" => $address,
				"{TIMESTAMP}" => date(DATE_FORMAT, $timestamp)
			];
			$temp = $ipfilterentry;
			ParseTags($tags, $temp);
			$temp .= "\n{IPFILTERENTRY}";
			ReplaceTag("{IPFILTERENTRY}", $temp, $output);				
		}
		RemoveLogicTag("{LOOP}", "{/LOOP}", $output);
		//Clean up the tags if not already replaced
		$cleantags = [ "{IPFILTERENTRY}" ];
		RemoveTags($cleantags, $output);
	}
}
?>