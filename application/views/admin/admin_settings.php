<div id="column1" class="column span-24" style=" margin-top:20px;">

    <h1>Trash Can Manager Control Panel: Client Settings</h1>

    <hr/>



    <div class="span-10">

        <p>

            <a href="/admin/index"><img src="/assets/images/icons/48x48/home.png" alt=""></a>

            <a href="/admin/custedit"><img src="/assets/images/icons/48x48/business_user_edit.png" alt=""></a>

            <a href="/admin/settings"><img src="/assets/images/icons/48x48/process.png" alt=""></a>

        </p>

    </div>



    <p class="clear">Hi, <strong><?php echo $username; ?></strong>! You are logged in now.

        <?php echo anchor('/auth/logout/', 'Logout'); ?></p>



    <div id="ClientSetup" class="container">





        <?php

        $attributes = array(

        'userid' => $user_id,

        'goback' => '/admin/settings'



    );



        ?>

        <?=form_open_multipart('/admin/updateClient', '', $attributes); ?>





        <?=form_fieldset('Update Your Information'); ?>



        <div class="span-21">

            <div class="span-5">

                <p>

                    <?=form_label('Company Name', 'companyname')?><br/>

                    <input name="companyname" type="text" value="<?=$client->companyname; ?>"/>

                </p>

            </div>



            <div class="span-5">

                <p>

                    <?=form_label('Company Address', 'costreet')?><br/>

                    <input name="costreet" type="text" value="<?=$client->costreet ?>"/>

                </p>

            </div>

        </div>



        <div class="span-20">

            <div class="span-5">

                <p>

                    <?=form_label('Company City', 'cocity')?><br/>

                    <input name="cocity" type="text" value="<?=$client->cocity ?>"/>

                </p>

            </div>



            <div class="span-5">

                <p>

                    <?=form_label('Company State', 'costate')?><br/>

                    <input name="costate" type="text" value="<?=$client->costate ?>"/>

                </p>

            </div>



        </div>



        <div class="span-20">

            <div class="span-5">

                <p>

                    <?=form_label('Company Zip', 'cozip')?><br/>

                    <input name="cozip" type="text" value="<?=$client->cozip ?>"/>

                </p>

            </div>



            <div class="span-5">

                <p>

                    <?=form_label('Company Phone', 'cophone')?><br/>

                    <input name="cophone" type="text" value="<?=$client->cophone ?>"/>

                </p>

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



        <?=

        form_fieldset_close()

        ; ?>



        <?=

        form_close()

        ; ?>



        <?php echo validation_errors('<p class="error">'); ?>



    </div>

    <!-- End Client Setup -->



    <div id="TrashCans" class="container">





        <!-- New Trash Can Entry Form -->





        <?php $attributes = array(

        'userid' => $user_id,

        'goback' => '/admin/settings'

    ); ?>



        <?=form_open_multipart('/admin/updateTrashCan', '', $attributes); ?>

        <?=form_fieldset('New Trash Can Type'); ?>

        <div class="span-22">

            <div class="span-5">

                <?=form_label('Trashcan Size', 'trashcansize')?>

                <?=form_input('trashcansize', '');?>

            </div>

            <div class="span-5">

                <?=form_label('Trashcan Type', 'trashcantype')?>

                <?=form_input('trashcantype', '');?>

            </div>

            <div class="span-5">

                <?=form_label('Trashcan Description', 'trashdescript')?>

                <?=form_input('trashdescript', '');?>

            </div>

            <div class="span-5">

                <?=form_label('Trash Can Price', 'trashcanprice')?>

                <?=form_input('trashcanprice', '');?>

            </div>

            <div class="span-1 last">

                <?=form_label('Add', 'addbutton')?>

                <?php

                $btn_submit = array(

                    'type' => 'image',

                    'src' => base_url() . '/assets/images/icons/32x32/page_add.png',

                    'name' => 'image',

                    'width' => '32',

                    'height' => '32',

                    'value' => 'submit'

                );



                    echo form_input($btn_submit);

                ?>

            </div>

        </div>

        <?=form_fieldset_close(); ?>

        <?=

        form_close()

        ; ?>







            <?php echo validation_errors('<div class="error">', '</div>'); ?>





        <!-- End New Can Entry Form -->





        <!-- Begin Edit Trash Cans -->



        <?php if($trashcans->num_rows() > 0) : foreach ($trashcans->result() as $row): ?>



             <?php

                $attributes = array(

                    'userid' => $user_id,

                    'goback' => '/admin/settings',

                    'idtrashcans' => $row->idtrashcans

                );

            ?>



        <?=form_open_multipart('/admin/updateTrashCan', '', $attributes); ?>

        <?= form_fieldset()

        ; ?>

        <div class="span-22">

            <div class="span-5">

                <?=form_label('Trashcan Size', 'trashcansize')?>

                <input name="trashcansize" type="text" value="<?=$row->cansize ?>"/>

            </div>

            <div class="span-5">

                <?=form_label('Trashcan Type', 'trashcantype')?>

                <input name="trashcantype" type="text" value="<?=$row->cantype  ?>"/>

            </div>

            <div class="span-5">

                <?=form_label('Trashcan Description', 'trashdescript')?>

                <input name="trashdescript" type="text" value="<?=$row->description ?>"/>

            </div>

            <div class="span-5">

                <?=form_label('Trashcan Price', 'trashcanprice')?>

                <input name="trashcanprice" type="text" value="<?=$row->price ?>"/>

            </div>

            <div class="span-1">

                <?=form_label('Edit', 'editbutton')?>

                <?php

            $btn_submit = array(

        'type' => 'image',

        'src' => base_url() . '/assets/images/icons/32x32/page_edit.png',

        'name' => 'image',

        'width' => '32',

        'height' => '32',

        'value' => 'submit'

    );



        echo form_input($btn_submit);

        ?>



        <?=

        form_close()

        ; ?>

            </div>

            <div class="span-1 last">

                <?=form_label('Archive', 'archive')?>

                <a href="/admin/archiveTrashCan/<?=$user_id?>/<?=$row->idtrashcans?>">

                    <img src="/assets/images/icons/32x32/page_delete.png">

                </a>

            </div>

        </div>

        <?= form_fieldset_close()

        ; ?>



        <?php endforeach; ?>



        <?php else : ?>

        <div class="span-20">

            <p class="notice">No trashcans currently setup!</p>

        </div>

        <?php endif; ?>



        <!-- End Edit Trash Cans -->



    </div>

    <!-- End TrashCans Setup -->



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

                + "a[href|target|name|title],"

                + "p,"



    });

</script>



