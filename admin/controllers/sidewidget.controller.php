<?php
//-----------------------------------------------------------------------------
// Build the admin side widget
//		In: Unparsed template
//		Out: Parsed template
//-----------------------------------------------------------------------------
class AdminSideWidgetController
{
	public function __construct(&$output)
	{
		new AdminBasePageController($output, "sidewidget");
		
		$sidewidgettemplate = "";
		if(isset($_SESSION['user']))
		{
			$sidewidgettemplate .= '<p>Logged in as ' . $_SESSION['user'] . ' <a href="'.ADMIN_FOLDER.'index.php?action=logout">(Logout)</a></p>';
		} 
		else 
		{
			$sidewidgettemplate .= '
			<form action="'.ADMIN_FOLDER.'index.php?action=login" method="POST">
				<input type="text" name="username" id="username"/>
				<input type="password" name="password" id="password"/>
				<input type="submit" name="Submit" id="submit"/>
			</form>';
		}
					
		ReplaceTag("{SIDEWIDGET}", $sidewidgettemplate, $output);
	}
}
?>