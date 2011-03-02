
<div id="column1" class="column span-24" style=" margin-top:20px;">

    <?php if(count($category) > 0) : foreach ($category->result() as $row) : ?>
<h1><?=$row->catname?></h1>
<hr />
<div class="span-24">
    <div class="span-14">
        <p><?=$row->description?></p>
    </div>
    <?php endforeach;?>
<? endif; ?>

    <div class="span-14">
        <table id="businessTable" class="tablesorter" style="clear:both;">
	<thead><tr><th>Thumbnail</th><th>Project Name</th><th>Project Description</th></tr></thead>
		<?php if(count($projlist) > 0) : foreach ($projlist->result() as $row): ?>

            <tr>
                <td><a href="/site/project/<?=$row->id?>"><img src="<?=$row->thumb?>"></a></td>
                <td><a href="/site/project/<?=$row->id?>"><?=$row->projname?></a></td>
                <td><?=$row->projshortdesc?></td>
            </tr>
        <?php endforeach; ?>

        <?php else : ?>
        <td colspan="4"><p>No Category Selected</p></td>

        <?php endif; ?>

</table>
    </div>
    <div class="span-5">
        <p><a href="/assets/images/large/DSC00088.jpg" class="lightbox"><img src="/assets/images/medium/DSC00088.jpg" width="350" height="263" alt="Stockbridge Regional Solar Installation Provider" /></a></p>
    </div>
</div>
<p>&nbsp;</p>



<p>&nbsp;</p>
</div>