
<div id="column1" class="column span-24" style=" margin-top:20px;">

<h1>Client Control Panel: Photo Manager</h1> 
<hr />
   <div class="span-10">
      <p>
          <a href="/admin/index"><img src="/assets/images/icons/48x48/home.png" alt=""></a>
          <a href="/admin/custedit"><img src="/assets/images/icons/48x48/business_user_edit.png" alt=""></a>
          <a href="/admin/settings"><img src="/assets/images/icons/48x48/process.png" alt=""></a>
      </p>
  </div>
   <p>You are logged in as <strong><?=$username?></strong> working on <?=$proj_id?>.</p>

		<h2>Photo Gallery</h2>
    <div id="gallery">
		<?php if (isset($photos) && count($photos)): 
			foreach($photos->result() as $photo): ?>
                <div class="adminthumb" >
                    <div class="deleteimage"><a href="/admin/deletePhoto/<?=$photo->id ?>/<?=$photo->projid ?>"><img src="/assets/images/icons/48x48/image_delete.png" alt="Delete Image"></a></div>
                    <a class="lightbox" href="<?=$photo->fullsize ?>">
                    <img src="<?=$photo->thumb ?>" />
                    </a>

                </div>
			<?php endforeach; else: ?>
			<div id="blank_gallery">No Images have been uploaded!</div>
        <?php endif; ?>
    </div>
	
	<div id="upload">
		<?php
		$redirect = current_url();
		echo form_open_multipart('/admin/gallery_up/');
		echo form_hidden('redirect', $redirect);
		echo form_hidden('projid', $proj_id);
		echo form_upload('userfile');
		echo form_submit('upload', 'Upload');
		echo form_close();
		?>		
	</div>
    
    <?php echo validation_errors('<p class="error">'); ?>
  
</div>