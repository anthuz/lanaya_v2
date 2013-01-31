<?php
/**
* Standard controller layout.
*
* @package LanayaControllers
*/
class CCIndex extends CObject implements IController {

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
		$modules = new CMModules();
    	$controllers = $modules->AvailableControllers();
    	$this->views->SetTitle('Index');
		$this->views->AddInclude(LANAYA_VIEWS_PATH . '/index_content.php', array(), 'content');
		$this->views->AddInclude(LANAYA_VIEWS_PATH . '/index_sidebar.php', array('controllers'=>$controllers), 'sidebar');
	}

} 