<?php
/**
* To manage and analyse all modules of Lydia.
*
* @package LanayaControllers
*/
class CCModules extends CObject implements IController {

  	/**
  	 * Constructor
  	 */
  	public function __construct() { parent::__construct(); }


  	/**
   	 * Show a index-page and display what can be done through this controller.
   	 */
  	public function Index() {
	    $modules = new CMModules();
	    $controllers = $modules->AvailableControllers();
	    $allModules  = $modules->ReadAndAnalyse('system');
	    $allModules  = array_merge($modules->ReadAndAnalyse('site/controllers'),$allModules);
	    $allModules  = array_merge($modules->ReadAndAnalyse('site/helpers'),$allModules);
	    $allModules  = array_merge($modules->ReadAndAnalyse('site/models'),$allModules);
	    $this->views->SetTitle('Manage Modules');
	    $this->views->AddInclude(LANAYA_VIEWS_PATH . '/modules_content.php', array('controllers'=>$controllers), 'content');
	    $this->views->AddInclude(LANAYA_VIEWS_PATH . '/modules_sidebar.php', array('modules'=>$allModules), 'sidebar');
  	}
  	
  	/**
  	 * Show a index-page and display what can be done through this controller.
  	 */
  	public function Install() {
  		$modules = new CMModules();
  		$results = $modules->Install();
  		$allModules  = $modules->ReadAndAnalyse('system');
	    $allModules  = array_merge($modules->ReadAndAnalyse('site/controllers'),$allModules);
	    $allModules  = array_merge($modules->ReadAndAnalyse('site/helpers'),$allModules);
	    $allModules  = array_merge($modules->ReadAndAnalyse('site/models'),$allModules);
  		$this->views->SetTitle('Install Modules');
  		$this->views->AddInclude(LANAYA_VIEWS_PATH . '/modules_install.php', array('modules'=>$results), 'content');
  		$this->views->AddInclude(LANAYA_VIEWS_PATH . '/modules_sidebar.php', array('modules'=>$allModules), 'sidebar');
  	}


}