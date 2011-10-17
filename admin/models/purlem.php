<?php
/**
 * Purlem Model for Purlem Component
 * 
 * @package    Purlem
 * @subpackage Components
 * @license		GNU/GPL
 */

// No direct access
defined( '_JEXEC' ) or die( 'Restricted access' );

jimport('joomla.application.component.model');

/**
 * Purlem Purlem Model
 *
 * @package    Purlem
 * @subpackage Components
 */


class PurlemsModelPurlem extends JModel
{
	/**
	 * Constructor that retrieves the ID from the request
	 *
	 * @access	public
	 * @return	void
	 */

	function __construct() 	{
		parent::__construct();
		$array = JRequest::getVar('cid',  0, '', 'array');
		$this->setId((int)$array[0]);
	}


	/**
	 * Method to set the purlem identifier
	 *
	 * @access	public
	 * @param	int Purlem identifier
	 * @return	void
	 */


	function setId($id) {
		// Set id and wipe data
		$this->_id		= $id;
		$this->_data	= null;
	}


	/**
	 * Method to store a record
	 *
	 * @access	public
	 * @return	boolean	True on success
	 */

	function store() { 
		$purlemID=JRequest::getVar('purlemID','');
		$purlemURI=JRequest::getVar('purlemURI','');
		$showPurlForm=JRequest::getVar('purlemShowForm','');
		$purlAPI=JRequest::getVar('purlAPI','');
		$row = & $this->getTable('purlem'); 
		$data = JRequest::get( 'post' );
		$id = JRequest::getVar('id');

		// Bind the form fields to the hello table
		if (!$row->bind($data)) {
			$this->setError($this->_db->getErrorMsg());
			return false;
		}

		// Make sure the hello record is valid
		if (!$row->check()) {
			$this->setError($this->_db->getErrorMsg());
			return false;
		}

		if($id) {
		$row->id=$id;
		}

		// Store the web link table to the database
		if (!$row->store()) {
			//$this->setError( $row->getErrorMsg() );
			return false;
		}
		

		//add the htaccess code
		$this->add_htaccess_code($purlemID,$purlemURI);	

		return true;
 }

function add_htaccess_code($purlemID,$purlemURI) {	
		 $queryConcat = '&';
         if(!strstr($purlemURI,'?')) $queryConcat = '?';
		 $file = JPATH_SITE.DS.'.htaccess'; 
		 $code = "\r\n#PURL CODE\nRewriteEngine on 
		RewriteCond %{SCRIPT_FILENAME} !([A-Za-z0-9_]+)\.(html?|php|asp|css|jpg|gif|shtml|htm|xhtml|txt|ico|xml|wp-admin|admin)/?$ [NC] 
		RewriteCond %{REQUEST_FILENAME} !-d
		RewriteCond %{REQUEST_FILENAME} !-f
		RewriteRule ^([A-Za-z0-9]+)[\.+]([A-Za-z0-9]+)/?$ ".$purlemURI.$queryConcat."purl=\\$1\\$2&ID=".$purlemID."&page=1&platform=joomla [R]\n#END PURL CODE";
		 $code_permalink = "#PURL CODE
		<IfModule mod_rewrite.c>
		RewriteEngine On
		RewriteCond %{SCRIPT_FILENAME} !([A-Za-z0-9_]+).(html?|php|asp|css|jpg|gif|shtml|htm|xhtml|txt|ico|xml|wp-admin|admin)/?$ [NC]
		RewriteCond %{REQUEST_FILENAME} !-f
		RewriteCond %{REQUEST_FILENAME} !-d
		RewriteRule ^([a-zA-Z0-9]+)[\.+]([a-zA-Z0-9]+)/?$ ".$purlemURI.$queryConcat."purl=\\$1\\$2&ID=".$purlemID."&page=1&platform=joomla [R,L]
		</IfModule>
		#END PURL CODE\n"; 

	 $htaccess_content = @file_get_contents($file); 
	//print_r($htaccess_content); die;
	if($htaccess_content) {  
		if(strstr($htaccess_content,'<IfModule mod_rewrite.c>')) {
		$purlCode = $code_permalink;
		} 
		else
		 {
			 $purlCode = $code;
		}

		 $search_pattern = "/(#PURL CODE)(?:[\w\W\r\n]*?)(#END PURL CODE)/i";
		 $new_content = preg_replace($search_pattern, $purlCode, $htaccess_content);
		if(!strstr($new_content,'#PURL CODE'))
		{
			$new_content = $purlCode."".$htaccess_content;
		}
		 file_put_contents($file, stripslashes($new_content));
	  } 
	else
	 {
		 file_put_contents($file, stripslashes($code));
	}
	return true;
	}


	
}