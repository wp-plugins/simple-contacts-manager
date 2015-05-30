<form method="POST" action="" class="cm form" id="cm-form-js" autocomplete="off">
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
						<h3 class="hndle ui-sortable-handle"><span>Plugin Settings</span></h3>
						<div class="inside">
							<div class="clearfix cm__item">
								<label class="cm__label" for="min_access_level">Minimum Access Level</label>
								<select name="min_access_level">
									<?php
										$current_role = $this->_get_minimun_role();
										foreach( $this->roles as $role => $capability )
											echo '<option value="'. str_replace( $current_role, $current_role.'" selected="selected', $capability ) .'">'.$role.'</option>';
									?>
								</select>
								<input type="button" class="button button-primary button-large cm-submit js" value="Update Plugin Settings" name="action" />
							</div>
						</div>
					</div>

				</div>
			</div>

			<input id="cm-action-js" type="hidden" name="action" value="" />
		</div>
	</div>
</form>