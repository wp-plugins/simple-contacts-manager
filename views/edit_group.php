<h2>Edit <?php echo $this->current_group_name; ?></h2>

<form method="POST" action="" class="cm form" id="cm-form" autocomplete="off">
	<div id="poststuff">
		<div id="post-body" class="metabox-holder columns-2">

			<div id="postbox-container-1" class="postbox-container">
				<div id="side-sortables" class="meta-box-sortables ui-sortable">

					<div class="postbox">
						<h3 class="hndle ui-sortable-handle"><span>Save Details</span></h3>
						<div class="inside">
							<div class="clearfix">
								<p>Save all the changes made on the contact details</p>
								<input type="hidden" id="cm_group" name="group" value="<?php echo $this->current_group; ?>" />
								<input type="button" class="button button-primary button-large cm-submit js" value="Update Group Details" />
								<input type="button" class="button button-primary button-large cm-edit js" value="Cancel" data-href="<?php echo $this->page_link; ?>" />
							</div>
						</div>
					</div>

					<div class="postbox">
						<h3 class="hndle ui-sortable-handle"><span>How to use</span></h3>
						<div class="inside">
							<div class="clearfix">
								<p>To get the values of each field is actually pretty straight forward.  Either you will use the PHP method or the shortcode method.</p>
							</div>
						</div>
					</div>

					<div class="postbox">
						<h3 class="hndle ui-sortable-handle"><span>PHP</span></h3>
						<div class="inside">
							<div class="clearfix">
								<p>You can use the cm_contact function then just supply the key of the contact that you are trying to get:</p>
								<p>E.g. <br />&lt;?php<br /> echo cm_contact('<?php echo $this->current_group; ?>-general-group_name'); <br />?&gt;</p>
								<p>Will have an output of:<br /><?php echo $this->current_group_name; ?></p>
							</div>
						</div>
					</div>

					<div class="postbox">
						<h3 class="hndle ui-sortable-handle"><span>SHORTCODE</span></h3>
						<div class="inside">
							<div class="clearfix">								
								<p>You can use the shortcode [cm_contact key=""] then just supply the key or hit the "Get Shortcode" beside the contact</p>
								<p>E.g. <br />[cm_contact key="<?php echo $this->current_group; ?>-general-group_name"]</p>
								<p>Will have an output of:<br /><?php echo $this->current_group_name; ?></p>
							</div>
						</div>
					</div>

					<div class="postbox">
						<h3 class="hndle ui-sortable-handle"><span>SPECIAL KEYS</span></h3>
						<div class="inside">
							<div class="clearfix">
								<p>The keys below will return all contacts in the section in an array</p>
								<p>
									<?php echo $this->current_group; ?>-general<br />
									<?php echo $this->current_group; ?>-address<br />
									<?php echo $this->current_group; ?>-office<br />
									<?php echo $this->current_group; ?>-social<br />
								</p>
								<p><hr /></p>
								<p>Using the group ID as key will return all the contacts in the group in an array</p>
								<p><?php echo $this->current_group; ?></p>
							</div>
						</div>
					</div>

				</div>
			</div>
			
			<div id="postbox-container-2" class="postbox-container">
				<div id="normal-sortables" class="meta-box-sortables ui-sortable">

					<div class="postbox general" data-section="general">
						<h3 class="hndle ui-sortable-handle"><span>General Details</span></h3>
						<div class="inside">

							<?php
								$section = 'general';
								$items = $this->get_contact( $this->current_group.'-'.$section );

								if( $items ) {
									foreach( $items as $key => $val ) {
										echo '
							<div id="'.$section.'_'.$key.'" class="clearfix cm__item">
								<label class="cm__label" for="'.$section.'_'.$key.'_value">'.$val['label'].'</label>
								<input type="text" name="'.$section.'_'.$key.'_value" value="'. $val['value'] .'" />
								<span><strong>Key:</strong> <input type="text" class="cm__key" value="'. $this->current_group .'-'.$section.'-'.$key.'" data-shortcode=\'[cm_contact key="'. $this->current_group .'-'.$section.'-'.$key.'"]\' readonly /></span>
								<input type="button" class="button cm__shortcode-btn js" value="Get Shortcode" />'.
								(in_array($section.'-'.$key, $this->protected)? '':' <input type="button" class="button cm-remove js" value="Remove Field" />')
								.'<input type="hidden" name="'.$section.'_'.$key.'_label" value="'.$val['label'].'" />
								<input type="hidden" name="'.$section.'_keys[]" value="'.$key.'" />
							</div>
										';
									}
								}
							?>

							<div class="clearfix cm-add">
								<div class="cm-add__container">
									<div class="cm-add__wrapper cm-add__fields cm-add__wrapper--buttonOut">
										<h4 class="cm-add__header">Add New Row</h4>
										<label>Label:</label>
										<input type="text" class="cm-add__field label" maxlength="50" value="" />
										<label>Value:</label>
										<input type="text" class="cm-add__field value" value="" />
										<input type="button" class="button cm-add__save js" value="Save" />
										<input type="button" class="button cm-add__cancel js" value="Cancel" />
									</div>
									<div class="cm-add__wrapper cm-add__btn cm-add__wrapper--buttonIn">
										<input type="button" class="button button-primary cm__add-btn js" value="Add New Contact" />
									</div>
								</div>
							</div>
						</div>
					</div>


					<div class="postbox address" data-section="address">
						<h3 class="hndle ui-sortable-handle"><span>Address</span></h3>
						<div class="inside">

							<?php
								$section = 'address';
								$items = $this->get_contact( $this->current_group.'-'.$section );

								if( $items ) {
									foreach( $items as $key => $val ) {
										echo '
							<div id="'.$section.'_'.$key.'" class="clearfix cm__item">
								<label class="cm__label" for="'.$section.'_'.$key.'_value">'.$val['label'].'</label>
								<input type="text" name="'.$section.'_'.$key.'_value" value="'. $val['value'] .'" />
								<span><strong>Key:</strong> <input type="text" class="cm__key" value="'. $this->current_group .'-'.$section.'-'.$key.'" data-shortcode=\'[cm_contact key="'. $this->current_group .'-'.$section.'-'.$key.'"]\' readonly /></span>
								<input type="button" class="button cm__shortcode-btn js" value="Get Shortcode" />'.
								(in_array($section.'-'.$key, $this->protected)? '':' <input type="button" class="button cm-remove js" value="Remove Field" />')
								.'<input type="hidden" name="'.$section.'_'.$key.'_label" value="'.$val['label'].'" />
								<input type="hidden" name="'.$section.'_keys[]" value="'.$key.'" />
							</div>
										';
									}
								}
							?>


							<div class="clearfix cm-add">
								<div class="cm-add__container">
									<div class="cm-add__wrapper cm-add__fields cm-add__wrapper--buttonOut">
										<h4 class="cm-add__header">Add New Row</h4>
										<label>Label:</label>
										<input type="text" class="cm-add__field label" maxlength="50" value="" />
										<label>Value:</label>
										<input type="text" class="cm-add__field value" value="" />
										<input type="button" class="button cm-add__save js" value="Save" />
										<input type="button" class="button cm-add__cancel js" value="Cancel" />
									</div>
									<div class="cm-add__wrapper cm-add__btn cm-add__wrapper--buttonIn">
										<input type="button" class="button button-primary cm__add-btn js" value="Add New Contact" />
									</div>
								</div>
							</div>
						</div>
					</div>

					<div class="postbox office" data-section="office">
						<h3 class="hndle ui-sortable-handle"><span>Office Hours</span></h3>
						<div class="inside">

							<?php
								$section = 'office';
								$items = $this->get_contact( $this->current_group.'-'.$section );

								if( $items ) {
									foreach( $items as $key => $val ) {
										echo '
							<div id="'.$section.'_'.$key.'" class="clearfix cm__item">
								<label class="cm__label" for="'.$section.'_'.$key.'_value">'.$val['label'].'</label>
								<input type="text" name="'.$section.'_'.$key.'_value" value="'. $val['value'] .'" />
								<span><strong>Key:</strong> <input type="text" class="cm__key" value="'. $this->current_group .'-'.$section.'-'.$key.'" data-shortcode=\'[cm_contact key="'. $this->current_group .'-'.$section.'-'.$key.'"]\' readonly /></span>
								<input type="button" class="button cm__shortcode-btn js" value="Get Shortcode" />'.
								(in_array($section.'-'.$key, $this->protected)? '':' <input type="button" class="button cm-remove js" value="Remove Field" />')
								.'<input type="hidden" name="'.$section.'_'.$key.'_label" value="'.$val['label'].'" />
								<input type="hidden" name="'.$section.'_keys[]" value="'.$key.'" />
							</div>
										';
									}
								}
							?>

							<div class="clearfix cm-add">
								<div class="cm-add__container">
									<div class="cm-add__wrapper cm-add__fields cm-add__wrapper--buttonOut">
										<h4 class="cm-add__header">Add New Row</h4>
										<label>Label:</label>
										<input type="text" class="cm-add__field label" maxlength="50" value="" />
										<label>Value:</label>
										<input type="text" class="cm-add__field value" value="" />
										<input type="button" class="button cm-add__save js" value="Save" />
										<input type="button" class="button cm-add__cancel js" value="Cancel" />
									</div>
									<div class="cm-add__wrapper cm-add__btn cm-add__wrapper--buttonIn">
										<input type="button" class="button button-primary cm__add-btn js" value="Add New Contact" />
									</div>
								</div>
							</div>
						</div>
					</div>

					<div class="postbox social" data-section="social">
						<h3 class="hndle ui-sortable-handle"><span>Social Media</span></h3>
						<div class="inside">

							<?php
								$section = 'social';
								$items = $this->get_contact( $this->current_group.'-'.$section );

								if( $items ) {
									foreach( $items as $key => $val ) {
										echo '
							<div id="'.$section.'_'.$key.'" class="clearfix cm__item">
								<label class="cm__label" for="'.$section.'_'.$key.'_value">'.$val['label'].'</label>
								<input type="text" name="'.$section.'_'.$key.'_value" value="'. $val['value'] .'" />
								<span><strong>Key:</strong> <input type="text" class="cm__key" value="'. $this->current_group .'-'.$section.'-'.$key.'" data-shortcode=\'[cm_contact key="'. $this->current_group .'-'.$section.'-'.$key.'"]\' readonly /></span>
								<input type="button" class="button cm__shortcode-btn js" value="Get Shortcode" />'.
								(in_array($section.'-'.$key, $this->protected)? '':' <input type="button" class="button cm-remove js" value="Remove Field" />')
								.'<input type="hidden" name="'.$section.'_'.$key.'_label" value="'.$val['label'].'" />
								<input type="hidden" name="'.$section.'_keys[]" value="'.$key.'" />
							</div>
										';
									}
								}
							?>

							<div class="clearfix cm-add">
								<div class="cm-add__container">
									<div class="cm-add__wrapper cm-add__fields cm-add__wrapper--buttonOut">
										<h4 class="cm-add__header">Add New Row</h4>
										<label>Label:</label>
										<input type="text" class="cm-add__field label" maxlength="50" value="" />
										<label>Value:</label>
										<input type="text" class="cm-add__field value" value="" />
										<input type="button" class="button cm-add__save js" value="Save" />
										<input type="button" class="button cm-add__cancel js" value="Cancel" />
									</div>
									<div class="cm-add__wrapper cm-add__btn cm-add__wrapper--buttonIn">
										<input type="button" class="button button-primary cm__add-btn js" value="Add New Contact" />
									</div>
								</div>
							</div>
						</div>
					</div>

				</div>
			</div>

			<input id="cm-action-js" type="hidden" name="action" value="" />
		</div>
	</div>
</form>