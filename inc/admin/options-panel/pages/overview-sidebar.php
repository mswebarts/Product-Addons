<?php global $mspa_url; ?>
<div class="postbox">
	<div class="inside">
		<div class="mspa-box">
			<h3><?php echo esc_html_e( 'Enjoying Product Addons?', 'simple-product-addons' ); ?></h3>
			<div>
				<img src="<?php echo esc_url( $mspa_url . 'inc/admin/assets/images/rating.jpg' ); ?>" alt="<?php echo esc_attr_e( '5 star rating', 'simple-product-addons' ); ?>">
				<div>
					<?php echo esc_html_e( 'Leave us a 5 star review on WordPress and help spread the word!', 'simple-product-addons' ); ?>
					<a href="<?php echo esc_url( 'https://wordpress.org/support/plugin/simple-product-addons/reviews/#new-post' ); ?>" class="mspa-add-wordpress-review" target="_blank">
						<?php echo esc_html_e( 'Review Us on', 'simple-product-addons' ) . ' '; ?>
						<img src="<?php echo esc_url( $mspa_url . 'inc/admin/assets/images/wordpress-logo.png' ); ?>" alt="<?php echo esc_attr_e( 'WordPress Logo', 'simple-product-addons' ); ?>" style="margin-left: 5px;"/>
					</a>
				</div>
			</div>
		</div>
	</div>
</div>
