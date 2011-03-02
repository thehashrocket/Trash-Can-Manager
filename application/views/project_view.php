
<div id="column1" class="column span-24" style=" margin-top:20px;">

<h1>Stockbridge Energy Group Projects</h1>
<hr />
<div class="span-15">
<?php if (isset($project) && count($project)) : foreach ($project->result() as $row): ?>

        <h2><?=$row->projname ?></h2>
        <p><?=$row->projdesc ?></p>


</div>

    <div id="systemfacts" class="span-8 floatright">

        <h3>System Facts</h3>

        <p><?=$row->projsystemfacts ?></p>

    </div>

        <?php endforeach; ?>

<?php else: ?>



        <p class="notice">You have not chosen a project. Please go back and try again.</p>

        <?php endif; ?>

   <p>&nbsp;</p>

    <div class="span-24 clear">
        
<h2>Photo Gallery</h2>
    <div id="gallery">
		<?php if (isset($photos) && count($photos)):
			foreach($photos->result() as $photo): ?>
                <div class="thumb" >
                    <a class="lightbox" href="<?=$photo->fullsize ?>">
                    <img src="<?=$photo->thumb ?>" />
                    </a>
                </div>
			<?php endforeach; else: ?>
			<div id="blank_gallery">No Images have been uploaded!</div>
        <?php endif; ?>
    </div>

        </div>
    <p>&nbsp;</p>

</div>