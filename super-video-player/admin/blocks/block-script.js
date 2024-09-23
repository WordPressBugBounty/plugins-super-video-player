(function ($) {
  $(document).ready(function () {
    const scrollbarWidth = window.innerWidth - document.body.clientWidth;

    $(".wp-block-svp-create.alignfull").css({
      width: `calc(100vw - ${scrollbarWidth}px)`,
      "max-width": `calc(100vw - ${scrollbarWidth}px)`,
      margin: `0 calc(-50vw + 50% + ${scrollbarWidth / 2}px)`,
    });
  });
})(jQuery);
