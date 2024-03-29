<?php
/**
* A model for content stored in database.
*
* @package LanayaModels
*/
class CMContent extends CObject implements IHasSQL, IModule, ArrayAccess {

  	/**
	 * Properties
	 */
	public $data;


  	/**
	 * Constructor
	 */
  	public function __construct($id=null) {
    	parent::__construct();
    	if($id) {
      		$this->LoadById($id);
    	} else {
     		$this->data = array();
    	}
  	}


  	/**
	 * Implementing ArrayAccess for $this->data
	 */
  	public function offsetSet($offset, $value) { if (is_null($offset)) { $this->data[] = $value; } else { $this->data[$offset] = $value; }}
  	public function offsetExists($offset) { return isset($this->data[$offset]); }
  	public function offsetUnset($offset) { unset($this->data[$offset]); }
  	public function offsetGet($offset) { return isset($this->data[$offset]) ? $this->data[$offset] : null; }


  	/**
	 * Implementing interface IHasSQL. Encapsulate all SQL used by this class.
	 *
	 * @param $key string the string that is the key of the wanted SQL-entry in the array.
	 * @args $args array with arguments to make the SQL queri more flexible.
	 * @returns string.
	 */
  	public static function SQL($key=null, $args=null) {
    	$order_order = isset($args['order-order']) ? $args['order-order'] : 'ASC';
    	$order_by = isset($args['order-by']) ? $args['order-by'] : 'id';
    	$queries = array(
      		'drop table content' 	=> "DROP TABLE IF EXISTS Content;",
      		'create table content' 	=> "CREATE TABLE IF NOT EXISTS Content (id INTEGER PRIMARY KEY, key TEXT KEY, type TEXT, title TEXT, data TEXT, filter TEXT, idUser INT, created DATETIME default (datetime('now')), updated DATETIME default NULL, deleted DATETIME default NULL, FOREIGN KEY(idUser) REFERENCES User(id));",
      		'insert content' 		=> 'INSERT INTO Content (key,type,title,data,filter,idUser) VALUES (?,?,?,?,?,?);',
      		'select * by id' 		=> 'SELECT c.*, u.acronym as owner FROM Content AS c INNER JOIN User as u ON c.idUser=u.id WHERE c.id=?;',
      		'select * by key' 		=> 'SELECT c.*, u.acronym as owner FROM Content AS c INNER JOIN User as u ON c.idUser=u.id WHERE c.key=?;',
      		'select * by type' 		=> "SELECT c.*, u.acronym as owner FROM Content AS c INNER JOIN User as u ON c.idUser=u.id WHERE type=? ORDER BY {$order_by} {$order_order};",
      		'select *' 				=> 'SELECT c.*, u.acronym as owner FROM Content AS c INNER JOIN User as u ON c.idUser=u.id;',
      		'update content' 		=> "UPDATE Content SET key=?, type=?, title=?, data=?, filter=?, updated=datetime('now') WHERE id=?;",
      		'delete content'		=> "DELETE FROM Content WHERE id=?",
      		'delete all content'	=> "DELETE FROM Content",
     	);
    	
    	if(!isset($queries[$key])) {
      		throw new Exception("No such SQL query, key '$key' was not found.");
    	}
    	return $queries[$key];
  	}
  	
  	/**
  	 * Implementing interface IModule. Manage install/update/deinstall and equal actions.
  	 */
  	public function Manage($action=null) {
  		switch($action) {
  			case 'install':
  				try {
  					$this->db->ExecuteQuery(self::SQL('drop table content'));
  					$this->db->ExecuteQuery(self::SQL('create table content'));
  					$this->db->ExecuteQuery(self::SQL('insert content'), array('hello-world', 'post', 'Hello World', "This is a demo post.\n\nThis is another row in this demo post.", 'plain', $this->user['id']));
  					$this->db->ExecuteQuery(self::SQL('insert content'), array('hello-world-again', 'post', 'Hello World Again', "This is another demo post.\n\nThis is another row in this demo post.", 'plain', $this->user['id']));
  					$this->db->ExecuteQuery(self::SQL('insert content'), array('hello-world-once-more', 'post', 'Hello World Once More', "This is one more demo post.\n\nThis is another row in this demo post.", 'plain', $this->user['id']));
  					$this->db->ExecuteQuery(self::SQL('insert content'), array('home', 'page', 'Home page', "This is a demo page, this could be your personal home-page.\n\nLydia is a PHP-based MVC-inspired Content management Framework, watch the making of Lydia at: http://dbwebb.se/lydia/tutorial.", 'plain', $this->user['id']));
  					$this->db->ExecuteQuery(self::SQL('insert content'), array('about', 'page', 'About page', "This is a demo page, this could be your personal about-page.\n\nLydia is used as a tool to educate in MVC frameworks.", 'plain', $this->user['id']));
  					$this->db->ExecuteQuery(self::SQL('insert content'), array('download', 'page', 'Download page', "This is a demo page, this could be your personal download-page.\n\nYou can download your own copy of lydia from https://github.com/mosbth/lydia.", 'plain', $this->user['id']));
  					$this->db->ExecuteQuery(self::SQL('insert content'), array('bbcode', 'page', 'Page with BBCode', "This is a demo page with some BBCode-formatting.\n\n[b]Text in bold[/b] and [i]text in italic[/i] and [url=http://dbwebb.se]a link to dbwebb.se[/url]. You can also include images using bbcode, such as the lydia logo: [img]http://dbwebb.se/lydia/current/themes/core/logo_80x80.png[/img]", 'bbcode', $this->user['id']));
  					$this->db->ExecuteQuery(self::SQL('insert content'), array('htmlpurify', 'page', 'Page with HTMLPurifier', "This is a demo page with some HTML code intended to run through <a href='http://htmlpurifier.org/'>HTMLPurify</a>. Edit the source and insert HTML code and see if it works.\n\n<b>Text in bold</b> and <i>text in italic</i> and <a href='http://dbwebb.se'>a link to dbwebb.se</a>. JavaScript, like this: <javascript>alert('hej');</javascript> should however be removed.", 'htmlpurify', $this->user['id']));
  					return array('success', 'Successfully created the database tables and created a default "Hello World" blog post, owned by you.');
  				} catch(Exception$e) {
  					die("$e<br/>Failed to open database: " . $this->config['database'][0]['dsn']);
  				}
  				break;
  				 
  			default:
  				throw new Exception('Unsupported action for this module.');
  				break;
  		}
  	}
  

  	/**
	 * Save content. If it has a id, use it to update current entry or else insert new entry.
	 *
	 * @returns boolean true if success else false.
	 */
  	public function Save() {
    	$msg = null;
    	
    	if($this['id']) {
      		$this->db->ExecuteQuery(self::SQL('update content'), array($this['key'], $this['type'], $this['title'], $this['data'], $this['filter'] , $this['id']));
      		$msg = 'update';
    	} else {
      		$this->db->ExecuteQuery(self::SQL('insert content'), array($this['key'], $this['type'], $this['title'], $this['data'], $this['filter'] , $this->user['id']));
      		$this['id'] = $this->db->LastInsertId();
      		$msg = 'created';
    	}
    	$rowcount = $this->db->RowCount();
    	
    	if($rowcount) {
     		$this->AddMessage('success', "Successfully {$msg} content '" . htmlEnt($this['key']) . "'.");
    	} else {
      		$this->AddMessage('error', "Failed to {$msg} content '" . htmlEnt($this['key']) . "'.");
    	}
    	return $rowcount === 1;
  	}
  	
  	/**
  	 * Delete a specific content. 
  	 *
  	 * @returns boolean true if success else false.
  	 */
  	public function Delete() {
  		$msg = null;
  		 
  		if($this['id']) {
  			$this->db->ExecuteQuery(self::SQL('delete content'), array($this['id']));
  			$msg = 'delete';
  		} else {
  			$this->AddMessage('info', "Cannot find any id that match the content in the database!");
  			return false;
  		}
  		$rowcount = $this->db->RowCount();
  		 
  		if($rowcount) {
  			$this->AddMessage('success', "Successfully {$msg} content.");
  		} else {
  			$this->AddMessage('error', "Failed to {$msg} content.");
  		}
  		return $rowcount === 1;
  	}
  	
  	/**
  	 * Delete all content.
  	 *
  	 * @returns boolean true if success else false.
  	 */
  	public function DeleteAll() {
  		$msg = null;
  			
  		$this->db->ExecuteQuery(self::SQL('delete all content'));
  		$msg = 'delete';
  			
  		$rowcount = $this->db->RowCount();
  			
  		if($rowcount) {
  			$this->AddMessage('success', "Successfully {$msg} all content.");
  		} else {
  			$this->AddMessage('error', "Failed to {$msg} all content.");
  		}
  		return $rowcount === 1;
  	}
    

  	/**
 	 * Load content by id.
	 *
	 * @param $id integer the id of the content.
	 * @returns boolean true if success else false.
	 */
  	public function LoadById($id) {
    	$res = $this->db->ExecuteSelectQueryAndFetchAll(self::SQL('select * by id'), array($id));
    	
    	if(empty($res)) {
      		$this->AddMessage('error', "Failed to load content with id '$id'.");
      		return false;
    	} else {
      		$this->data = $res[0];
    	}
    	
    	return true;
  	}
  
  
  	/**
	 * List all content.
	 *
	 * @param $args array with various settings for the request. Default is null.
	 * @returns array with listing or null if empty.
	 */
  	public function ListAll($args=null) {
    	try {
      		if(isset($args) && isset($args['type'])) {
        		return $this->db->ExecuteSelectQueryAndFetchAll(self::SQL('select * by type', $args), array($args['type']));
      		} else {
        		return $this->db->ExecuteSelectQueryAndFetchAll(self::SQL('select *', $args));
      		}
    	} catch(Exception $e) {
      		echo $e;
      		return null;
    	}
  	}
  	
	/**
	 * Filter content according to a filter.
	 *
	 * @param $data string of text to filter and format according its filter settings.
	 * @returns string with the filtered data.
	 */
	public static function Filter($data, $filter) {
		switch($filter) {
			case 'bbcode': $data = nl2br(bbcode2html(htmlEnt($data))); break;
			case 'plain':
			default: $data = nl2br(makeClickable(htmlEnt($data))); break;
        }
		return $data;
	}
  	
  	/**
  	 * Get the filtered content.
  	 *
  	 * @returns string with the filtered data.
  	 */
  	public function GetFilteredData() {
  		return $this->Filter($this['data'], $this['filter']);
  	}
}