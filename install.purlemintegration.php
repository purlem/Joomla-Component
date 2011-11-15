<?php
/*------------------------------------------------------------------------
# Purlem
# ------------------------------------------------------------------------
# author    Marty Thomas - Purlem
# copyright Copyright (C) 2011 Purlem.com. All Rights Reserved.
# @license - http://www.gnu.org/licenses/gpl-2.0.html GNU/GPL
# Websites: http://www.purlem.com
# Technical Support:  Forum - http://support.purlem.com
-------------------------------------------------------------------------*/

// No direct access
defined( '_JEXEC' ) or die( 'Restricted access' );

jimport( 'joomla.filesystem.folder' );

function com_install()
{
?>
    <div style="padding:20px;text-align:center;">
	<img src="http://www.purlem.com/assets/images/logo_white.gif" width="300" height="84" alt="Purlem Personalized URL Marketing" /><br /><br />
	<a href="<?php echo JURI::root();?>administrator/index.php?option=com_purlem"><img src="components/com_purlem/assets/images/button_install.jpg" border="0" width="180px"></a>
	</div>
<?php
}// function
