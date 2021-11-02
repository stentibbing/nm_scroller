(function ($) {
  "use strict";

  let nmActivePage = 1;
  let nmTotalPages = 0;

  $(function () {
    const nmScrollerPages = $(".nm-scroller-single-page");

    function updatePageNumber() {
      $(".nm-scroller-cur-page").html(nmActivePage);
      $(".nm-scroller-total-pages").html("/" + nmTotalPages);
    }

    function scrollPage(increment) {
      nmActivePage = nmActivePage + increment;
      updatePageNumber();
      changeBackground(
        $(".nm-scroller-single-page-" + nmActivePage).attr(
          "data-background-color"
        )
      );
      $(".nm-scroller-single-page-" + (nmActivePage - increment)).fadeOut(
        function () {
          $(".nm-scroller-single-page-" + nmActivePage).fadeIn();
        }
      );
    }

    function changeBackground(color) {
      $("body").animate({ backgroundColor: color }, 1500);
    }

    nmScrollerPages.each(function () {
      nmTotalPages++;
      $(this).addClass("nm-scroller-single-page-" + nmTotalPages);
      $(this).hide();
    });

    $("body").css(
      "background-color",
      $(".nm-scroller-single-page-" + nmActivePage).attr(
        "data-background-color"
      )
    );

    function hideEndScroller() {
      if (nmActivePage == 1) {
        $(".nm-scroller-left").css("visibility", "hidden");
      } else {
        $(".nm-scroller-left").css("visibility", "visible");
      }

      if (nmActivePage >= nmTotalPages) {
        $(".nm-scroller-right").css("visibility", "hidden");
      } else {
        $(".nm-scroller-right").css("visibility", "visible");
      }
    }

    hideEndScroller();
    updatePageNumber();

    $(".nm-scroller-left").click(function () {
      if (nmActivePage != 1) {
        scrollPage(-1);
        hideEndScroller();
      }
    });

    $(".nm-scroller-right").click(function () {
      if (nmActivePage != nmTotalPages) {
        scrollPage(1);
        hideEndScroller();
      }
    });

    $(".nm-scroller-single-page-" + nmActivePage).show();
  });
})(jQuery);
