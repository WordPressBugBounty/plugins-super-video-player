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
    'theme' => 'light',
    'context'   => 'normal', // The context within the screen where the boxes should display. `normal`, `side`, `advanced`
  ) );
  //
  // General section
CSF::createSection( $prefix, 
array(
    'title'  => 'General',
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
  'id' => '_svp_video_title',
  'type' => 'text',
  'title' => __('Video Title', 'bPlugins'),
  'desc' => esc_html__('Enter the title for the video. ', 'bPlugins'),
  // 'class' => 'svp-readonly'
),

array(
  'id' => '_svp_video_description',
  'type' => 'text',
  'title' => __('Video Description', 'bPlugins'),
  'desc' => esc_html__('Enter the description for the video. ', 'bPlugins'),
  // 'class' => 'svp-readonly'
),

 array(
        'id' => '_svp_custom_download_url_enabled',
        'type' => 'switcher',
        'title' => __('Enable Custom Video Download URL', 'bPlugins'),
        'default' => 0,
        'class' => 'svp-readonly'
      ),

      array(
        'id' => '_svp_custom_download_url',
        'type' => 'text',
        'title' => __("Custom Download URL", "bPlugins"),
        'dependency' => array('_svp_custom_download_url_enabled', '==', '1')
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
  // 'class' => 'svp-readonly',  
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
  // 'class' => 'svp-readonly',  
  'default'=>'10',
  'inline'    => true,
   'attributes'  => array(
    'type'      => 'number',
    'maxlength' => 5,
  ),
),


array(
  'id'     => 'video_playlist',
  'type'   => 'repeater',
  'title'  => 'Playlist',
  'desc'      => esc_html__( 'Click On + To add playlist items. You can add multiple video file in the playlist.', 'bPlugins' ),  
  // 'class' => 'svp-readonly',  
  'fields' => array(

    array(
      'id'    => 'playlist_item_title',
      'type'  => 'text',
      'title' => 'Label',
      'default' => 'Playlist Item',
      'desc' => esc_html__( 'Enter the title for the video. ', 'bPlugins' ), 
    ), 
    array(
      'id'    => 'playlist_item_description',
      'type'  => 'text',
      'title' => 'Video Description',
      'default' => 'Playlist Item',
      'desc' => esc_html__('Enter the description for the video. ', 'bPlugins'),
    ),

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
    )
  ),
),

 array(
      'id'      => 'player_theme',
      'type'    => 'select',
      'title'   => 'Playlist Layout',
      'options' => array(
        'default'     => 'Default',
        'horizontal'  => 'Horizontal Layout',
        'vertical'    => '🔒 Vertical Layout (Pro)',
        'grid'        => '🔒 Grid Layout (Pro)',
      ),
      'default' => 'default',
    ),


array(
  'id'     => 'video_caption',
  'type'   => 'group',
  'title'  => 'Playlist Caption / Subtitle',
  'desc'      => esc_html__('Click On + To add Subtitle File. You can add different subtitle file for different languages.', 'bPlugins'),
  // 'class' => 'svp-readonly',

  'fields' => array(

    array(
      'id'    => 'label',
      'type'  => 'text',
      'title' => 'Label',
      'desc' => esc_html__('Enter label for the subtitle. eg: English/en', 'bPlugins'),
    ),
    array(
      'id'    => 'vtt',
      'type'  => 'upload',
      'title' => 'Caption File (.vtt file only )'
    ),
  ),
),

array(
  'id'     => 'video_quality',
  'type'   => 'repeater',
  'title'  => 'Video Quality',
  'desc'      => esc_html__( 'Click On + to add new qualities.  You can set multiple video quality for the same video', 'bPlugins' ),  
  // 'class' => 'svp-readonly',  
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
));

// Settings Section
CSF::createSection($prefix, array(
  'title' => 'Settings',
  'fields' => array(
    // video repeat
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

  // video muted
  array(
  'id'    => 'video_muted',
  'type'  => 'switcher',
  'title' => 'Muted',
  'desc' => esc_html__('Turn On if you want the audio output of the video should be muted.','bPlugins'),
), 

// video autoPlay
array(
  'id'    => 'video_autoplay',
  'type'  => 'switcher',
  'title' => 'Auto Play',
  'desc' => ' * <a target="_blank" href="https://developers.google.com/web/updates/2017/09/autoplay-policy-changes">Chrome Autoplay Policy</a> * <a target="_blank" href="https://support.apple.com/guide/safari/stop-autoplay-videos-ibrw29c6ecf8"> Safari Autoplay Policy</a> Read the autoplay policy Carefully to understand how, when the autoplay work and when not.',
), 

// continously auto play
array(
  'id'    => 'continues_auto_playlist',
  'type'  => 'switcher',
  'title' => 'Continuous Playback on Playlist',
  'desc' => esc_html__('Plays next video automatically. Please enable autoPlay.','bPlugins'),
  'class' => 'svp-readonly', 
),

// click to play

array(
  'id'    => 'click_to_play',
  'type'  => 'switcher',
  'title' => 'Click to play',
  'desc' => esc_html__('Click (or tap) of the video container will toggle play/pause.','bPlugins'),
  // 'class' => 'svp-readonly',  
  'default' => '1',  
),

// tooltip control
 array(
  'id'    => 'tooltips',
  'type'  => 'switcher',
  'title' => 'Tooltips',
  'desc' => esc_html__('Display control labels as tooltips on :hover & :focus','bPlugins'),
  // 'class' => 'svp-readonly',  
  'default' => '1',  
),

)));

// Style Section
CSF::createSection($prefix, array(
  'title' => 'Style',
  'fields' => array(
    // caption styles
  array(
      'id'     => 'caption_styles',
      'type'   => 'fieldset',
      'title'  => 'Caption Styles',

      'fields' => array(
        array(
          'id'      => 'color',
          'type'    => 'color',
          'title'   => 'Caption Text Color',
          'default' => '#ffffff',
        ),

        array(
          'id'      => 'bg',
          'type'    => 'color',
          'title'   => 'Caption Background Color',
          'default' => 'rgba(0,0,0,0.7)',
        ),

        array(
          'id'    => 'typography',
          'type'  => 'typography',
          'title' => 'Caption Typography',

          // 🔥 Control visible fields
          'font_family'    => true,
          'font_weight'    => true,
          'font_style'     => true,
          'font_size'      => true,
          'line_height'    => true,
          'letter_spacing' => false,
          'text_align'     => false, // ❌ hide
          'text_transform' => true,
          'color'          => false, // ❌ hide

          'default' => array(
            'font-family'    => 'inherit',
            'font-weight'    => '400',
            'font-size'      => '18px',
            'line-height'    => '1.4',
            'text-transform' => 'none',
          ),

          'output' => false,
        ),

      ),
),

// border styles
array(
  'id'     => 'border',
  'type'   => 'fieldset',
  'title'  => __('Border', 'svp'),
  // 'class' => 'svp-readonly',
  'fields' => array(

      array(
          'id'      => 'width',
          'type'    => 'text',
          'title'   => __('Border Width', 'svp'),
          'default' => '0px',
      ),

      array(
          'id'      => 'style',
          'type'    => 'select',
          'title'   => __('Border Style', 'svp'),
          'options' => array(
              'none'   => __('None', 'svp'),
              'solid'  => __('Solid', 'svp'),
              'dashed' => __('Dashed', 'svp'),
              'dotted' => __('Dotted', 'svp'),
          ),
          'default' => 'solid',
      ),

      array(
          'id'      => 'color',
          'type'    => 'color',
          'title'   => __('Border Color', 'svp'),
          'default' => '#000000',
      ),

      array(
          'id'      => 'radius',
          'type'    => 'text',
          'title'   => __('Border Radius', 'svp'),
          'default' => '0px',
      ),
  ),
),

// tab styles
array(
  'id'     => 'tabStyles',
  'type'   => 'fieldset',
  'title'  => 'Tab Styles',
  // 'class' => 'svp-readonly',
  'fields' => array(
    array(
      'id'      => 'activeBg',
      'type'    => 'color',
      'title'   => 'Active Background',
      'default' => '#334155'
    ),
    array(
      'id'      => 'activeTitleColor',
      'type'    => 'color',
      'title'   => 'Active Title Color',
      'default' => '#fff'
    ),
    array(
      'id'      => 'activeDesColor',
      'type'    => 'color',
      'title'   => 'Active Description Color',
      'default' => '#fff'
    ),
    array(
      'id'      => 'inactiveBg',
      'type'    => 'color',
      'title'   => 'Inactive Background',
      'default' => '#F0F5FA'
    ),
    array(
      'id'      => 'inactiveTitleColor',
      'type'    => 'color',
      'title'   => 'Inactive Title Color',
      'default' => '#3D8D7A'
    ),
    array(
      'id'      => 'inactiveDesColor',
      'type'    => 'color',
      'title'   => 'Inactive Description Color',
      'default' => '#585a5c'
    ),
    array(
      'id'      => 'durationTimeColor',
      'type'    => 'color',
      'title'   => 'Duration Time Color',
      'default' => '#fff'
    ),
    array(
      'id'      => 'durationBg',
      'type'    => 'color',
      'title'   => 'Duration Background',
      'default' => '#000'
    ),
  )
),

)));

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
  // 'class' => 'svp-readonly',  
  'help' => esc_html__('Turn off to hide.','bPlugins'), 
),

 array(
  'id'    => 'restart_btn',
  'type'  => 'switcher',
  'title' => 'Restart button',
  'help' => esc_html__('Turn off to hide.','bPlugins'), 
  'default' => '1',  
), 
 array(
  'id'    => 'play_btn',
  'type'  => 'switcher',
  'title' => 'Play button',
  'help' => esc_html__('Turn off to hide.','bPlugins'),
  // 'class' => 'svp-readonly',  
  'default' => '1',  
), 
 array(
  'id'    => 'rewind_btn',
  'type'  => 'switcher',
  'title' => 'Rewind button',
  'help' => esc_html__('Turn off to hide.','bPlugins'),
  // 'class' => 'svp-readonly',  
  'default' => '1',  
),
 array(
  'id'    => 'forward_button',
  'type'  => 'switcher',
  'title' => 'Fast forward button',
  'help' => esc_html__('Turn off to hide.','bPlugins'),
  // 'class' => 'svp-readonly',  
  'default' => '1',  
  
), 
 array(
  'id'    => 'progress_bar',
  'type'  => 'switcher',
  'title' => 'Progress bar',
  'help' => esc_html__('Turn off to hide.','bPlugins'),
  // 'class' => 'svp-readonly',  
  'default' => '1',  
),     
 array(
  'id'    => 'current_time',
  'type'  => 'switcher',
  'title' => 'Current time',
  'help' => esc_html__('Turn off to hide.','bPlugins'),
  // 'class' => 'svp-readonly',  
  'default' => '1',  
),  
 array(
  'id'    => 'mute_button',
  'type'  => 'switcher',
  'title' => 'Mute button',
  'help' => esc_html__('Turn off to hide.','bPlugins'),
  // 'class' => 'svp-readonly',  
  'default' => '1',  
), 
 array(
  'id'    => 'volume',
  'type'  => 'switcher',
  'title' => 'Volume control',
  'help' => esc_html__('Turn off to hide.','bPlugins'),
  // 'class' => 'svp-readonly',  
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
  'id'    => 'share_button',
  'type'  => 'switcher',
  'title' => 'Share button',
  'help' => esc_html__('Turn off to hide.','bPlugins'),
  'class' => 'svp-readonly',  
  'default' => '1',  
),
  array(
  'id'    => 'settings_button',
  'type'  => 'switcher',
  'title' => 'Setting button',
  'help' => esc_html__('Turn off to hide.','bPlugins'),
  // 'class' => 'svp-readonly',  
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
  // 'class' => 'svp-readonly',  
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
  // 'class' => 'svp-readonly',  
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
),)
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