<?php
$general_tab      = menu_page_url( 'msp-addons', false );
$add_review_check = '1' == $mspa_enable_product_addon ? 'checked' : '';
?>
<div id="icon-options-general" class="icon32"></div>
<h1><?php echo esc_html_e( 'MS Product Addons for WC', 'msp-addons' ); ?></h1>
<p><?php echo esc_html_e( 'Let customers choose product addons while buying for WooCommerce websites.', 'msp-addons' ); ?></p>

<div class="wrap mswa-settings-page">

	<div id="poststuff">

		<div id="post-body" class="metabox-holder">

			<!-- main content -->
			<div id="post-body-content">

				<h2 class="nav-tab-wrapper">
					<a href="<?php echo esc_attr( esc_url( $general_tab ) ); ?>" class="nav-tab nav-tab-active">
						<?php echo esc_html_e( 'General', 'msp-addons' ); ?>
					</a>
				</h2>

				<div class="mswa-form-wrapper">
					<form method="post" action="">
						<input type="hidden" name="mspa_general_form_submitted" value="Y">
						<div class="mswa-section-wrapper">
							<div class="mswa-section">
								<div class="mswa-section-heading">
									<h2><?php echo esc_html_e( 'General Settings', 'msp-addons' ); ?></h2>
									<p>
										<?php echo esc_html_e( 'Configure the general settings for product addons.', 'msp-addons' ); ?>
									</p>
								</div>

								<table class="form-table">
									<tr>
										<th>
											<label for="mspa_enable_product_addon">
												<?php esc_html_e( 'Enable Product Addons', 'msp-addons' ); ?>
										</th>
										</label>
										<td>
											<fieldset>
												<legend class="screen-reader-text">
													<span><?php esc_html_e( 'Enable Product Addons', 'msp-addons' ); ?></span>
												</legend>
												<input name="mspa_enable_product_addon" type="checkbox" id="mspa_enable_product_addon" value="<?php echo esc_attr( '1' ); ?>" <?php echo esc_attr( $add_review_check ); ?> />
												<span><?php esc_html_e( 'Check to display the Add Review form in product pages.', 'msp-addons' ); ?></span>
											</fieldset>
										</td>
									</tr>
									
									<!-- add a repeater field for Product Addon Sections-->
									<tr>
										<th>
											<label for="product_addon_sections">
												<?php esc_html_e( 'Product Addon Sections', 'msp-addons' ); ?>
											</label>
										</th>
										<td>
											<fieldset class="mswa-repeater">
												<legend class="screen-reader-text">
													<span><?php esc_html_e( 'Product Addon Sections', 'msp-addons' ); ?></span>
												</legend>
												<div data-repeater-list="product_addon_sections">
													<?php
													$total_sections = count( $product_addon_sections );

													if ( $total_sections > 0 ) {
														foreach ( $product_addon_sections as $section ) {
															?>
														<h3 class='mswa-accordion-title'>
															<?php echo esc_html( $section['product_addon_section_name'] ); ?>
															<span class="dashicons dashicons-arrow-down-alt2 toggle-icon"></span>
														</h3>
														<div class='mswa-accordion-content mswa-accordion-closed'>
															<div data-repeater-item>
																<div class="mswa-repeater-field-item-container">
																	<label for="product_addon_section_id">
																		<h4 class="mswa-label-heading">
																			<?php esc_html_e( 'Unique ID', 'msp-addons' ); ?>
																		</h4>
																	</label>
																	<input type="text" class="product-addon-section-id-input" name="product_addon_section_id" placeholder="Add an unique ID for the section" value="<?php echo esc_attr( $section['product_addon_section_id'] ); ?>" required />
																	<div class="mswa-field-description">
																		<?php esc_html_e( 'This is a unique ID for this section.', 'msp-addons' ); ?>
																	</div>
																</div>

																<div class="mswa-repeater-field-item-container">
																	<label for="product_addon_section_name">
																		<h4 class="mswa-label-heading">
																			<?php esc_html_e( 'Section Name', 'msp-addons' ); ?>
																		</h4>
																	</label>
																	<input type="text" class="product-addon-section-name-input" name="product_addon_section_name" placeholder="Add a name for the section" value="<?php echo esc_attr( $section['product_addon_section_name'] ); ?>" required />
																	<div class="mswa-field-description">
																		<?php esc_html_e( 'Add a name to the section.', 'msp-addons' ); ?>
																	</div>
																</div>

																<input data-repeater-delete type="button" value="Delete" />
															</div>
														</div>
															<?php
														}
													} else {
														?>
														<div data-repeater-item>
															<input type="text" name="product_addon_section_id" placeholder="Add an unique ID for the section" value="" />
															<input type="text" name="product_addon_section_name" placeholder="Add a name for the section" value="" />
															<input data-repeater-delete type="button" value="Delete" />
														</div>
														<?php
													}
													?>
												</div>
												<input data-repeater-create type="button" value="Add a Section" />
											</fieldset>
										</td>
									</tr>
									
								</table>
							</div>
						</div>
						
						<?php wp_nonce_field( 'mspa_general_form_action', 'mspa_general_form_nonce' ); ?>
						<input class="button-primary" type="submit" value="<?php esc_html_e( 'Save Settings', 'msp-addons' ); ?>" />

						<br class="clear" />
					</form>
				</div>

			</div>
			<!-- post-body-content -->

		</div>
		<!-- #post-body .metabox-holder .columns-2 -->

		<br class="clear">
	</div>
	<!-- #poststuff -->

</div> <!-- .wrap -->

<?php wp_enqueue_script( 'mspa-admin-script' ); ?>
