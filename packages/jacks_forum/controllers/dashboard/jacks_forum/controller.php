<?php   
defined('C5_EXECUTE') or die(_("Access Denied."));
class DashboardJacksForumController extends Controller {
	public $helpers = array("form");
	
	public function view(){
		$this->set('cID', Config::get('rss_import_parent'));
	}
	public function save(){
		Config::save('basic_forum_parent', $this->post('cID'));
		$this->set('message',t('Settings saved.'));
		$this->view();
	}
}
?>