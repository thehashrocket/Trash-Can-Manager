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



    <div id="InvoiceCustomer" class="span-22">

        <?php echo form_open_multipart('admin/invoices/create', 'id="create-invoice"'); ?>
		<fieldset>

        <div class="span-22">
            <div class="span-5"><?php echo form_label('Invoice Number'); ?></div>
            <div class="span-16 last"><?php echo form_input('invoice_number', set_value('invoice_number'), 'id="invoice_number" class="txt"'); ?><br/>&nbsp;<em><strong>Optional</strong> - will auto increment</em></div>
        </div>

        <div class="span-22 row hide-estimate">
				<div class="span-5"><?php echo form_label('Recurring?'); ?></div>
				<div class="span-16 last"><div class="sel-item">
					<?php echo form_dropdown('is_recurring', array('No', 'Yes'), set_value('is_recurring'), 'id="is_recurring"'); ?>
				</div></div>
        </div>

        <div id="recurring-options" style="display:none">

				<div class="row span-22">
					<div class="span-5"><?php echo form_label('Frequency'); ?></div>
					<div class="span-16 last"><div class="sel-item">
						<?php echo form_dropdown('frequency', array('w' => 'Week', 'm' => 'Month', 'y' => 'Year'), set_value('frequency', 'm'), 'id="frequency"'); ?>
					</div></div>
				</div>

				<div class="row span-22">
					<div class="span-5"><?php echo form_label('Invoice Number'); ?></div>
					<div class="span-16 last"><div class="sel-item">
						<?php echo form_dropdown('auto_send', array('No', 'Yes'), set_value('auto_send', 1), 'id="auto_send"'); ?>
					</div></div>
				</div>
        </div>

        <div class="span-22 row">
            <div class="span-5"><?php echo form_label('Customer'); ?></div>
            <div class="span-16 last"><?php foreach ($customer->result_array() as $row) {
            echo $row['firstname'] . ' ' . $row['lastname'];
        };?></div>
				
			</div><!-- /row end -->


			<div class="span-22 row">
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

        <div id="DETAILED-wrapper" class="span-22 type-wrapper row">
					<div class="span-5"><label for="nothing">Line Items</label></div>
					<div class="span-16 last"><table class="pc-table" id="invoice-items" style="width: 702px">
						<thead>
							<tr>
								<th>Item Description</th>
								<th>Qty / Hrs</th>
								<th>Rate</th>
								<th>Cost</th>
								<?php if ( ! empty($items)): ?><th>Actions</th><?php endif; ?>
							</tr>
						</thead>
						<tbody>
						<?php if ( ! empty($items)): ?>
						<?php foreach ($items as $item): ?>
							<tr>
								<td><input type="text" name="invoice_item[description][]" class="item_description txt small" style="width: 150px" value="<?php echo $item['description']; ?>" /></td>
								<td><input type="text" name="invoice_item[quantity][]" value="<?php echo $item['quantity']; ?>" class="item_quantity txt small" style="width: 40px" /></td>
								<td><input type="text" name="invoice_item[rate][]"  value="<?php echo $item['rate']; ?>" class="item_rate txt small" style="width: 60px" /></td>

								<td>
									<input type="hidden" name="invoice_item[cost][]" value="<?php echo number_format($item['cost'], 2); ?>" class="item_cost" />
									<span class="item_cost"><?php echo number_format($item['cost'], 2); ?></span>
								</td>
								<td class="actions">
									<a href="#" class="remove_item" style="margin:0;">Remove</a>
								</td>
							</tr>
						<?php endforeach; ?>
						<?php else: ?>
							<tr>
								<td><?php echo form_dropdown('trashcan', $trashcan_select); ?></td>
								<td><input type="text" name="invoice_item[quantity][]" value="1" class="item_quantity txt small" style="width: 40px" /></td>
								<td><input type="text" name="invoice_item[rate][]"  value="1.00" class="item_rate txt small" style="width: 60px" /></td>
								<td style="width: 100px">
									<input type="hidden" name="invoice_item[cost][]" value="1.00" class="item_cost" />
									<span class="item_cost">1.00</span>
								</td>
							</tr>
						<?php endif; ?>

						</tbody>
					</table></div>

					<div class="span-22 btns-holder" style="margin-left: 160px">
						<ul class="btns-list">
							<li><a class="yellow-btn" href="#" id="add-row"><span>Add Item</span></a></li>
						</ul><!-- /btns-list end -->
					</div><!-- /btns-holder end -->
				</div><!-- /row end -->
				<div class="row">
					<label for="lb08">Notes</label>
					<div class="textarea">
						<?php
							echo form_textarea(array(
								'name' => 'notes',
								'id' => 'notes',
								'value' => set_value('notes'),
								'rows' => 4,
								'cols' => 50
							));
						?>
					</div>
				</div><!-- /row end -->

        <div id="SIMPLE-wrapper" class="span-22 type-wrapper row">
					<label for="amount">Amount $</label>
					<?php echo form_input('amount', set_value('amount'), 'class="txt"'); ?>
				</div><!-- /row end -->
				<div class="row">
					<label for="nothing">&nbsp;</label>
					<a href="#" class="yellow-btn" onclick="$"><span>&rarr;</span></a>
				</div>

            </fieldset>
		<?php echo form_close(); ?>

    </div>
<!-- End Edit Customer -->

</div>