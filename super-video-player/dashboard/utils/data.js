const slug = "super-video-player";

export const dashboardInfo = (info) => {
  const { version, isPremium, hasPro, licenseActiveNonce } = info;

  const proSuffix = isPremium ? ' Pro' : '';

  return {
    name: `Super Video player${proSuffix}`,
    displayName: `Super Video player${proSuffix} - Fully Customizable Video Player with Playlist`,
    description:
      "Super Video Player is a flexible and fully responsive video player plugin for WordPress. It allows you to embed MP4 and other video formats with ease. You can customize the player to match your site design and support playback across all major browsers and devices. The plugin supports video embedding using shortcodes or Gutenberg blocks, making it easy to add video players to posts, pages, or widgets without writing any code. With built-in customization options, users can control video behavior such as autoplay, loop, mute, and more.",
    slug,
    version,
    isPremium,
    hasPro,
    displayOurPlugins: true,
    media: {
      logo: `https://ps.w.org/${slug}/assets/icon-128x128.png`,
      banner: `https://ps.w.org/${slug}/assets/banner-772x250.png`,
      thumbnail: `https://bplugins.com/wp-content/themes/b-technologies/assets/images/products/${slug}.png`,
      // proThumbnail: `https://bplugins.com/wp-content/themes/b-technologies/assets/images/products/${slug}-pro.png`,
      video: 'https://www.youtube.com/watch?v=LJym2Pe1h2k',
      isYoutube: true
    },
    pages: {
      org: `https://wordpress.org/plugins/${slug}/`,
      landing: `https://bplugins.com/products/${slug}/`,
      docs: `https://bplugins.com/docs/${slug}/`,
      pricing: `https://bplugins.com/products/${slug}/pricing`,
    },
    freemius: {
      product_id: 6749,
      plan_id: 10994,
      public_key: 'pk_ebfc28616ca46b064866ea36660e0'
    },

    licenseActiveNonce,

    changelogs: [
      {
        version: '1.8.8 – 3 March 26',
        type: 'Update',
        list: [
          'Latest dashboard has been added.',
          'Dashboard menu item rename',
          'Latest pro alert modal has been added on the block',
          'Quick theme added option on the block'
        ]
      },
      {
        version: '1.8.7 – 29 Dec, 2025',
        type: 'Update',
        list: [
          'Caption custom styles features added.'
        ]
      },
      {
        version: '1.8.6 – 17 Nov, 2025',
        type: 'New',
        list: [
          'Share button features added',
        ]
      },
      {
        version: '1.8.5 – 3 Nov, 2025',
        type: 'Fixed',
        list: [
          'Customization Horizontal Layout',
          'Added new features: Continuous Playback on Playlist option'
        ]
      }
    ],

    proFeatures: [
      'Add multiple videos in a playlist and enable automatic continuous playback.',
      'Choose from various modern layouts and fully customize the player’s appearance.',
      'Show the video title and description above or below the player with full positioning control.',
      'Customize font, size, color, and alignment of video titles and descriptions to match your website design.',
      'Allow users to switch between different video quality options.',
      'Show or hide individual player controls and set initial volume & seek time.',
      'Enable built-in social sharing directly from the video player.'
    ],

    startButton: {
      label: 'Start Now',
      url: 'wp-admin/post-new.php?post_type=svplayer'
    }
  }
}

export const demoInfo = {
  allInOneLabel: 'See All Demos',
  allInOneLink: 'https://wpvideoplayer.com/all-demos-in-one-place/',
  demos: [
    {
      "title": "Single Player - Default",
      "description": "Clean player with basic controls.",
      "url": "https://bblockswp.com/demo/super-video-player-single/",
      "icon": (<svg stroke='#000' fill='#000' strokeWidth='0' viewBox='0 0 24 24' height='1em' width='1em' xmlns='http://www.w3.org/2000/svg'><path d='M5 9V7H7V9H5Z' fill='currentColor'></path><path d='M9 9H19V7H9V9Z' fill='currentColor'></path><path d='M5 15V17H7V15H5Z' fill='currentColor'></path><path d='M19 17H9V15H19V17Z' fill='currentColor'></path><path fillRule='evenodd' clipRule='evenodd' d='M1 6C1 4.34315 2.34315 3 4 3H20C21.6569 3 23 4.34315 23 6V18C23 19.6569 21.6569 21 20 21H4C2.34315 21 1 19.6569 1 18V6ZM4 5H20C20.5523 5 21 5.44772 21 6V11H3V6C3 5.44772 3.44772 5 4 5ZM3 13V18C3 18.5523 3.44772 19 4 19H20C20.5523 19 21 18.5523 21 18V13H3Z' fill='currentColor'></path></svg>),
      "type": 'iframe'
    },
    {
      "title": "Playlist - Default",
      "description": "Starts muted and plays automatically.",
      "url": "https://bblockswp.com/demo/super-video-player-default-playlist/",
      "icon": (<svg stroke='#000' fill='#000' strokeWidth='0' viewBox='0 0 24 24' height='1em' width='1em' xmlns='http://www.w3.org/2000/svg'><path d='M5 9V7H7V9H5Z' fill='currentColor'></path><path d='M9 9H19V7H9V9Z' fill='currentColor'></path><path d='M5 15V17H7V15H5Z' fill='currentColor'></path><path d='M19 17H9V15H19V17Z' fill='currentColor'></path><path fillRule='evenodd' clipRule='evenodd' d='M1 6C1 4.34315 2.34315 3 4 3H20C21.6569 3 23 4.34315 23 6V18C23 19.6569 21.6569 21 20 21H4C2.34315 21 1 19.6569 1 18V6ZM4 5H20C20.5523 5 21 5.44772 21 6V11H3V6C3 5.44772 3.44772 5 4 5ZM3 13V18C3 18.5523 3.44772 19 4 19H20C20.5523 19 21 18.5523 21 18V13H3Z' fill='currentColor'></path></svg>),
      "type": 'iframe'
    },
    {
      "title": "Playlist - Horizontal",
      "description": "Resize player to fit your layout.",
      "url": "https://bblockswp.com/demo/super-video-player-horizontal-playlist/",
      "icon": (<svg stroke='#000' fill='#000' strokeWidth='0' viewBox='0 0 24 24' height='1em' width='1em' xmlns='http://www.w3.org/2000/svg'><path d='M5 9V7H7V9H5Z' fill='currentColor'></path><path d='M9 9H19V7H9V9Z' fill='currentColor'></path><path d='M5 15V17H7V15H5Z' fill='currentColor'></path><path d='M19 17H9V15H19V17Z' fill='currentColor'></path><path fillRule='evenodd' clipRule='evenodd' d='M1 6C1 4.34315 2.34315 3 4 3H20C21.6569 3 23 4.34315 23 6V18C23 19.6569 21.6569 21 20 21H4C2.34315 21 1 19.6569 1 18V6ZM4 5H20C20.5523 5 21 5.44772 21 6V11H3V6C3 5.44772 3.44772 5 4 5ZM3 13V18C3 18.5523 3.44772 19 4 19H20C20.5523 19 21 18.5523 21 18V13H3Z' fill='currentColor'></path></svg>),
      "type": 'iframe'
    },
    {
      "title": "Playlist - Vertical",
      "description": "Shows every available control option.",
      "url": "https://bblockswp.com/demo/super-video-player-playlist-vertical/",
      "icon": (<svg stroke='#000' fill='#000' strokeWidth='0' viewBox='0 0 24 24' height='1em' width='1em' xmlns='http://www.w3.org/2000/svg'><path d='M5 9V7H7V9H5Z' fill='currentColor'></path><path d='M9 9H19V7H9V9Z' fill='currentColor'></path><path d='M5 15V17H7V15H5Z' fill='currentColor'></path><path d='M19 17H9V15H19V17Z' fill='currentColor'></path><path fillRule='evenodd' clipRule='evenodd' d='M1 6C1 4.34315 2.34315 3 4 3H20C21.6569 3 23 4.34315 23 6V18C23 19.6569 21.6569 21 20 21H4C2.34315 21 1 19.6569 1 18V6ZM4 5H20C20.5523 5 21 5.44772 21 6V11H3V6C3 5.44772 3.44772 5 4 5ZM3 13V18C3 18.5523 3.44772 19 4 19H20C20.5523 19 21 18.5523 21 18V13H3Z' fill='currentColor'></path></svg>),
      "type": 'iframe'
    },
    {
      "title": "Playlist - Grid",
      "description": "Skip 2s and set preload behavior.",
      "url": "https://bblockswp.com/demo/super-video-player-grid-playlist/",
      "icon": (<svg stroke='#000' fill='#000' strokeWidth='0' viewBox='0 0 24 24' height='1em' width='1em' xmlns='http://www.w3.org/2000/svg'><path d='M5 9V7H7V9H5Z' fill='currentColor'></path><path d='M9 9H19V7H9V9Z' fill='currentColor'></path><path d='M5 15V17H7V15H5Z' fill='currentColor'></path><path d='M19 17H9V15H19V17Z' fill='currentColor'></path><path fillRule='evenodd' clipRule='evenodd' d='M1 6C1 4.34315 2.34315 3 4 3H20C21.6569 3 23 4.34315 23 6V18C23 19.6569 21.6569 21 20 21H4C2.34315 21 1 19.6569 1 18V6ZM4 5H20C20.5523 5 21 5.44772 21 6V11H3V6C3 5.44772 3.44772 5 4 5ZM3 13V18C3 18.5523 3.44772 19 4 19H20C20.5523 19 21 18.5523 21 18V13H3Z' fill='currentColor'></path></svg>),
      "type": 'iframe'
    }
  ]
}

export const pricingInfo = {
  logo: `https://ps.w.org/${slug}/assets/icon-128x128.png`, // Optional
  pluginId: 6749,
  planId: 10994,
  licenses: [
    1,
    3,
    null
  ],
  button: {
    label: 'Buy Now ➜'
  },
  featured: {
    selected: 3, // choose from licenses item
  }
}