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
  'title'      => 'Select Video*',
  'desc'      => esc_html__( 'Please select a .mp4 or .ogg video file', 'bPlugins' ),
  'library'    => 'video',  
  'inline'    => true
),

array(
  'id'         => '_svp_video_poster',
  'type'       => 'upload',
  'title'      => 'Poster Image',
  'desc'      => esc_html__( 'Select a poster image. A image to be shown while the video is downloading, or until the user hits the play button ', 'bPlugins' ),
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
      'desc' => esc_html__( 'Enter label for the subtitle. eg: English Subtitle', 'bPlugins' ), 
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
  'desc' => esc_html__('Turn On if you want the audio output of the video should be muted','bPlugins'),
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

	  
    )
  ) );

}


function stp_exclude_fields_before_save( $data ) {

  $exclude = array(
    'station_name',
    'welcome_msgs',
    'player_skin',
    'autoplay',
    'volume',
    'artwork',
    'timeholder',
    'background',
    'player_postiion',
    'custom_css',
  );

  foreach ( $exclude as $id ) {
    unset( $data[$id] );
  }

  return $data;

}

add_filter( 'csf_sc__save', 'stp_exclude_fields_before_save', 10, 1 );