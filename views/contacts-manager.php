<form method="POST" action="<?php echo $this->page_link; ?>" class="cm form" id="cm-form-js" autocomplete="off">
	<div id="poststuff">
		<div id="post-body" class="metabox-holder columns-2">

			<div id="postbox-container-1" class="postbox-container">
				<div id="side-sortables" class="meta-box-sortables ui-sortable">

					<div class="postbox">
						<h3 class="hndle ui-sortable-handle"><span>About the plugin</span></h3>
						<div class="inside">
							<div class="clearfix">
								<?php echo $this->plugin_description; ?>
							</div>
						</div>
					</div>

				</div>
			</div>
			
			<div id="postbox-container-2" class="postbox-container">
				<div id="normal-sortables" class="meta-box-sortables ui-sortable">

					<div class="postbox">
						<h3 class="hndle ui-sortable-handle"><span>Google Analytics</span></h3>
						<div class="inside">
							<div class="clearfix cm__item">
								<label class="cm__label" for="contact_group">Google Analytics Tracking ID</label>
								<input type="text" name="google_analytics" maxlength="50" value="<?php echo $this->get_analytics_id(); ?>" />
								<input type="button" class="button button-primary button-large cm-submit js" value="Update Analytics Settings" name="action" />
							</div>
							<div class="clearfix cm__item">
								<label class="cm__label" for="">Insert Google Tracking Code</label>
								<input type="checkbox" name="insert_analytics_code" value="insert_analytics_code" <?php echo $this->_check_insert_codes()? 'checked':''; ?> />
								<span><i>If checked, google tracking code will be inserted into footer.</i></span>
							</div>
						</div>
					</div>


					<div class="postbox">
						<h3 class="hndle ui-sortable-handle"><span>Add a new Contact Group</span></h3>
						<div class="inside">
							<div class="clearfix">
								<label class="cm__label" for="contact_group">Contact Group Name</label>
								<input type="text" name="contact_group" maxlength="50" value="" />
								<input type="button" class="button button-primary button-large cm-submit js" value="Add Contact Group" name="action" />
							</div>
						</div>
					</div>

					<?php
						$this->_check_insert_codes();
						$groups = $this->get_contact_groups(TRUE);
						if( $groups ):
					?>
					<div class="postbox">
						<h3 class="hndle ui-sortable-handle"><span>Contact Groups</span></h3>
						<div class="inside">
							<?php
								foreach( $groups as $key => $name ) {
									echo '
							<div class="cm__group-item clearfix">
								<h3 class="cm__group-name">'. $name .'</h3>
								<input type="button" class="button button-large cm-edit js" value="Edit" data-href="'. $this->page_link .'&group='. $key .'&action=edit" />
								<input type="button" class="button button-large cm-delete js" value="Delete" data-href="'. $this->page_link .'&group='. $key .'&action=delete" />
							</div>
									';
								}
							?>
						</div>
					</div>
					<?php
						endif;
					?>

				</div>
			</div>

			<input id="cm-action-js" type="hidden" name="action" value="" />
		</div>
	</div>
</form>