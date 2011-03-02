
<div id="column1" class="column span-24" style=" margin-top:20px;">

<h1>Contact Stockbridge Energy Group!</h1>
<hr />

<p><a href="/assets/images/large/DSC00199.jpg" class="lightbox"><img class="floatright" src="/assets/images/medium/DSC00199.jpg" width="350" height="263" alt="Stockbridge Regional Solar Installation Provider" /></a>If you have any questions or comments, please fill out the form below and a representative from Stockbridge Energy Group will respond as soon as possible.  You can also reach us by calling at (928) 634-0306 or Fax us at (928) 637-6471. Mail us at P.O. Box 869 Cottonwood, AZ 86326 </p>

<p class="phone">phone: (928) 634-0306</p>
<p class="fax">fax: (928) 634-6471</p>
<p class="email"><a href="mailto:sales@stockbridgeenergygroup.com">Email Us</a></p>
<div class="span-23" style="margin-left:15px;">
  
  
<?php echo validation_errors('<p class="error">'); ?>

<div style="clear:both" >
<?php echo form_open('/email/send'); ?>

<p><h5>Name</h5>
<input type="text" name="name" value="" size="50" /></p>

<p><h5>Contact Phone</h5>
<input type="text" name="phone" value="" size="50" /></p>

<p><h5>Email Address</h5>
<input type="text" name="email" value="" size="50" /></p>

<p><h5>Subject</h5>
<input type="text" name="subject" value="" size="50" /></p>

<p><h5>Message</h5>
<?php echo form_textarea('comments','Enter Comments Here'); ?></p>
<p><?= $recaptcha ?></p>
<div><INPUT TYPE="image" SRC="/assets/images/icons/48x48/mail_accept.png" HEIGHT="48" WIDTH="48" BORDER="0" ALT="Submit Form"></div>

</form></div>
  
</div>
</div>