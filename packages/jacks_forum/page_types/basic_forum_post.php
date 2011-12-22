<?php defined('C5_EXECUTE') or die("Access Denied."); ?>
<div class="pageSection">
	<h1><?php echo $c->getCollectionName(); ?></h1>
	<p class="meta"><?php echo t('Posted by')?> <?php echo $c->getVersionObject()->getVersionAuthorUserName(); ?> on <?php echo $c->getCollectionDatePublic('F j, Y'); ?></p>		
</div>
<div class="pageSection" id="topic">
	<?php $a = new Area('Topic'); $a->display($c); ?>
</div>
<div class="pageSection" id="replies">
	<?php $a = new Area('Topic Replies'); $a->display($c); ?>
</div>