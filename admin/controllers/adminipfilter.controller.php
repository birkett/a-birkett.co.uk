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
		$ipfilterentry = "";
		while(list($id, $ip, $timestamp) = GetDatabase()->GetRow($result))
		{
			$unblocklink = '<a href="" onClick="doaction(\''.$ip.'\'); return false;">Unblock</a>';
			$commentslink = '<a href="'.ADMIN_FOLDER.'index.php?action=listcomments&ip='.$ip.'">Comments</a>';
			$ipfilterentry .= '<tr><td>' . $ip . '</td><td>' . date(DATE_FORMAT, $timestamp) . '</td><td>' . $unblocklink . '</td><td>' . $commentslink . '</td></tr>';
		}
		ReplaceTag("{IPFILTERENTRY}", $ipfilterentry, $output);
	}
}
?>