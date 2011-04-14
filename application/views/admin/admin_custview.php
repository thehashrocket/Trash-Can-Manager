<div id="column1" class="column span-24" style=" margin-top:20px;">

<h1>Trash Can Manager: Customer View</h1>

<hr />



    <div class="span-10">

      <p>

          <a href="/admin/index"><img src="/assets/images/icons/48x48/home.png" alt=""></a>

          <a href="/admin/custedit"><img src="/assets/images/icons/48x48/business_user_edit.png" alt=""></a>

          <a href="/admin/settings"><img src="/assets/images/icons/48x48/process.png" alt=""></a>

      </p>

  </div>



  <p class="clear">Hi, <strong><?php echo $username; ?></strong>! You are logged in now. <?php echo anchor('/auth/logout/', 'Logout'); ?></p>







    <div id="ViewCustomer" class="container">



       <?php if($customer->num_rows() > 0) : foreach ($customer->result() as $row): ?>



        <div class="container">



            <div class="span-9 colborder">



                <div class="span-9">

                    <h2>Customer Details</h2>

                    <div class="span-8 last">

                        <p>

                            Name: <?=$row->lastname ?>, <?=$row->firstname ?>

                        </p>

                    </div>

                </div>



                <div class="span-9">

                    <div class="span-8 last">

                        <p>

                            Address: <?=$row->street1 ?>, <?=$row->street2 ?>

                        </p>

                    </div>

                </div>



                <div class="span-9">

                    <div class="span-8 last">

                        <p>

                            <?=$row->city?>, <?=$row->state?> <?=$row->zip ?>

                        </p>

                    </div>

                </div>



                <div class="span-9">

                    <div class="span-8 last">

                        <p>

                            Tel: <?=$row->phonenumber ?>

                        </p>

                    </div>

                </div>



                <div class="span-9">

                    <div class="span-8 last">

                        <p>

                            Customer Created: <?=$row->created ?>

                        </p>

                    </div>

                </div>



                <div class="span-9">

                    <h3>Customer Trash Cans</h3>

                    <pre><?  // print_r($trashcans); ?></pre>

                    <table>

                        <thead><tr><th>Type</th><th>Quantity</th></tr></thead>

                    <?php if($trashcans->num_rows() > 0) : foreach ($trashcans->result() as $row): ?>

                        <tr><td><p><?=$row->cantype?></p></td><td><p><?=$row->quantity?></p></td></tr>

                    <?php endforeach; ?>





                    <?php else : ?>

                        <tr><td colspan="2"><div class="span-9"><p class="notice">No Trash Cans</p> </div></td></tr>

                    <?php endif; ?>

                        </table>

                </div>



            </div>



            <div id="GoogleMap" class="span-10 last">

                <?php echo $onload; ?>

                <?php echo $map; ?>

                <?php echo $sidebar; ?>

            </div>



            <div class="span-23 clear">



                    <h2>Add Comments</h2>



                <div class="span-16">



                <?php

                    $attributes = array(

                        'userid' => $user_id,

                        'goback' => '/admin/customerview/'. $custid,

                        'custid' => $custid,

                    );

                ?>



                    <?=form_open_multipart('/admin/updateComment', '', $attributes); ?>

                    <textarea name="comment" rows="5" cols="45"></textarea>



                    <P>Select one or more comment types:</P>

                       <?php echo form_dropdown('commenttype', $select_options); ?>



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







                </div>

                    <div class="span-6">





                    </div>





                </div>



        </div>



        <?php endforeach; ?>



    <?php else : ?>



        <p class="notice">No Businesses Here!</p>



        <?php endif; ?>



        <div id="Comments" class="span-23">

            <h2>Customer Comments</h2>

            

            

            <?php if($comments->num_rows() > 0) : foreach ($comments->result() as $row): ?>

            <div class="span-18 comment">

                <div class="buttons span-3 colborder">

                    <img src="<?=$row->img?>"><br/>

                    <p>Comment Created:<br/> <?=$row->created?></p>

                </div>

                <div id="Comment" class="span-10 last">

                    <?=$row->comment?>

                </div>



            </div>



        <?php endforeach; ?>



        <?php else : ?>

            <div class="span-17"><p class="notice">No Messages</p> </div>

        <?php endif; ?>

        </div>



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