<?php global $mspa_url; ?>
<div class="mspa-box">
    <h3><?php echo esc_html_e('Enjoying Breview?', 'msp-addons'); ?></h3>
    <p>
        <?php echo esc_html_e('Leave us a review on Trustpilot and help spread the word!', 'msp-addons'); ?>
        <a href="<?php echo esc_url('https://www.trustpilot.com/evaluate/mswebarts.com?utm_medium=trustbox&utm_source=MSWebArtsBreviewOverview'); ?>" class="mspa-add-trustpilot-review" target="_blank">
            <?php echo esc_html_e("Review Us on", "msp-addons") . " "; ?>
            <img src="<?php echo esc_url($mspa_url . 'inc/admin/assets/images/trustpilot-logo.png'); ?>" alt="<?php echo esc_attr_e("Trustpilot Logo", "msp-addons"); ?>">
        </a>
    </p>
</div>