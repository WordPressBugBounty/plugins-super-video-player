import { settingImage, themeImage } from "./icons";

const slug = "super-video-player";
export const dashboardInfo = (info) => {
  const { version, isPremium, hasPro } = info;

  const proSuffix = isPremium ? " Pro" : "";

  return {
    name: `Super Video Player${proSuffix}`,
    displayName: `Super Video Player${proSuffix} - Fully Customizable Video Player with Playlist`,
    description:
      "Check out our simple video tutorial that guides you through using this plugin step-by-step!",
    slug,
    logo: `https://ps.w.org/${slug}/assets/icon-128x128.png`,
    banner: `https://ps.w.org/${slug}/assets/banner-772x250.png`,
    video: 'https://www.youtube.com/watch?v=LJym2Pe1h2k',
    isYoutube: true,
    version,
    isPremium,
    hasPro,
    pages: {
      org: `https://wordpress.org/plugins/${slug}/`,
      landing: `https://bplugins.com/products/${slug}/`,
      docs: `https://bplugins.com/docs/${slug}/`,
      pricing: `https://bplugins.com/products/${slug}/#pricing`,
    },
    freemius: {
      product_id: 6749,
      plan_id: 10994,
      public_key: "pk_ebfc28616ca46b064866ea36660e0",
    },
    options: { title: "Super Video Player" }
  };
};

export const demoInfo = {
  title: "Live Overview",
  description: "Click on any section to view it live",
  layout: "list",
  allInOneLabel: "See All Demos",
  allInOneLink: "https://wpvideoplayer.com/all-demos-in-one-place/",
  demos: [
    {
      icon: settingImage,
      title: "Admin Dashboard Preview",
      description: "Displays of the video player within the admin dashboard.",
      category: "",
      type: "image",
      url: "https://i.ibb.co.com/tTgC0BhY/screenshot-1.png",
    },
    {
      icon: settingImage,
      title: "Add New Video (ShortCode)",
      description: "Creates video a shortcode for easy embedding.",
      category: "",
      type: "image",
      url: "https://i.ibb.co.com/GvkmX86S/screenshot-2.png",
    },
    {
      icon: settingImage,
      title: "Configuration",
      description: "Settings panel to manage and customize video player options.",
      category: "",
      type: "image",
      url: "https://i.ibb.co.com/xtNT45ht/screenshot-3.png",
    },
    {
      icon: themeImage,
      title: "Single Player Preview",
      description: "Shows a preview of a single video item.",
      category: "",
      type: "image",
      url: "https://i.ibb.co.com/RT7v4DvT/screenshot-4.png",
    },
    {
      icon: themeImage,
      title: "Preview Playlist - Default",
      description: "Shows a default preview of the video playlist layout.",
      category: "",
      type: "image",
      url: "https://i.ibb.co.com/x8hGbk2X/screenshot-5.png",
    },
    {
      icon: themeImage,
      title: "Preview Playlist - Horizontal",
      description: "Shows a Horizontal preview of the video playlist layout.",
      category: "",
      type: "image",
      url: "https://i.ibb.co.com/0jP1rh4t/screenshot-6.png",
    },
    {
      icon: themeImage,
      title: "Preview Playlist - Vertical",
      description: "Shows a Vertical preview of the video playlist layout.",
      category: "",
      type: "image",
      url: "https://i.ibb.co.com/4wGLpx7c/screenshot-7.png",
    },
    {
      icon: themeImage,
      title: "Preview Playlist - Grid",
      description: "Shows a Grid preview of the video playlist layout.",
      category: "",
      type: "image",
      url: "https://i.ibb.co.com/FbJtxy86/screenshot-8.png",
    },
    {
      icon: settingImage,
      title: "Gutenberg Block",
      description: "Adds a Gutenberg editor posts and pages.",
      category: "",
      type: "image",
      url: "https://i.ibb.co.com/twZ0yTSh/screenshot-9.png",
    },
    {
      icon: settingImage,
      title: "Gutenberg Block Settings",
      description: "Provides customization in the Gutenberg editor.",
      category: "",
      type: "image",
      url: "https://i.ibb.co.com/spf91KM7/screenshot-10.png",
    },
  ],
};


export const pricingInfo = {
  cycles: [
    {
      cycle: "lifetime",
      label: "Lifetime",
      isDefault: true,
    },
  ],
  plans: [
    {
      name: "Single Site",
      quantity: 1,
      prices: {
        lifetime: "99",
      },
      pricePrefix: "",
      priceSuffix: "",
      isFeatured: false,
      note: "",
    },
    {
      name: "3 Sites",
      quantity: 3,
      prices: {
        lifetime: "259.99",
      },
      pricePrefix: "",
      priceSuffix: "",
      isFeatured: true,
      note: "",
    },
    {
      name: "Unlimited Sites",
      quantity: "null",
      prices: {
        lifetime: "989.99",
      },
      pricePrefix: "",
      priceSuffix: "",
      isFeatured: false,
      note: "",
    },
  ],
  features: [
    "Multiple Layout Offers to customization",
    "Add multiple videos to play a list of the videos",
    "Video Quality Set for the video",
    "Show/Hide every control of the video player",
    "Set the Initial volume for the video",
    "Set seek time in seconds",
    "Variety Styles to Customization",
    "Enable/Disable tooltips for the controls",
    "All features available on the gutenberg block.",
    "Click or tap on the video container will toggle the play/pause",
    "Display the video’s title and description below or above the player.",
  ],
  button: {
    label: "Buy Now ➜",
  },
  featured: {
    text: "Best Value",
  },
};

export const featureCompareInfo = {
  title: "Features",
  plans: [
    {
      id: "zxcvbnm", //important
      name: "Free Plan",
      color: "#485781",
    },
    {
      id: "lhmjqhk", //important
      name: `<span style='color: #485781;'>Pro Start from </span><span style='font-size: 1.3em;'>&dollar; 29/lifetime</span>`,
      color: "#146EF5",
    },
  ],
  features: [
    {
      label: "Live Stream – Play .m3u8 and .mpd file",
      plans: ["zxcvbnm", "lhmjqhk"],
    },
    {
      label: "Make the player look how you want with the markup you want",
      plans: ["zxcvbnm", "lhmjqhk"],
    },
    {
      label: "Full support for VTT captions and screen readers",
      plans: ["zxcvbnm", "lhmjqhk"],
    },
    {
      label: "Support multiple subtitle files for multiple languages",
      plans: ["zxcvbnm", "lhmjqhk"],
    },
    {
      label: "The video player is compact so it does not take a lot of real estate on your webpage",
      plans: ["zxcvbnm", "lhmjqhk"],
    },
    {
      label: "HTML5 compatible so the video files embedded with this plugin will play on iOS devices",
      plans: ["zxcvbnm", "lhmjqhk"],
    },
    {
      label: "Works on all major browsers -Edge, IE7, IE8, IE9, Safari, Firefox, Chrome",
      plans: ["zxcvbnm", "lhmjqhk"],
    },
    {
      label: "The video player is responsive. That means it works with any screen size",
      plans: ["zxcvbnm", "lhmjqhk"],
    },
    {
      label: "The player can be used to embed video files on your WordPress posts or pages",
      plans: ["zxcvbnm", "lhmjqhk"],
    },
    {
      label: "If you are selling video files from your site then you can use this plugin to offer a preview",
      plans: ["zxcvbnm", "lhmjqhk"],
    },
    {
      label: "Add the video player to any post/page using shortcode",
      plans: ["zxcvbnm", "lhmjqhk"],
    },
    {
      label: "Use autoPlay option to play a video file as soon as the page loads",
      plans: ["zxcvbnm", "lhmjqhk"],
    },
    {
      label: "You can play unlimited video",
      plans: ["zxcvbnm", "lhmjqhk"],
    },
    {
      label: "Support picture-in-picture mode",
      plans: ["zxcvbnm", "lhmjqhk"],
    },
    {
      label: "Powered by html5",
      plans: ["zxcvbnm", "lhmjqhk"],
    },
    {
      label: "Playlist: Add multiple videos to play a list of the videos",
      plans: ["lhmjqhk"],
    },
    {
      label: "Video Quality: Set different qualities for the video.",
      plans: ["lhmjqhk"],
    },
    {
      label: "Show/Hide every control of the video player",
      plans: ["lhmjqhk"],
    },
    {
      label: "Set the Initial volume for the video",
    },
    {
      label: "Set seek time in seconds",
      plans: ["lhmjqhk"],
    },
    {
      label: "Click to play: Click or tap on the video container will toggle the play/pause",
      plans: ["lhmjqhk"],
    },
    {
      label: "Enable/Disable tooltips for the controls",
      plans: ["lhmjqhk"],
    },
    {
      label: "Multiple Layout Offers of variety of themes to the video player’s appearance.",
      plans: ["lhmjqhk"],
    },
    {
      label: "Video Title & Description: Display the video’s title and description below or above the player",
      plans: ["lhmjqhk"],
    },
    {
      label: "Variety Styles: Customize the font, size, color and alignment of the video title and description",
      plans: ["lhmjqhk"],
    },
    {
      label: "All features available on the gutenberg block",
      plans: ["lhmjqhk"],
    }
  ],
};