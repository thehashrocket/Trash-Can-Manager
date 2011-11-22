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

        <div class="span-7" id="invoicelist">
            <?=form_open('admin/receivepayment'); ?>
            <?=form_hidden('custid', $custid); ?>
            <?=form_fieldset('Choose an Invoice'); ?>

            <?=form_label('Invoice Number: ', 'invoicenumber')?>

            <select name="invoice">

                <?php if (isset($invoices) && count($invoices)): foreach ($invoices->result() as $row): ?>

                <option value="<?=$row->unique_id?>"> <?=$row->invoice_number?>
                    - <?=$row->date_entered?></option>

                <?php endforeach; else: ?>

                <option value="NULL">No Invoices</option>

                <?php endif; ?>

            </select>
            <?=form_submit('submit', 'Get Invoice'); ?>
            <?=form_fieldset_close(); ?>
            <?=form_close(); ?>

        </div>

        <div class="span-15 last" id="invoicedisplay">
            <?=form_open('admin/MakePayment');?>
            <?=form_hidden('custid', $custid); ?>
            <?=form_hidden('invid', $invid); ?>
            <?=form_fieldset('Customer Invoice');?>
            <div class="span-15">

            <?php if (isset($invoice) && count($invoice)): foreach ($invoice->result() as $row): ?>

                <div class="span-5"><p><label>Invoice Number: </label><?=$row->invoice_number?></p></div>
                <div class="span-5"><p><label>Amount Due:</label><?=$row->amount?></p></div>
                <div class="span-5 last"><p><?=form_label('Payment Amount: ', 'payment');?><?=form_input('payment');?></p></div>

        <?php endforeach; else: ?>
            <p>No Invoice To Dislay</p>
        <?php endif; ?>

                </div>

            <div class="panel span-15 clear">
                <p>Choose a payment method.</p>
                <p>You can choose between cash, check, or credit card.</p>
                <div class="span-15">
                    <p>
                        <input type="radio" name="cash" value="cash">Cash |
                        <input type="radio" name="check" value="check">Check |
                        <input type="radio" name="credit" value="credit">Cash
                    </p>
                </div>
                <?=form_submit('submit', 'Submit Payment');?>
            </div>

<p class="flip">Show/Hide Panel</p>



            <table id="customerTable" class="span-15 stripeme tablesorter">

  	<thead>

    	<tr>

            <th>Description</th>
            <th>Quantity</th>
            <th>Total</th>

        </tr>

    </thead>

    <tbody>
            <?php if (isset($invoicerows) && count($invoicerows)): foreach ($invoicerows->result() as $row): ;?>
                <tr>
                    <td><?=$row->description?></td>
                    <td><?=$row->qty?></td>
                    <td><?=$row->total?></td>
                </tr>
            <?php endforeach; else:?>
                <tr><td colspan="3">No Items</td></tr>
            <?php endif;?>
            </tbody>
        </table>


            <?=form_fieldset_close();?>
            <?=form_close();?>
        </div>


    </div>


</div>
<style type="text/css">
    div.panel,p.flip
    {
        margin:0px;
        padding:5px;
        text-align:center;
        background:#e5eecc;
        border:solid 1px #c3c3c3;
    }

    div.panel
    {
        height:auto;
        display:none;
    }
</style>
    
    <script type="text/javascript">
$(document).ready(function(){
$(".flip").click(function(){
    $(".panel").slideToggle("slow");
  });
});
</script>


