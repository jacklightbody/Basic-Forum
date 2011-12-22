<?php   
defined('C5_EXECUTE') or die(_("Access Denied."));	
$h = Loader::helper('concrete/interface');?>
	<?php echo Loader::helper('concrete/dashboard')->getDashboardPaneHeaderWrapper(t('Basic Forum'));?>
   	<form method="post" action="<?php   echo $this->action('save')?>" class="form-stacked">
   		<label for="cID"><b><?php  echo t('Parent Page');?></b></label>
<?php  $formp = Loader::helper('form/page_selector');
echo  $formp->selectPage('cID', $cID);
echo $form->label('cID',t('This is the page that all new topics will go under.'));
           echo  $h->submit(t('Save'));?>
	</form>