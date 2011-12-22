<?php 
defined('C5_EXECUTE') or die("Access Denied.");
class BasicForumSubmitBlockController extends BlockController {		
	protected $btTable = 'btBasicForumSubmit';
	protected $btInterfaceWidth = "300";
	protected $btInterfaceHeight = "260";	
	protected $btIncludeAll = 1;
	
	/** 
	 * Used for localization. If we want to localize the name/description we have to include this
	 */
	public function getBlockTypeDescription() {
		return t("Provides a form for forum submissions.");
	}
	
	public function getBlockTypeName() {
		return t("New Forum Topic");
	}			
	public function on_page_view(){	
			$html = Loader::helper('html');
 			$this->addHeaderItem($html->javascript('tiny_mce/tiny_mce.js'));
		$this->addHeaderItem("<script type=\"text/javascript\"> tinyMCE.init({ mode : \"textareas\", width: \"100%\", inlinepopups_skin : \"concreteMCE\", theme_concrete_buttons2_add : \"spellchecker\", relative_urls : false, convert_urls: false, theme : \"advanced\",  theme_advanced_buttons1 : \"bold,italic,underline,strikethrough,|,justifyleft,justifycenter,justifyright,justifyfull,|,bullist,numlist,|,outdent,indent,blockquote,|,link,unlink,anchor,image,cleanup,code,charmap\",   theme_advanced_buttons2 : '', theme_advanced_buttons3 : '', theme_advanced_toolbar_location : \"top\", theme_advanced_toolbar_align : \"left\", plugins: \"inlinepopups,spellchecker,safari,advlink\", editor_selector : \"advancedComment\", spellchecker_languages : \"+English=en\"  });  </script> ");
	}
	function action_form_save_entry() {	
		$ip = Loader::helper('validation/ip');
		if (!$ip->check()) {
			$this->set('invalidIP', $ip->getErrorMessage());			
			return;
		}
		// get the cID from the block Object
		$bo = $this->getBlockObject();
		$c = Page::getCurrentPage();
		$cID = $c->getCollectionID();
	
		$v = Loader::helper('validation/strings');
		$errors = array();
		
		$u = new User();
		$uID = intval($u->getUserID());
		if(!$u->isLoggedIn()){
				$errors['notLogged'] = '- '.t("Your session has expired.  Please log back in."); 
		}
		
		// check captcha if activated
		if ($this->displayCaptcha) {
		   $captcha = Loader::helper('validation/captcha');
		   if (!$captcha->check()) {
		      $errors['captcha'] = '- '.t("Incorrect captcha code");
		   }
		}
		if(!$v->notempty($_POST['message'])) {
			$errors['message'] = '- '.t("Post content is required");
		}
		
		if(count($errors)){
			$this->set('response', t('Please correct the following errors:') );
			$this->set('errors',$errors);
		} else {
			Loader::model('userinfo');
			$ui = UserInfo::getByID($uID);
			$fromEmail=$ui->getUserEmail();
			$fromName=$ui->getUserName();
			$name=strip_tags($_POST['title']);
			//its a valid post	
			$dh=loader::helper('date');
			$txt=loader::helper('text');
			$nh=loader::helper('navigation');
			$cDatePublic = $dh->getSystemDateTime();
			$pData = array('uID' => $uID, 'cName' => $txt->sanitize($name), 'cHandle' => $txt->sanitize($name), 'cDatePublic' => $cDatePublic);
			$page = Page::getByID(Config::get('basic_forum_parent'));
			if(!$page){
				$page = Page::getByID('1');
			}
			$message=strip_tags($_POST['message'],'<ul>,<li>,<a>,<ol><strong><em><span><blockquote><img>');
			$antispam = Loader::helper('validation/antispam');
			if (!$antispam->check($_POST['commentText'], 'guestbook_block', array('email' => $_POST['email']))) { 
				$this->set('response', t('Please correct the following errors:') );
				$errors['message'] = '- '.t("Your topic has been flagged as spam.");
				$this->set('errors',$errors);
				exit;
			}
			$ct = CollectionType::getByHandle('basic_forum_post');
			$newPage = $page->add($ct, $pData);  
			$contentBT = BlockType::getByHandle('content');
    		$data = array('content'=>$message);
    		$newPage->addBlock($contentBT, 'Topic', $data);
    		$guestBookBT = BlockType::getByHandle('guestbook'); //grabbing a guestbook block
    		$guestbookArray = array();
    		$guestbookArray['requireApproval'] = 0;
    		$guestbookArray['title'] = t('Reply to this topic');
    		$guestbookArray['displayCaptcha'] = 1;
    		$guestbookArray['displayGuestBookForm'] = 1;
    		$newPage->addBlock($guestBookBT, 'Topic Replies', $guestbookArray);
    		Loader::helper('navigation');
 			$url=NavigationHelper::getLinkToCollection($newPage, true);
			Header( "Location: ".$url); 
		}
	}
	
	
} 