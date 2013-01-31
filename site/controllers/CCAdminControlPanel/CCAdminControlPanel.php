<?php
/**
 * A admin control panel controller to make it possible to add, edit and remove users and groups for the administrator.
 *
 * @package LanayaControllers
 */
class CCAdminControlPanel extends CObject implements IController {

   	/**
   	 * Constructor
  	 */
  	public function __construct() {
    	parent::__construct();
  	}
 
  	/**
  	 * Implementing interface IController. All controllers must have an index action.
  	 */
  	public function Index() {   
  		if($this->user->IsAuthenticated()) {
  			$this->views->SetTitle('Lanaya ACP');
    		$this->views->AddInclude(LANAYA_VIEWS_PATH . '/acp.php');
  		} else {
  			
  		}
  	}
 
} 