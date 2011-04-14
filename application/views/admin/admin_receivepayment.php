<div id="column1" class="column span-24" style=" margin-top:20px;">

<h1>Trash Can Manager: Create Invoice</h1>

<hr />



    <div class="span-10">

      <p>

          <a href="/admin/index"><img src="/assets/images/icons/48x48/home.png" alt=""></a>

          <a href="/admin/custedit"><img src="/assets/images/icons/48x48/business_user_edit.png" alt=""></a>

          <a href="/admin/settings"><img src="/assets/images/icons/48x48/process.png" alt=""></a>

      </p>

  </div>



  <p class="clear">Hi, <strong><?php echo $username; ?></strong>! You are logged in now. <?php echo anchor('/auth/logout/', 'Logout'); ?></p>

    <div class="span-24">

        <div class="span-8" id="invoicelist">
            <?php if (isset($invoice))

            print_r($invoice, TRUE);

            else

            print "No Invoices";

            endif;
            ?>
        </div>

    </div>











</div>