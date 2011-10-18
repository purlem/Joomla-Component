<?php defined('_JEXEC') or die('Restricted access'); ?>

<style type="text/css">
<!--
hr {
	color: #ccc;
	background-color: #ccc;
	height: 1px;
	border: 0;
	margin-bottom:15px;
}
h3{
	font-size:13px;
	font-weight:bold;
	margin-right:20px;
}
p {
	font-size:12px;
}
-->
</style>

<div style="float:left; width:340px; margin-right:20px; border-right-width: 1px;border-right-style: solid;border-right-color: #CCC; text-align:center;">
<p><img src="http://www.purlem.com/assets/images/logo_white.gif" width="300" height="84" alt="Purlem Personalized URL Marketing" /></p>
<div style="margin-top:-10px;margin-bottom:30px;"><p><b><a href="http://support.purlem.com/entries/20557638-installing-purlem-s-joomla-component" target="_blank">View Tutorial</a></b></p></div>
<h2>Step 1</h1>
<p><a href="http://purlem.com/packages" target="_blank"><img src="http://purl-marketing.com/administrator/components/com_purlem/assets/images/button_createAccount.jpg" alt="Create Account" border="0"/></a></p>
<h2>Step 2</h1>
<p style="font-size:16px;"><a href="http://support.purlem.com/entries/20556653-joomla-create-menu-item" target="_blank">Create Menu Item</a></p>
<h2>Step 3</h1>
<p style="font-size:16px;"><a href="http://dev.purlsvndash.home/dashboard/setup?default=joomla" target="_blank">Create a Joomla Campaign</a></p>
</div>


<div style="float:left;">
<h2>Step 4: Already have a Purlem Account & Campaign?</h2>

<?php 
$db=JFactory::getDBO();
$query = 'SELECT id,showPurlForm,purlAPI,purlemID,purlemURI FROM #__purlem_config WHERE id=1'; 	 
$db->setQuery($query);
$purlemid = $db->loadObject();
if(!$purlemid) {
	$purlemid->id='';
 	$purlemid->purlemID='';
	$showPurlForm->showPurlForm='';
	$purlAPI->purlAPI='';
	$purlemURI->purlemURI='';
}

?>

<form action="index.php" method="post" name="adminForm">
	<div style="background-color:white;padding:10px;margin-right:15px;margin-top:10px;margin-bottom:15px;border: 1px solid #ddd; -moz-border-radius: 10px;border-radius: 10px;">
	<table class="form-table">
		<tr valign="top">
		<td><h3>Client ID:</h3></td>
		<td><input name="purlemID" type="text" size="10"  style="font-size:22px;" value="<?php echo $purlemid->purlemID;?>" /></td>
		</tr>
		<tr>
        <td><h3>Page URL:</h3></td>
		<td><input name="purlemURI" type="text" size="40" style="font-size:22px;" value="<?php if(empty($purlemid->purlemURI)) { echo 'http://'; } else { echo $purlemid->purlemURI; } ?>" /><br /><i style="font-size:10px;color:gray;">The full URL of the page to be personalized (from Step 2).<i></td>
		</tr>
	</table>
	</div>
	<p style="margin-bottom:-5px;"><b>Options</b></p>
	<div style="background-color:white;padding:10px;margin-right:15px;margin-top:10px;margin-bottom:15px;border: 1px solid #ddd; -moz-border-radius: 10px;border-radius: 10px;">
	<table>
        <h3>Show Form in Content Area:</h3>
		<p>
		<input type="radio" name="showPurlForm" value="Y" <?php if($purlemid->showPurlForm == 'Y' || $purlemid->showPurlForm == '') echo 'checked=\"checked\"'; ?>> Yes &nbsp;&nbsp;
        <input type="radio" name="showPurlForm" value="N" <?php if($purlemid->showPurlForm == 'N') echo 'checked=\"checked\"'; ?>> No
		</p>
		<hr />
		<h3>API Type:</h3>
		<p>
        <input type="radio" name="purlAPI" value="file_get_contents" <?php if($purlemid->purlAPI == 'file_get_contents' || $purlemid->purlAPI == '') echo 'checked=\"checked\"'; ?>>
        file_get_contents&nbsp;&nbsp;
        <input type="radio" name="purlAPI" value="curl" <?php if($purlemid->purlAPI == 'curl') echo 'checked=\"checked\"'; ?>> 
        curl
        <br />
        <i style="font-size:10px;color:gray;">If you receive a "PURL NOT FOUND" error, try using curl.</p>
	</table>
	</div>
	<input type="hidden" name="option" value="com_purlem" />
	<input type="hidden" name="task" value="" />
	<input type="hidden" name="boxchecked" value="0" />
	<input type="hidden" name="controller" value="purlem" />
	<input type="hidden" name="id" value="<?php echo  $purlemid->id?>" />
</form>
</div>

<div style="clear:both;">&nbsp;</div>