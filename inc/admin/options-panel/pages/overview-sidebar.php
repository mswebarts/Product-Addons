<?php global $mspa_url; ?>
<div class="postbox">
	<div class="inside">
		<div class="mspa-box">
			<h3><?php echo esc_html_e( 'Enjoying Product Addons?', 'breview' ); ?></h3>
			<div>
				<img src="<?php echo esc_url( $mspa_url . 'inc/admin/assets/images/rating.jpg' ); ?>" alt="<?php echo esc_attr_e( '5 star rating', 'breview' ); ?>">
				<div>
					<?php echo esc_html_e( 'Leave us a 5 star review on WordPress and help spread the word!', 'breview' ); ?>
					<a href="<?php echo esc_url( 'https://wordpress.org/support/plugin/product-addons/reviews/#new-post' ); ?>" class="mspa-add-wordpress-review" target="_blank">
						<?php echo esc_html_e( 'Review Us on', 'breview' ) . ' '; ?>
						<img src="<?php echo esc_url( $mspa_url . 'inc/admin/assets/images/wordpress-logo.png' ); ?>" alt="<?php echo esc_attr_e( 'WordPress Logo', 'breview' ); ?>" style="margin-left: 5px;"/>
					</a>
				</div>
			</div>
		</div>
	</div>
</div>
