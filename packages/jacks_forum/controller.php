<?php       
defined('C5_EXECUTE') or die(_("Access Denied."));

class JacksForumPackage extends Package {

	protected $pkgHandle = 'jacks_forum';
	protected $appVersionRequired = '5.5';
	protected $pkgVersion = '.90';
	
	public function getPackageDescription() {
		return t("A very basic forum for your site.");
	}
	
	public function getPackageName() {
		return t("Basic Forum"); 
	}
	
	public function install() {
		$pkg = parent::install();
		//load
		Loader::model('single_page');
		Loader::model('collection_types');
		//add the dashboard pages
		$p = SinglePage::add('/dashboard/jacks_forum',$pkg);
		$p->update(array('cName'=>t("Basic Forum"),'cDescription'=>t("Manage your site forum.")));
		//install the blocks
		BlockType::installBlockTypeFromPackage('basic_forum_submit',$pkg);
		Config::save('basic_forum_parent', 1);
		$topic = CollectionType::getByHandle('basic_forum_post');
        if(!$topic || !intval($topic->getCollectionTypeID())){ 
            $topic = CollectionType::add(array('ctHandle'=>'basic_forum_post','ctName'=>t('Basic Forum Topic')),$pkg);
        }
	}
}