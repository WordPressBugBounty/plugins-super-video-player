<?php // Silence is golden.
// Control core classes for avoid errors
if( class_exists( 'CSF' ) ) {

  //
  // Set a unique slug-like ID
  $prefix = '_svp_';

  //
  // Create a metabox
  CSF::createMetabox( $prefix, array(
    'title'     => 'Player Configuration',
    'post_type' => 'svplayer',
    'data_type' => 'unserialize',
    'context'   => 'normal', // The context within the screen where the boxes should display. `normal`, `side`, `advanced`
  ) );

  //
  // Create a section
  CSF::createSection( $prefix, array(
    'title'  => 'Required fields are marked with an * (asterisk)',
    'fields' => array(






array(
  'id'         => '_svp_video_file',
  'type'       => 'upload',
  'title'      => 'Video Source *',
  'desc'      => '
  <li>Either select a vidoe from media library or Paste a Video url from external sources, Eg: S3, CDN, Or Any third party hosting service.</li>
  <li>For Live Streaming, you can select a file or paste file url. Supported file types: .m3u8 and .mpd, Avoid <a href="https://web.dev/what-is-mixed-content/" target="_blank">Mixed Content</a></li>
  <li>YouTube, Vimeo url are not supported. </li>',
  'placeholder'  =>'https://',
  'inline'    => true,
  'library'    => 'video',  
  'help'    => 'video text'  
),

array(
  'id'         => '_svp_video_poster',
  'type'       => 'upload',
  'title'      => 'Poster Image',
  'desc'      => esc_html__( 'A image to be shown while the video is downloading, or until the user hits the play button. ', 'bPlugins' ),
  'inline'    => true,
  'library'    => 'image'
),

array(
  'id'     => 'video_caption',
  'type'   => 'repeater',
  'title'  => 'Caption / Subtitle',
  'desc'      => esc_html__( 'Click On + To add Subtitle File. You can add different subtitle file for different languages.', 'bPlugins' ),   
  'fields' => array(

    array(
      'id'    => 'vtt',
      'type'  => 'upload',
      'title' => 'Caption File (.vtt file only )'
    ),
    array(
      'id'    => 'label',
      'type'  => 'text',
      'title' => 'Label',
      'desc' => esc_html__( 'Enter label for the subtitle. eg: English/en', 'bPlugins' ), 
    ),
  ),
),
array(
  'id'         => 'video_repeat',
  'type'       => 'radio',
  'title'      => 'Repeat',
  'desc'      => esc_html__('Specify how the video will start over again, every time it is finished','bPlugins'),
  'options'    => array(
    'once' => 'Repeat Once ',
    'loop' => 'Loop',
  ),
  'default'    => 'once'
  ),
  
 array(
  'id'    => 'video_muted',
  'type'  => 'switcher',
  'title' => 'Muted',
  'desc' => esc_html__('Turn On if you want the audio output of the video should be muted.','bPlugins'),
), 
 array(
  'id'    => 'video_autoplay',
  'type'  => 'switcher',
  'title' => 'Auto Play',
  'desc' => ' * <a target="_blank" href="https://developers.google.com/web/updates/2017/09/autoplay-policy-changes">Chrome Autoplay Policy</a> * <a target="_blank" href="https://support.apple.com/guide/safari/stop-autoplay-videos-ibrw29c6ecf8"> Safari Autoplay Policy</a> Read the autoplay policy Carefully to understand how, when the autoplay work and when not.',
), 

array(
  'id'         => 'video_width',
  'type'       => 'text',
  'title'      => 'Video Width (Px)',
  'desc'      => esc_html__( 'Enter 0 for 100% Width. Enter any number such as 500 for a video player with 500px. ', 'bPlugins' ),
  'default'=>'0',
  'inline'    => true,
   'attributes'  => array(
    'type'      => 'number',
    'maxlength' => 5,
  ),
),
  
array(
  'id'    => 'initial_vol',
  'type'  => 'slider',
  'title' => 'Initial volume',
  'class' => 'svp-readonly',  
  'min'     => 0,
  'max'     => 100,
  'step'    => 10, 
  'default'    => 50, 
  'unit'    => '%', 
  
),  


array(
  'id'         => 'seek_time',
  'type'       => 'text',
  'title'      => 'Seek time (Second)',
  'desc'      => esc_html__( 'Enter 0 for 100% Width. Enter any number such as 500 for a video player with 500px. ', 'bPlugins' ),
  'class' => 'svp-readonly',  
  'default'=>'10',
  'inline'    => true,
   'attributes'  => array(
    'type'      => 'number',
    'maxlength' => 5,
  ),
),

 array(
  'id'    => 'click_to_play',
  'type'  => 'switcher',
  'title' => 'Click to play',
  'desc' => esc_html__('Click (or tap) of the video container will toggle play/pause.','bPlugins'),
  'class' => 'svp-readonly',  
  'default' => '1',  
),
 array(
  'id'    => 'tooltips',
  'type'  => 'switcher',
  'title' => 'Tooltips',
  'desc' => esc_html__('Display control labels as tooltips on :hover & :focus','bPlugins'),
  'class' => 'svp-readonly',  
  'default' => '1',  
),
array(
  'id'     => 'video_playlist',
  'type'   => 'repeater',
  'title'  => 'Playlist',
  'desc'      => esc_html__( 'Click On + To add playlist items. You can add multiple video file in the playlist.', 'bPlugins' ),  
  'class' => 'svp-readonly',  
  'fields' => array(

    array(
      'id'    => 'playlist_item',
      'type'  => 'upload',
      'title' => 'Select Video',
      'library'    => 'video'  	  
    ),
    array(
      'id'    => 'playlist_item_poster',
      'type'  => 'upload',
      'title' => 'Select poster image',
      'library'    => 'image'  	  
    ),	
     array(
      'id'    => 'playlist_item_title',
      'type'  => 'text',
      'title' => 'Label',
      'default' => 'Playlist Item',
      'desc' => esc_html__( 'Enter the title for the video. ', 'bPlugins' ), 
    ), 
  ),
),



array(
  'id'     => 'video_quality',
  'type'   => 'repeater',
  'title'  => 'Video Quality',
  'desc'      => esc_html__( 'Click On + to add new qualities.  You can set multiple video quality for the same video', 'bPlugins' ),  
  'class' => 'svp-readonly',  
  'fields' => array(

    array(
      'id'    => 'vid_src',
      'type'  => 'upload',
      'title' => 'Source',
      'desc' => esc_html__( 'Either select a video file form your media library or paste a video file url', 'bPlugins' ), 
    ),
    array(
      'id'    => 'vid_size',
      'type'  => 'text',
      'title' => 'Resolution',
      'desc' => esc_html__( 'eg: 4320, 2880, 2160, 1440, 1080, 720, 576, 480, 360 or 240. Entre 720 if the video quality is 720P', 'bPlugins' ), 
    ),
  ),
),


	  
    )
  ) );

}

if( class_exists( 'CSF' ) ) {

  //
  // Set a unique slug-like ID
  $prefix = 'svp_sdfsd';

  //
  // Create a metabox
  CSF::createMetabox( $prefix, array(
    'title'     => 'Controls & Components',
    'post_type' => 'svplayer',
    'data_type' => 'unserialize',
    'context'   => 'side', // The context within the screen where the boxes should display. `normal`, `side`, `advanced`
  ) );

  //
  // Create a section
  CSF::createSection( $prefix, array(
    'fields' => array(







 array(
  'id'    => 'large_play',
  'type'  => 'switcher',
  'title' => 'Large Play Button',
  'default' => '1',
  'class' => 'svp-readonly',  
  'help' => esc_html__('Turn off to hide.','bPlugins'), 
  
),

 array(
  'id'    => 'restart_btn',
  'type'  => 'switcher',
  'title' => 'Restart button',
  'help' => esc_html__('Turn off to hide.','bPlugins'),
  'class' => 'svp-readonly',  
  'default' => '1',  
), 
 array(
  'id'    => 'play_btn',
  'type'  => 'switcher',
  'title' => 'Play button',
  'help' => esc_html__('Turn off to hide.','bPlugins'),
  'class' => 'svp-readonly',  
  'default' => '1',  
), 
 array(
  'id'    => 'rewind_btn',
  'type'  => 'switcher',
  'title' => 'Rewind button',
  'help' => esc_html__('Turn off to hide.','bPlugins'),
  'class' => 'svp-readonly',  
  'default' => '1',  
),
 array(
  'id'    => 'forward_button',
  'type'  => 'switcher',
  'title' => 'Fast forward button',
  'help' => esc_html__('Turn off to hide.','bPlugins'),
  'class' => 'svp-readonly',  
  'default' => '1',  
  
), 
 array(
  'id'    => 'progress_bar',
  'type'  => 'switcher',
  'title' => 'Progress bar',
  'help' => esc_html__('Turn off to hide.','bPlugins'),
  'class' => 'svp-readonly',  
  'default' => '1',  
),     
 array(
  'id'    => 'current_time',
  'type'  => 'switcher',
  'title' => 'Current time',
  'help' => esc_html__('Turn off to hide.','bPlugins'),
  'class' => 'svp-readonly',  
  'default' => '1',  
),  
 array(
  'id'    => 'mute_button',
  'type'  => 'switcher',
  'title' => 'Mute button',
  'help' => esc_html__('Turn off to hide.','bPlugins'),
  'class' => 'svp-readonly',  
  'default' => '1',  
), 
 array(
  'id'    => 'volume',
  'type'  => 'switcher',
  'title' => 'Volume control',
  'help' => esc_html__('Turn off to hide.','bPlugins'),
  'class' => 'svp-readonly',  
  'default' => '1',  
), 
  array(
  'id'    => 'subtitle_button',
  'type'  => 'switcher',
  'title' => 'Subtitle control',
  'help' => esc_html__('Turn off to hide.','bPlugins'),
  'class' => 'svp-readonly',  
  'default' => '1',  
),
  array(
  'id'    => 'settings_button',
  'type'  => 'switcher',
  'title' => 'Setting button',
  'help' => esc_html__('Turn off to hide.','bPlugins'),
  'class' => 'svp-readonly',  
  'default' => '1',  
),
  array(
  'id'    => 'pip_btn',
  'type'  => 'switcher',
  'title' => 'PIP button',
  'help' => esc_html__('Turn off to hide.','bPlugins'),
  'class' => 'svp-readonly',  
  'default' => '1',  
),
  array(
  'id'    => 'fullscreen_button',
  'type'  => 'switcher',
  'title' => 'FullScreen button',
  'help' => esc_html__('Turn off to hide.','bPlugins'),
  'class' => 'svp-readonly',  
  'default' => '1',  
),
  array(
  'id'    => 'download_button',
  'type'  => 'switcher',
  'title' => 'Download button',
  'class' => 'svp-readonly',  
  'help' => esc_html__('Turn off to hide.','bPlugins'),
  'default' => '1',  
), 
 array(
  'id'    => 'auto_hide',
  'type'  => 'switcher',
  'class' => 'svp-readonly',  
  'title' => 'Auto hide control',
  'help' => esc_html__('Hide video controls automatically after 2s of no mouse or focus. Turn off to keep controls visible always','bPlugins'),
  'default' => '1',  
),
 array(
 
  'id'    => 'control_shadow',
  'type'  => 'switcher',
  'class' => 'svp-readonly',  
  'title' => 'Control shadow',
  'help' => esc_html__('Turn off to hide the shadow in the controls area.','bPlugins'),
  'default' => '1',  
),


	  
    )
  ) );

}

/**
 * Register and enqueue a custom stylesheet in the WordPress admin.
 */
function svp_read_only_style() {
        wp_register_style( 'svp-readonly', plugin_dir_url( __FILE__ ) . 'readonly.css', false, '1.0' );
        wp_enqueue_style( 'svp-readonly' );
}
add_action( 'admin_enqueue_scripts', 'svp_read_only_style' );

function svp_exclude_fields_before_save( $data ) {

  $exclude = array(
	'video_quality',
'vid_src',
'vid_size'	,
	'video_playlist',
'playlist_item',
'playlist_item_poster',	
'playlist_item_title',
	'tooltips',
	'click_to_play',
	'seek_time',
	'initial_vol',
	'restart_btn',
	'play_btn',
	'rewind_btn',
	'forward_button',
	'progress_bar',
	'current_time',
	'mute_button',
	'volume',
	'subtitle_button',
	'settings_button',
	'pip_btn',
	'fullscreen_button',
	'download_button',
	'auto_hide',
	'control_shadow'
  );

  foreach ( $exclude as $id ) {
    unset( $data[$id] );
  }

  return $data;

}

add_filter( 'csf_sc__save', 'svp_exclude_fields_before_save', 10, 1 );