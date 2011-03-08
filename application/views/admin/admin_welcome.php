
<div id="column1" class="column span-24" style=" margin-top:20px;">
<h1>Trash Can Manager Control Panel</h1>
<hr />

  <div class="span-10">
      <p>
          <a href="/admin/index"><img src="/assets/images/icons/48x48/home.png" alt=""></a>
          <a href="/admin/custedit"><img src="/assets/images/icons/48x48/business_user_edit.png" alt=""></a>
          <a href="/admin/settings/"><img src="/assets/images/icons/48x48/process.png" alt=""></a>
      </p>
  </div>
    <p class="clear">Hi, <strong><?php echo $username; ?></strong>! You are logged in now.
        <?php echo anchor('/auth/logout/', 'Logout'); ?></p>

        <div class="span-24">
  
            <div class="span-16" id="tablewrap">
                <h3>Customers</h3>
  <table id="customerTable" class="span-16 stripeme tablesorter">
  	<thead>
    	<tr>
        	<th>Last Name</th>
            <th>First Name</th>
            <th>City</th>
            <th>Phone Number</th>
            <th>Edit</th>
            <th>Trash Cans</th>
            <th>Archive</th>
        </tr>
    </thead>
    <tbody>

	<?php if($customers->num_rows() > 0) : foreach ($customers->result() as $row): ?>

		<tr>
        	<td>
                <p><a href="/admin/customerview/<?=$row->custid ?>"><?=$row->lastname ?></a></p>
            </td>
            <td><p><?=$row->firstname ?></p></td>
            
         <td>
            <p><?=$row->city ?></p>
		</td>
      
        <td>
            <p><?=$row->phonenumber ?></p>
        </td>

            <td>
                <a href="/admin/custedit/<?=$row->custid ?>"><img alt="Edit Customer" src="/assets/images/icons/32x32/business_user_edit.png"></a>
            </td>

            <td>
                <a href="/admin/trashcans/<?=$row->custid ?>"><?=$row->quantity ?> Cans</a>
            </td>
			
        <td>
            <a href="/admin/archiveCustomer/<?=$row->custid ?>"><img alt="Archive Customer" src="/assets/images/icons/32x32/business_user_delete.png"></a>
        </td>
      
        </tr>

  
	<?php endforeach; ?>  

    <?php else : ?>
    
    <td>

    <p>No Businesses Here!</p>

</td>

    

    <?php endif; ?>
	
    </tbody>
    </table>

    <div id="pager" class="span-16 pager clear" style="margin-bottom:3em;">
        <form>
            <img src="/assets/images/pager/icons/first.png" class="first"/>
            <img src="/assets/images/pager/icons/prev.png" class="prev"/>
            <input type="text" class="pagedisplay"/>
            <img src="/assets/images/pager/icons/next.png" class="next"/>
            <img src="/assets/images/pager/icons/last.png" class="last"/>
            <select class="pagesize">
                <option selected="selected"  value="10">10</option>

                <option value="20">20</option>
                <option value="30">30</option>
                <option  value="40">40</option>
            </select>
        </form>
    </div>

    </div><!-- End Table Wrap -->

            <div class="span-7" id="pastdues">
                <h3>Past Due Accounts</h3>
                <p>&nbsp;</p>
               <?php /* ?> <?php if($pastdueinvoices->num_rows() > 0) : foreach ($pastdueinvoices->result() as $row) : ?>
                <?php endforeach; ?>

                <?php else : ?>
                    <p class="notice">No Past Due Invoices</p>
                <?php endif; ?> <?php */ ?>
            </div><!-- End Past Due Accounts -->


        </div>


    <div class="span-24">

        <h2>Create A New Customer</h2>

        <?php

            $attributes = array(
                'userid' => $user_id,
                'goback' => '/admin/index',
                'custid' => ''
            );
         
        ?>

        <?php echo form_open('/admin/updateCustomer', '', $attributes) ?>

            <div class="span-24">
                <div class="span-6"><h4>Customers Name</h4></div>
                <div class="span-8">
                    <?php echo form_label('Last Name', 'lastname'); echo form_input('lastname',''); ?>
                </div>
                <div class="span-8">
                    <?php echo form_label('First Name', 'firstname'); echo form_input('firstname',''); ?>
                </div>
            </div>

            <div class="span-24">
                <div class="span-6"><h4>Customers Address</h4></div>
                <div class="span-8">
                    <?php echo form_label('Street Address', 'street1'); echo form_input('street1',''); ?>
                </div>
                <div class="span-8">
                    <?php echo form_label('Apartment or Suite', 'street2'); echo form_input('street2',''); ?>
                </div>
                <div class="span-8">
                    <?php echo form_label('City','city'); echo form_input('city',''); ?>
                </div>
                <div class="span-8">
                    <?php echo form_label('State','state'); echo form_input('state',''); ?>
                </div>
                <div class="span-6"><p>&nbsp;</p></div>
                <div class="span-8">
                    <?php echo form_label('Zip','zip'); echo form_input('zip',''); ?>
                </div>
                <div class="span-8">
                    <?php echo form_label('Phone Number','phonenumber'); echo form_input('phonenumber',''); ?>
                </div>
            </div>
        <div class="span-24">
            <div class="span-6">
                <?php echo form_submit('submit','Add A Customer'); ?>
            </div>
        </div>

        <?php echo form_close(); ?>

    </div>
    



  
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