
<div id="column1" class="column span-24" style=" margin-top:20px;">

<h1>Stockbridge Energy Group Projects</h1>
<hr />
<div class="span-24">
<?php if (isset($news) && count($news)) : foreach ($news->result() as $row): ?>

        <h2><?=$row->headline ?></h2>
        <p><?=$row->story ?></p>
<?php endforeach; ?>

<?php else: ?>

        <p class="notice">You have not chosen a project. Please go back and try again.</p>

        <?php endif; ?>

</div>







</div>