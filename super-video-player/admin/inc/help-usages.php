<?php

/*-------------------------------------------------------------------------------*/
// Developer page
/*-------------------------------------------------------------------------------*/
//enqueue css
function super_enqueue_assets($screen){
	if($screen == 'svplayer_page_svp-support'){
		wp_enqueue_style('super-help-usages', plugin_dir_url(__FILE__).'style.css');
	}
}
add_action('admin_enqueue_scripts', 'super_enqueue_assets');


add_action('admin_menu', 'svp_support_page');
function svp_support_page()
{
    add_submenu_page('edit.php?post_type=svplayer', 'Help & Support', 'Help & Support', 'manage_options', 'svp-support', 'svp_support_page_callback');
}

function svp_support_page_callback()
{
    ?>
    <div class="bplugins-container">
        <div class="row">
            <div class="bplugins-features">
                <div class="col col-12">
                    <div class="bplugins-feature center">
                        <h1><?php _e("Help & Supports", "svp"); ?></h1>
                    </div>
                </div>
            </div>
        </div>
    </div>
<div class="bplugins-container">
    <div class="row">
        <div class="bplugins-features">
            <div class="col col-4">
                <div class="bplugins-feature center">
                    <i class="fa fa-life-ring"></i>
                    <h3><?php _e("Need any Assistance?", "svp"); ?></h3>
                    <p><?php _e("Our Expert Support Team is always ready to help you out promptly.", "svp"); ?></p>
                    <a href="https://bplugins.com/support/" target="_blank" class="button
                    button-primary"><?php _e("Contact Support", "svp"); ?></a>
                </div>
            </div>
            <div class="col col-4">
                <div class="bplugins-feature center">
                    <i class="fa fa-file-text"></i>
                    <h3><?php _e("Looking for Documentation?", "svp"); ?></h3>
                    <p><?php _e("We have detailed documentation on every aspects of HTML5 Video Player.", "svp"); ?></p>
                    <a href="http://super-video-player.bplugins.com/" target="_blank" class="button button-primary"><?php _e("Documentation", "svp"); ?></a>
                </div>
            </div>
            <div class="col col-4">
                <div class="bplugins-feature center">
                    <i class="fa fa-thumbs-up"></i>
                    <h3><?php _e("Like This Plugin?", "svp"); ?></h3>
                    <p><?php _e("If you like Super Video Player, please leave us a 5 &#11088; rating.", "svp"); ?></p>
                    <a href="https://wordpress.org/support/plugin/super-video-player/reviews/?filter=5#new-post" target="_blank" class="button
                    button-primary"><?php _e("Rate the Plugin", "svp"); ?></a>
                </div>
            </div>
        </div>
    </div>
</div>
<div class="bplugins-container">
    <div class="row">
        <div class="bplugins-features">
            <div class="col col-12">
                <div class="bplugins-feature center" style="padding:5px;">
                    <h2 style="font-size:22px;"><?php _e("Looking For Demo?", "svp"); ?><a href="http://super-video-player.bplugins.com/" target="_blank"><?php _e("Click Here", "svp"); ?></a></h2>
                </div>
            </div>
        </div>
    </div>
</div>
<div class="bplugins-container">
    <div class="row">
        <div class="bplugins-features">
            <div class="col col-12">
                <div class="bplugins-feature center">
                    <h1><a href="https://www.youtube.com/embed/LJym2Pe1h2k"><?php _e("Video Tutorials", "svp"); ?></a></h1><br/>
                </div>
            </div>
        </div>
    </div>
</div>

<?php
}