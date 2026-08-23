<?php
if (!defined('ABSPATH')) {
	exit;
}

$video_playlist = get_meta($id, 'video_playlist', []);
$video_quality = get_meta($id, 'video_quality', []);
$video_caption = get_meta($id, 'video_caption', []);
$caption_styles_meta = get_meta($id, 'caption_styles', []);

$caption_styles = wp_parse_args($caption_styles_meta, [
    'color' => '#ffffff',
    'bg'    => 'rgba(0,0,0,0.7)',
    'typography' => [
        'font-family'    => 'inherit',
        'font-size'      => '18px',
        'font-weight'    => '400',
        'line-height'    => '1.4',
        'text-transform' => 'none',
    ],
]);

$qualities = [];
foreach ($video_quality as $quality) {
    $qualities[] = [
        'source' => $quality['vid_src'] ?? '',
        'size' => $quality['vid_size'] ?? '',
    ];
}

$captions = [];
foreach ($video_caption as $caption) {
    $label = explode('/', $caption['label'] ?? '');
    $captions[] = [
        'source' => $caption['vtt'] ?? '',
        'label' => $label[0] ?? '',
        'srclang' => $label[1] ?? '',
    ];
}

$videos = [];
foreach ($video_playlist as $video) {
    $videos[] = [
        'src' => $video['playlist_item'] ?? '',
        'title' => $video['playlist_item_title'] ?? 'type your video title here',
        'description' => $video['playlist_item_description'] ?? 'Please like this video!',
        'poster' => $video['playlist_item_poster'] ?? ''
    ];
}

$tab_styles_serialized = get_meta($id, 'tabStyles', []);
$tab_styles = maybe_unserialize($tab_styles_serialized);

if (!is_array($tab_styles)) {
    $tab_styles = [];
}

// Fill missing keys with defaults
$tab_styles = wp_parse_args($tab_styles, [
    'activeBg'           => '#334155',
    'activeTitleColor'   => '#fff',
    'activeDesColor'     => '#fff',
    'inactiveBg'         => '#F0F5FA',
    'inactiveTitleColor' => '#3D8D7A',
    'inactiveDesColor'   => '#585a5c',
    'durationTimeColor'  => '#fff',
    'durationBg'         => '#000'
]);

$border_meta = get_meta($id, 'border', []);

// Missing key গুলো default দিয়ে পূরণ করা
$border = wp_parse_args($border_meta, [
    'width'  => '0px',
    'style'  => 'solid',
    'color'  => '#000000',
    'radius' => '0px',
]);

$caption_block_styles = [
    'color' => $caption_styles['color'],
    'bg'    => $caption_styles['bg'],
];

$font_size_raw = $caption_styles['typography']['font-size'] ?? '18';

if (is_numeric($font_size_raw)) {
    $font_size_raw .= 'px';
}

$caption_typo = [
    'fontSize' => [
        'desktop' => $font_size_raw,
        'tablet'  => $font_size_raw,
        'mobile'  => $font_size_raw,
    ],
    'fontFamily'    => $caption_styles['typography']['font-family'] ?? 'inherit',
    'lineHeight'    => $caption_styles['typography']['line-height'] ?? '1.4',
    'fontWeight'    => $caption_styles['typography']['font-weight'] ?? '400',
    'textTransform' => $caption_styles['typography']['text-transform'] ?? 'none',
];

$get_meta = get__meta($id);

$attributes = [
    'align' => '',
    'options' => [
        'controls' => svp_get_controls($id),
        'autoPlay' => $get_meta('video_autoplay') == '1',
        'clickToPlay' => $get_meta('click_to_play') == '1',
        'muted' => $get_meta('video_muted') == '1',
        'volume' => intval(get_meta($id, 'initial_vol', 50)) / 100,
        'seekTime' => (int) get_meta($id, 'seek_time', 10),
        'repeat' => $get_meta('video_repeat') == 'loop',
        'isAutoNextVideo' => get_meta($id, 'continues_auto_playlist') == '1',
        'toolTip' => get_meta($id, 'tooltips', '0') == '1',
        'isControl' => true,
        'shadowControl' => true
    ],
    'videos' => array_merge([
        [
            'src' => get_meta($id, '_svp_video_file', ''),
            'title' => get_meta($id, '_svp_video_title', 'type your video title here'),
            'poster' => get_meta($id, '_svp_video_poster', ''),
            'description' => get_meta($id, '_svp_video_description', 'Don’t forget to like, comment, and subscribe for more fun episodes!'),
            'customDownloadButton' => false,
            'isCustomTitle' => false,
            'customDownloadUrl' => get_meta($id, '_svp_custom_download_url', ''),
            'qualities' => $qualities,
            'captions' => $captions,
        ]
    ], $videos),
    'videoSize' => [
        'width' => [
            'desktop' =>  get_meta($id, 'video_width', false) ? get_meta($id, 'video_width') . 'px' : '100%',
            'tablet' =>  get_meta($id, 'video_width', false) ? get_meta($id, 'video_width') . 'px' : '100%',
            'mobile' =>  get_meta($id, 'video_width', false) ? get_meta($id, 'video_width') . 'px' : '100%'
        ],
        'height' => [
            'desktop' => '',
            'tablet' => '',
            'mobile' => ''
        ]
    ],
    'thumbnailSize' => [
        'width' => [
            'desktop' =>  get_meta($id, 'video_width', false) ? get_meta($id, 'video_width') . 'px' : '100%',
            'tablet' =>  get_meta($id, 'video_width', false) ? get_meta($id, 'video_width') . 'px' : '100%',
            'mobile' =>  get_meta($id, 'video_width', false) ? get_meta($id, 'video_width') . 'px' : '100%'
        ],
        'height' => [
            'desktop' => '82px',
            'tablet' => '',
            'mobile' => ''
        ]
    ],
    'playlist' => is_array($videos) && count($videos) > 0 ? true : false,
    'themes' => [
        'theme' => get_meta($id, 'player_theme', 'default')
    ],
    'tabStyles' => $tab_styles,
    'captionstyles' => $caption_block_styles,
    'captionTypo'   => $caption_typo,
    'titleTypo' => [
        'fontSize' => [
            'desktop' => 15,
            'tablet' => 13,
            'mobile' => 12
        ]
    ],
    'descriptionTypo' => [
        'fontSize' => [
            'desktop' => 14,
            'tablet' => 12,
            'mobile' => 12
        ]
    ],
    'durationTypo' => [
        'fontSize' => [
            'desktop' => 14,
            'tablet' => 12,
            'mobile' => 10
        ]
    ],

'viewersTypo' => [
        'fontSize' => [
            'desktop' => 14,
            'tablet' => 12,
            'mobile' => 10
        ]
    ],
'alignment' => 'center',
'textAlign' => 'center',
'background' => [
        'color' => '#0000'
    ],
'scrollBg' => '#3D8D7A',
'content' => 'Content of the block',
'typography' => [
        'fontSize' => 20
    ],
'color' => '#333',
'colors' => [
        'color' => '#333',
        'bg' => '#fff'
    ],
'img' => [
        'id' => null,
        'url' => '',
        'alt' => '',
        'title' => ''
    ],
'padding' => [
        'top' => '15px',
        'right' => '30px',
        'bottom' => '15px',
        'left' => '30px'
    ],
'margin' => [
        'top' => '0px',
        'right' => '0px',
        'bottom' => '15px',
        'left' => '0px'
    ],
'border' => $border,
'shadow' => []
];

// print_r($attributes);


$block = [
    'blockName' => "svp/video-player",
    'attrs' => $attributes,
    'innerBlocks' => [],
    'innerHTML' => '',
    'innerContent' => [],
];
