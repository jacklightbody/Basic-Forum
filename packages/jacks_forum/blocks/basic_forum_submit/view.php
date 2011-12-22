<?php  defined('C5_EXECUTE') or die("Access Denied.");
$page=Page::getCurrentPage(); ?>
<?php  echo $response;?>
<?php  if (!$u->isLoggedIn()) { ?>
				<div><?php  echo t('You must be logged in to submit a forum topic.') ?> <a href="<?php  echo View::url("/login", "forward", $page->getCollectionID()) ?>">
				<?php  echo t('Login') ?> &raquo;</a></div>
			<?php 
			} else {
				?>
				<a name="guestBookForm-<?php  echo $controller->bID ?>"></a>
				<div id="guestBook-formBlock-<?php  echo $controller->bID ?>" class="guestBook-formBlock">
					<h5 class="guestBook-formBlock-title"><?php  echo t('Submit a Forum Topic') ?></h5>
					<form method="post" action="<?php  echo $this->action('form_save_entry', '#basic-forum-' . $controller->bID) ?>">
							<input type="hidden" name="entryID" value="<?php  echo $Entry->entryID ?>" />
									<?php $ui = UserInfo::getByID($u->getUserID());?>
								<input type="hidden" id="inputname" name="name" value="<?php echo  $ui->getUserName(); ?>">
								<input type="hidden" id="inputemail" name="email" value="<?php echo  $ui->getUserEmail(); ?>">
							<div class="title line input-row <?php  if (isset($errors['title']))
					echo " error"; ?>">
									<label for="email"><?php  echo t('Subject:') ?></label><br/>				
									<input type="text" id="title" name="title"/>
									<?php  echo (isset($errors['title']) ? "<span class=\"error-message\">" . $errors['title'] . "</span>" : "") ?> 				
								</div>
						<div class="commentText line input-row <?php  if (isset($errors['commentText']))
						echo " error"; ?>">	
							<label for="commentText"><?php  echo t('Message:')?></label><br/>		
							<textarea name="message" id="message" id="advancedComment<?php  echo $bID ?>"class="advancedComment"></textarea>
							<?php  echo (isset($errors['message']) ? "<span class=\"error-message\">" . $errors['message'] . "</span>" : "") ?>
						</div>	
						<div class="captcha line input-row <?php  if (isset($errors['captcha']))
						echo " error"; ?>">				
						<?php 
							if($controller->displayCaptcha) {
							$captcha = Loader::helper('validation/captcha');				
   							$captcha->label();
   							$captcha->showInput();
							$captcha->display();
							echo isset($errors['captcha'])?'<span class="error">' . $errors['captcha'] . '</span>':'';	
						} ?>
						</div>
						<div class="submit line input-row">	
							<input type="submit" name="Submit Forum Topic" value="<?php  echo t('Submit Forum Topic') ?>" class="button"/>
						</div>
					</form>
				</div>
	<?php  } ?>
