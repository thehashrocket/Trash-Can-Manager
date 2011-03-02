<div id="column1" class="column span-24" style=" margin-top:20px;">
<h1>Stockbridge Control Panel</h1>
<hr />

    <div class="span-10">
      <p>
          <a href="/admin/index"><img src="/assets/images/icons/48x48/home.png" alt=""></a>
          <a href="/admin/custedit"><img src="/assets/images/icons/48x48/business_user_edit.png" alt=""></a>
          <a href="/admin/settings"><img src="/assets/images/icons/48x48/process.png" alt=""></a>
      </p>
  </div>

  <p class="clear">Hi, <strong><?php echo $username; ?></strong>! You are logged in now. <?php echo anchor('/auth/logout/', 'Logout'); ?></p>



    <div id="EditCustomer" class="container">

        <?php

            $attributes = array(
                'userid' => $user_id,
                'goback' => '/admin/index'
            );

        ?>

		<?=form_open_multipart('/admin/updateCustomer', '', $attributes); ?>



       <?php if(count($customer)) : foreach ($customer->result() as $row): ?>

                <input type="hidden" name="custid" value="<?=$row->custid?>">

        <div class="container">

            <div class="span-9 colborder">

                <div class="span-9">
                    <div class="span-4 colborder">
                        <p>
                            <?=form_label('Last Name', 'lastname')?><br/>
                            <input name="lastname" type="text" value="<?=$row->lastname ?>"/>
                        </p>
                    </div>

                    <div class="span-4 last">
                        <p>
                            <?=form_label('First Name', 'firstname')?><br/>
                            <input name="firstname" type="text" value="<?=$row->firstname ?>"/>
                        </p>
                    </div>
                </div>

                <div class="span-9">
                    <div class="span-4 colborder">
                        <p>
                            <?=form_label('Street Address', 'street1')?><br/>
                            <input name="street1" type="text" value="<?=$row->street1 ?>"/>
                        </p>

                    </div>
                    <div class="span-4 last">
                        <p>
                            <?=form_label('Apartment or Suite', 'street2')?><br/>
                            <input name="street2" type="text" value="<?=$row->street2 ?>"/>
                        </p>

                    </div>
                </div>

                <div class="span-9">
                    <div class="span-4 colborder">
                        <p>
                            <?=form_label('City', 'city')?><br/>
                            <input type="text" value="<?=$row->city?>" name="city">
                        </p>

                    </div>
                    <div class="span-4 last">
                        <p>
                            <?=form_label('State', 'state')?><br/>
                            <input type="text" value="<?=$row->state?>" name="state">
                        </p>

                    </div>
                </div>

                <div class="span-9">
                    <div class="span-4 colborder">

                        <p>
                            <?=form_label('Zip', 'zip')?><br/>
                            <input name="zip" type="text" value="<?=$row->zip ?>"/>
                        </p>

                    </div>
                    <div class="span-4 last">

                        <p>
                            <?=form_label('Phone Number', 'phonenumber')?><br/>
                            <input name="phonenumber" value="<?=$row->phonenumber ?>" type="text">
                        </p>

                    </div>
                </div>

            </div>

            <div class="span-8 last">
                <?php echo $onload; ?>
                <?php echo $map; ?>
                <?php echo $sidebar; ?>
            </div>

        </div>

        <?php
			$btn_submit = array(
				'type' => 'image',
				'src' => base_url() . '/assets/images/icons/48x48/accept.png',
				'name' => 'image',
				'width' => '48',
				'height' => '48',
				'value' => 'submit'
				);

				echo form_input($btn_submit);
			?>

	   <?=form_fieldset_close(); ?>

	   <?=form_close(); ?>


       <?php echo validation_errors('<p class="error">'); ?>

        <?php endforeach; ?>

    <?php else : ?>

        <p>No Businesses Here!</p>

        <?php endif; ?>

</div>
<!-- End Edit Customer -->

</div>

<script type="text/javascript" src="/assets/js/tiny_mce/tiny_mce.js"></script>
<script type="text/javascript">

        tinyMCE.init({
            theme : "advanced",
            mode : "textareas",
            theme_advanced_buttons1 : "bold,italic,underline,strikethrough,|,justifyleft,justifycenter,justifyright,justifyfull,|,styleselect,formatselect,fontselect,fontsizeselect",
            theme_advanced_buttons2 : "cut,copy,paste,pastetext,pasteword,|,search,replace,|,bullist,numlist,|,outdent,indent,blockquote,|,undo,redo,|,link,unlink,anchor,image,cleanup,help,code,|,insertdate,inserttime,preview,|,forecolor,backcolor",
            theme_advanced_toolbar_location : "top",
            theme_advanced_toolbar_align : "left",
            theme_advanced_statusbar_location : "bottom",
            theme_advanced_resizing : true,
            plugin_insertdate_dateFormat : "%Y-%m-%d",
            plugin_insertdate_timeFormat : "%H:%M:%S",
            theme_advanced_toolbar_align : "left",
            theme_advanced_resize_horizontal : false,
            theme_advanced_resizing : true,
            apply_source_formatting : true,
            spellchecker_languages : "+English=en",
            extended_valid_elements :"img[src|border=0|alt|title|width|height|align|name],"
            +"a[href|target|name|title],"
            +"p,"

        });
</script>