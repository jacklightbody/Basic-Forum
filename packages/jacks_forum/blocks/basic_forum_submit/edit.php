<?php  defined('C5_EXECUTE') or die("Access Denied."); ?> 
<?php  echo t('Solving a <a href="%s" target="_blank">CAPTCHA</a> Required to Post?', 'http://en.wikipedia.org/wiki/Captcha')?><br/>
<input type="radio" name="displayCaptcha" value="1" <?php  echo ($displayCaptcha?"checked=\"checked\"":"") ?> /><?php  echo t('Yes')?><br />
<input type="radio" name="displayCaptcha" value="0" <?php  echo ($displayCaptcha?"":"checked=\"checked\"") ?> /> <?php  echo t('No')?><br /><br />
