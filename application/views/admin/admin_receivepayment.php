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







    <div id="InvoiceCustomer" class="span-22 clear">

        <?php



            $attributes = array(

                'userid' => $user_id,

                'custid' => $customer[0]->custid,

                'goback' => '/admin/index'

            );



        ?>



		<?=form_open_multipart('/admin/makeInvoice', '', $attributes); ?>

		<fieldset>



        <div class="span-22 row clear">

            <div class="span-5"><?php echo form_label('Invoice Number'); ?></div>

            <div class="span-10"><?php echo form_input('invoice_number', set_value('invoice_number'), 'id="invoice_number" class="txt"'); ?><em><strong>Optional</strong> - will auto increment</em></div>



            <div class="paid-check hide-estimate span-6 last">

					<label for="is_paid">Mark As Paid</label>

					<?php

					echo form_checkbox(array(

						'name' => 'is_paid',

						'id' => 'is_paid',

						'checked' => (!set_value('is_paid', FALSE)) ? FALSE : TRUE,

						'value' => '1',

					)); ?>

				</div>



        </div>



        <div class="span-22 clear row">

				<div class="span-5"><?php echo form_label('Recurring?'); ?></div>

				<div class="span-16 last"><div class="sel-item">

					<?php echo form_dropdown('is_recurring', array('No', 'Yes'), set_value('is_recurring'), 'id="is_recurring"'); ?>

				</div></div>

        </div>



        <div id="recurring-options" style="display:none">



				<div class="row span-22 clear">

					<div class="span-5"><?php echo form_label('Frequency'); ?></div>

					<div class="span-16 last"><div class="sel-item">

						<?php echo form_dropdown('frequency', array('w' => 'Week', 'm' => 'Month', 'y' => 'Year'), set_value('frequency', 'm'), 'id="frequency"'); ?>

					</div></div>

				</div>



				<div class="row span-22">

					<div class="span-5"><?php echo form_label('Auto Send'); ?></div>

					<div class="span-16 last"><div class="sel-item">

						<?php echo form_dropdown('auto_send', array('No', 'Yes'), set_value('auto_send', 1), 'id="auto_send"'); ?>

					</div></div>

				</div>

        </div>



        <div class="span-22 clear row">

            <div class="span-5"><?php echo form_label('Customer'); ?></div>

            <div class="span-16 last"><?php foreach ($customer as $row) : ;?><p><?=$row->firstname?> <?=$row->lastname?></p><?php endforeach; ?></div>

				

			</div><!-- /row end -->





			<div class="span-22 clear row">

				<div class="span-5"><label for="description">Description</label></div>

				<div class="span-16 last"><?php

					echo form_textarea(array(

						'name' => 'description',

						'id' => 'description',

						'value' => set_value('description', isset($project) ? $project->description : ''),

						'rows' => 4,

						'cols' => 50

					));

				?></div>

			</div><!-- /row end -->



        <div id="DETAILED-wrapper" class="span-22 clear type-wrapper row">

					<div class="span-5"><label for="nothing">Line Items</label></div>

					<div class="span-16 last"><table class="pc-table" id="invoice-items">

						<thead>

							<tr>

								<th>Trash Can Type</th>

								<th>Qty</th>

								<th>Actions</th>

							</tr>

						</thead>

						<tbody>



							<tr>

								<td><?php echo form_dropdown('invoice_item[trashcan][]', $trashcan_select); ?></td>

								<td><input type="text" name="invoice_item[quantity][]" value="1" class="item_quantity txt small" style="width: 40px" /></td>

                                <td class="actions">

									<a href="#" class="remove_item" style="margin:0;"><img src="/assets/images/icons/32x32/remove.png"></a>

								</td>

							</tr>





						</tbody>

					</table></div>



					<div class="span-22 clear btns-holder" style="margin-left: 160px">

						<ul class="btns-list">

							<li><a href="#" id="add-row"><span><img src="/assets/images/icons/32x32/add.png"></span></a></li>

						</ul><!-- /btns-list end -->

					</div><!-- /btns-holder end -->

				</div><!-- /row end -->

				<div class="row">

					<div class="span-5"><label for="lb08">Notes</label></div>

					<div class="span-16 last"><div class="textarea">

						<?php

							echo form_textarea(array(

								'name' => 'notes',

								'id' => 'notes',

								'value' => set_value('notes'),

								'rows' => 4,

								'cols' => 50

							));

						?>

					</div></div>

				</div><!-- /row end -->

            <div class="row span-22 clear">

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

				</div>



             </fieldset>

		<?php echo form_close(); ?>



    </div>

<!-- End Edit Customer -->



</div>