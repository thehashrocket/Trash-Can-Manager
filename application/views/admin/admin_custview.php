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




       <?php if(count($customer)) : foreach ($customer->result() as $row): ?>

        <div class="container">

            <div class="span-9 colborder">

                <div class="span-9">
                    <div class="span-4 colborder">
                        <p>
                            <?=$row->lastname ?>
                        </p>
                    </div>

                    <div class="span-4 last">
                        <p>
                            <?=$row->firstname ?>
                        </p>
                    </div>
                </div>

                <div class="span-9">
                    <div class="span-4 colborder">
                        <p>
                            <?=$row->street1 ?>
                        </p>

                    </div>
                    <div class="span-4 last">
                        <p>
                            <?=$row->street2 ?>
                        </p>

                    </div>
                </div>

                <div class="span-9">
                    <div class="span-4 colborder">
                        <p>
                            <?=$row->city?>
                        </p>

                    </div>
                    <div class="span-4 last">
                        <p>
                            <?=$row->state?>
                        </p>

                    </div>
                </div>

                <div class="span-9">
                    <div class="span-4 colborder">

                        <p>
                            <?=$row->zip ?>
                        </p>

                    </div>
                    <div class="span-4 last">

                        <p>
                            <?=$row->phonenumber ?>
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