<?php
$social_network = get_field('social_network_settings', 'option');
if (!empty($social_network)) {
?>
    <ul class="social-icons d-flex align-items-center list-inline">
        <?php
        foreach ($social_network as $social_link) {
            $icon = $social_link['starter_kit_social_network_settings_icon'];
            $url = $social_link['starter_kit_social_network_settings_url'];
        ?>
            <li class="social-icons__item">
                <a href="<?php echo $url; ?>" target="_blank">
                    <img src="<?php echo $icon['url']; ?>" alt="<?php echo $icon['title']; ?>" />
                </a>
            </li>
        <?php } ?>
    </ul>
<?php }
