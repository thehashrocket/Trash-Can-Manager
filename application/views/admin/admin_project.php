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



  <p>Hi, <strong><?php echo $username; ?></strong>! You are logged in now. <?php echo anchor('/auth/logout/', 'Logout'); ?></p>







    <div id="Create Project">



		<?=form_open_multipart('/admin/updateProject'); ?>



		<?=form_hidden('redirect', '/admin/index'); ?>



       <?php if(count($projects)) : foreach ($projects->result() as $row): ?>



                <input type="hidden" name="id" value="<?=$row->id?>">



		<p><?=form_label('Name', 'name')?><br/>

            <input name="name" type="text" value="<?=$row->projname ?>"/>

        </p>



       <p>

           <?=form_label('Short Description', 'projshortdesc')?><br/>

           <input name="shortdesc" type="text" value="<?=$row->projshortdesc ?>"/>

       </p>



		<p>

            <?=form_label('Description', 'description')?><br/>

            <textarea name="desc", rows="5", cols="75"><?=$row->projdesc ?></textarea>

        </p>



        <p>

            <?=form_label('Description', 'description')?><br/>

            <textarea name="systemfacts", rows="5", cols="75"><?=$row->projsystemfacts ?></textarea>

        </p>





	   <p><?=form_label('Please Choose a Category', 'category')?><br/>



	     <select name="category">



            <?php foreach ($categories->result() as $row): ?>



            <option value="<?=$row->id?>" > <?=$row->catname?></option>



            <?php endforeach; ?>



    </select></p>







	    <?php

			$btn_submit = array(

				'type' => 'image',

				'src' => base_url() . '/assets/images/icons/accept.png',

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

<!-- End Create Project -->



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