<?php
/*-------------------------------------------------------------------------------*/
/* Lets register our shortcode
/*-------------------------------------------------------------------------------*/
if (!defined('SVP_PRO')) :
function svp_shortcode_func_free($atts){
	extract( shortcode_atts( array(
		'id' => null,
	), $atts ) ); 

	$post_type = get_post_type($id);
	if($post_type != 'svplayer'){
		return false;
	}

	wp_enqueue_script('bplugins-frontend');


	$props = [
		'options' => [

		],
		'styles' => [
			'width' => get_post_meta($id,'video_width', true)
		]
	];

ob_start();?>
<div class="svpPlayer"></div>

	<div style="<?php $pwidth=get_post_meta($id,'video_width', true); if ($pwidth==0){echo 'width:100%';}else{echo 'width:' . esc_attr($pwidth) . 'px; max-width:' . esc_attr($pwidth) . 'px; display: inline-block;';} ?>">
	<?php if( empty(get_post_meta($id,'_svp_video_file', true))){echo 'You have not selected any video for that player. Please check the player and set a video source.';} ?>
 		<video controls playsinline class="player<?php echo esc_attr($id); ?>" <?php $status1= get_post_meta($id,'video_repeat', true); if ($status1=="loop"){echo "loop";}?> <?php $stutas= get_post_meta($id,'video_muted', true); if('1'==$stutas){echo 'muted';} ?> <?php $stutas= get_post_meta($id,'video_autoplay', true); if ($stutas=="1"){echo" autoplay ";}?><?php $poster=get_post_meta($id,'_svp_video_poster', true); if(!empty($poster)) { echo'poster="'. esc_attr($poster).'"';} ?>>
 <source src="<?php $video=get_post_meta($id,'_svp_video_file', true); echo esc_attr($video);?>" type="video/mp4">
  Your browser does not support the video tag.
  
<?php $subtitle=get_post_meta($id,'video_caption', true); if(!empty($subtitle)){
	//var_dump($subtitle); 
	foreach($subtitle as $subtitledata){ ?>
	<track kind="captions" label="<?php echo esc_attr($subtitledata['label']);?>" src="<?php echo esc_url($subtitledata['vtt']);?>" srclang="en" default>
	 <?php } } ?>
	 
</video>

<script type="text/javascript">
<?php 
$path=get_post_meta($id,'_svp_video_file', true);
$ext = pathinfo($path, PATHINFO_EXTENSION);

if($ext=='m3u8'){ 
wp_enqueue_script('svp-hls-js');
?>
document.addEventListener('DOMContentLoaded', () => {
	const source = '<?php echo esc_url(get_post_meta($id,'_svp_video_file', true)); ?>';
	const video = document.querySelector('.player<?php echo esc_attr($id); ?>');
	const player = new Plyr(video, {captions: {active: true, update: true, language: 'en'}});

	if (!Hls.isSupported()) {
		video.src = source;
	} else {
		const hls = new Hls();
		hls.loadSource(source);
		hls.attachMedia(video);
		window.hls = hls;
		player.on('languagechange', () => {
			setTimeout(() => hls.subtitleTrack = player.currentTrack, 50);
		});
	}
	window.player = player;
});
<?php }

if($ext=='mpd'){ 
wp_enqueue_script('svp-shaka-js');
?>


document.addEventListener('DOMContentLoaded', () => {
	const source = '<?php echo esc_url(get_post_meta($id,'_svp_video_file', true)); ?>';
	const video = document.querySelector('video');
	const player = new Plyr(video);
	window.player = player;
	if (shaka.Player.isBrowserSupported()) {
		shaka.polyfill.installAll();
		const shakaInstance = new shaka.Player(video);
		shakaInstance.load(source);
	} else {
		console.warn('Browser is not supported!');
	}
});
<?php } ?>
const players<?php echo esc_html($id);?> = Plyr.setup('.player<?php echo esc_html($id);?>', {
	fullscreen:{ enabled: true, fallback: true, iosNative: true },
	displayDuration: true,	
	invertTime:false,

});
</script>


</div>
<?php $output = ob_get_clean();return $output;//print $output; // debug ?>

<?php
}
add_shortcode('vplayer','svp_shortcode_func_free');	
endif;	