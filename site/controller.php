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

// no direct access
defined( '_JEXEC' ) or die( 'Restricted access' );

jimport('joomla.application.component.controller');

/**
 * Purl World Component Controller
 *
 * @package		Purlem
 */
class PurlemController extends JController
{
	function purl_code() 
		{     
			$purlemID = JRequest::getVar('ID');
			$page=JRequest::getVar('page');
			$pp = JRequest::getVar('purl');
			$Show_In_Content=JRequest::getVar('test');
			$purlapi_uri = 'http://www.purlapi.com/lp/index.php?ID='.JRequest::getVar('ID').'&name='.JRequest::getVar('purl').'&page='.JRequest::getVar('page').'&platform=joomla'; 
			
			//switch between file_get_contents and curl
			$db=JFactory::getDBO();
			$query = 'SELECT purlAPI FROM #__purlem_config WHERE id=1'; 	 
			$db->setQuery($query);
			$config = $db->loadObject();
			if($config->purlAPI == 'file_get_contents') {
				$data = @file_get_contents($purlapi_uri);     
			} else {
				$curl = @curl_init(); curl_setopt ($curl, CURLOPT_URL, $purlapi_uri); 
				curl_setopt($curl, CURLOPT_RETURNTRANSFER, 1);          
				$data = curl_exec ($curl); 
				curl_close ($curl);
			}
			
			
			$user = json_decode($data);
	        $visitor='';          
			if($user) {
		 		$session = JFactory::getSession();
		  		if(JRequest::getVar('username')) {
					$visitor=JRequest::getVar('username');
		    		$session->set('visitor',$visitor);
				}
		  		if($user->{'login'} && ($session->get('visitor') != $user->{'firstName'}.$user->{'lastName'})) { 
					echo $user->{'login'};
		 			exit; 
		 		}
	 			$session->set('users',$user);
		 	}
	  	}

	   function purl_convert($content) { 
			$i = 0;
			$session=& JFactory::getSession();
			$user=$session->get('users','');
		    $patterns[$i] = '/#firstName/'; $i++;   
		 	$patterns[$i] = '/#lastName/'; $i++;
			$patterns[$i] = '/#organization/'; $i++;
			$patterns[$i] = '/#position/'; $i++;
			$patterns[$i] = '/#email/'; $i++;
			$patterns[$i] = '/#phone/'; $i++;
			$patterns[$i] = '/#address1/'; $i++;
			$patterns[$i] = '/#address/'; $i++;
			$patterns[$i] = '/#city/'; $i++;
			$patterns[$i] = '/#state/'; $i++;
			$patterns[$i] = '/#zip/'; $i++;
			$patterns[$i] = '/#password/'; $i++;
			$i=0; 
			$replacements[$i] =$user->{'firstName'}; $i++;
			$replacements[$i] =$user->{'lastName'}; $i++;
			$replacements[$i] =$user->{'contact_organization'}; $i++;
			$replacements[$i] =$user->{'contact_position'}; $i++;
			$replacements[$i] =$user->{'contact_email'}; $i++;
			$replacements[$i] =$user->{'contact_phone'}; $i++;
			$replacements[$i] =$user->{'contact_address1'}; $i++;
			$replacements[$i] =$user->{'contact_address1'}; $i++;
			$replacements[$i] =$user->{'contact_city'}; $i++;
			$replacements[$i] =$user->{'contact_state'}; $i++;
			$replacements[$i] =$user->{'contact_zip'}; $i++;
			$replacements[$i] =$user->{'contact_password'}; $i++;
			$convertedContent = preg_replace($patterns, $replacements, $content);
			return $convertedContent;
		} 

	  	function display_purl_content() {
			$session=& JFactory::getSession();
			$user=$session->get('users','');
			if($user->{'content'}) {
				if(!$user->{'firstName'}) {
					echo $newContent .= '<b>PURL NOT FOUND</b> Please try again.';
				}
				$newContent = $this->purl_convert($user->{'content'});
			}
			return $newContent;
		}
		
		function display_purl_form() {
			$session=& JFactory::getSession();
			$user=$session->get('users','');
			if($user->{'form'}) {
				$newContent = $user->{'form'};
			}
			return $newContent;
		}


		function display() {   
			$this->purl_code();

			$db=JFactory::getDBO();
			$query = 'SELECT id,showPurlForm,purlemID FROM #__purlem_config WHERE id=1'; 	 
			$db->setQuery($query);
			$config = $db->loadObject();

			echo $this->display_purl_content();
			if(JRequest::getVar('ID')&&JRequest::getVar('purl')&&JRequest::getVar('page') && $config->showPurlForm == 'Y') {    
				echo $this->display_purl_form();
			}
				
			parent::display();
		}

}
?>