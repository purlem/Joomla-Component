<?php/** * Purl Controller for Purl World Component *  * @package    Purlem * @subpackage Components * @license		GNU/GPL */// No direct accessdefined( '_JEXEC' ) or die( 'Restricted access' );/** * Purlem Purlem Controller * * @package    Joomla.Tutorials * @subpackage Components */class PurlemsControllerPurlem extends PurlemsController{		/**	 * save a record (and redirect to main page)	 * @return void	 */	function save()	{		//install mod_purlem_form		jimport('joomla.installer.helper');		jimport('joomla.installer.installer');        jimport('joomla.filesystem.file');        jimport('joomla.filesystem.folder');		$db =& JFactory::getDBO();        $installer = new JInstaller();		$pkg_path = JPATH_ADMINISTRATOR.DS.'components'.DS.'com_purlem'.DS.'extensions'.DS;		$pkgs = array('mod_purlem_form.zip'=>'Purlem Form');		$mainframe = & JFactory::getApplication();		foreach( $pkgs as $pkg => $pkgname ) {			if(file_exists($pkg_path.$pkg)) {				$package = JInstallerHelper::unpack( $pkg_path.$pkg );				$installer->install( $package['dir'] );			}		}		$path = JPATH_ADMINISTRATOR.DS.'components'.DS.'com_purlem'.DS.'extensions';		if(JFolder::exists($path)) {			JFolder::delete($path);		}								//save model				$model = $this->getModel('purlem');		if ($model->store($post)) {			$msg = JText::_( 'Data Saved!' );		} else {			$msg = JText::_( 'Error Saving Data' );		}		// Check the table in so it can be edited.... we are done with it anyway		$link = 'index.php?option=com_purlem';		$this->setRedirect($link, $msg);	}	}