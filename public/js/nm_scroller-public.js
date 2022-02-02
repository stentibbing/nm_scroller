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

    function showActivePage(activePage) {
      $(".nm-scroller-single-page-" + nmActivePage).fadeIn(function () {
        $(this).addClass("active-scroller-page");
        const enterEvent = new Event("enter");
        $(this)[0].dispatchEvent(enterEvent);
      });
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
          $(this).removeClass("active-scroller-page");
          const leaveEvent = new Event("leave");
          $(this)[0].dispatchEvent(leaveEvent);
          showActivePage(nmActivePage);
        }
      );
    }

    function changeBackground(color) {
      $("body").animate({ backgroundColor: color }, 1500);
    }

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

    nmScrollerPages.each(function () {
      nmTotalPages++;
      $(this).addClass("nm-scroller-single-page-" + nmTotalPages);
    });

    $("body").css(
      "background-color",
      $(".nm-scroller-single-page-" + nmActivePage).attr(
        "data-background-color"
      )
    );

    hideEndScroller();
    updatePageNumber();
    showActivePage(nmActivePage);

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

    $(".nm-scroller-left, .nm-scroller-right").click(function () {
      $([document.documentElement, document.body]).animate(
        {
          scrollTop: $(".nm-scroller").offset().top,
        },
        1000
      );
    });
  });
})(jQuery);
