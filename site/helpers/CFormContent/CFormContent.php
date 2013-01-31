<?php
/**
* A form to manage content.
*
* @package LanayaHelpers
*/
class CFormContent extends CForm {

  	/**
	 * Properties
	 */	
  	private $content;

  	/**
	 * Constructor
	 */
  	public function __construct($content) {
		parent::__construct();
    	$this->content = $content;
    	$save = isset($content['id']) ? 'save' : 'create';
    	
    	$this->AddElement(new CFormElementHidden('id', array('value'=>$content['id'])))
         	 ->AddElement(new CFormElementText('title', array('value'=>$content['title'])))
         	 ->AddElement(new CFormElementText('key', array('value'=>$content['key'])))
         	 ->AddElement(new CFormElementTextarea('data', array('label'=>'Content:', 'value'=>$content['data'])))
         	 ->AddElement(new CFormElementText('type', array('value'=>$content['type'])))
         	 ->AddElement(new CFormElementText('filter', array('value'=>$content['filter'])))
         	 ->AddElement(new CFormElementSubmit($save, array('callback'=>array($this, 'DoSave'), 'callback-args'=>array($content), 'class'=>'btn btn-primary')));
    	
    	if(isset($content['id']))
    		$this->AddElement(new CFormElementSubmit('delete', array('callback'=>array($this, 'DoDelete'), 'callback-args'=>array($content), 'class'=>'btn btn-primary')));
    	
    	else
    		$this->AddElement(new CFormElementSubmit('deleteall', array('callback'=>array($this, 'DoDeleteAll'), 'callback-args'=>array($content), 'class'=>'btn btn-primary', 'value'=>'Delete All')));

    	$this->SetValidation('title', array('not_empty'))
         	 ->SetValidation('key', array('not_empty'));
  	}
  

  	/**
	 * Callback to save the form content to database.
	 */
  	public function DoSave($form, $content) {
  		$content['id'] = $form['id']['value'];
    	$content['title'] = $form['title']['value'];
    	$content['key'] = $form['key']['value'];
    	$content['data'] = $form['data']['value'];
    	$content['type'] = $form['type']['value'];
    	$content['filter'] = $form['filter']['value'];
    	
    	return $content->Save();
  	}
  	
  	/**
  	 * Callback to delete a specific content from the database.
  	 */
  	public function DoDelete($form, $content) {
  		$content['id'] = $form['id']['value'];
  		
  		$content->Delete();
  		CLanaya::Instance()->RedirectTo('content');
  	}
  	
  	/**
  	 * Callback to delete all content from the database.
  	 */
  	public function DoDeleteAll($form, $content) {
  		if($form['title']['value'] == 'delete all' && $form['key']['value'] == 'delete all')
  			$content->DeleteAll();
  		
  		else
  			$content->AddMessage('error', "Input of the title and key fields aren't approved to delete all content");
  		
  		CLanaya::Instance()->RedirectTo('content');
  	}
}