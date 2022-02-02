<?php 

ob_start();
?>

<div class="nm-scroller">

  <div class="nm-scroller-nav">
    <div class="nm-scroller-left"></div>
    <div class="nm-scroller-page-number">
      <span class="nm-scroller-cur-page"></span>
      <span class="nm-scroller-total-pages"></span>
    </div>
    <div class="nm-scroller-right"></div>
  </div>

  <div class="nm-scroller-pages">
    <?php foreach ($scroller_pages as $page): ?>
      <?php if ($page->post_status == 'publish'): ?>
        <?php $page_background = '#' . get_post_meta($page->ID)['nm_scroller_background_color'][0]; ?>
        <div class="nm-scroller-single-page" data-background-color="<?php echo $page_background; ?>">
          <?php echo apply_filters('the_content', $page->post_content); ?>
        </div>
      <?php endif; ?>
    <?php endforeach; ?>
  </div>

  <div class="nm-scroller-nav mobile">
    <div class="nm-scroller-left"></div>
    <div class="nm-scroller-page-number">
      <span class="nm-scroller-cur-page"></span>
      <span class="nm-scroller-total-pages"></span>
    </div>
    <div class="nm-scroller-right"></div>
  </div>

</div>

<?php
  return ob_get_clean();
?>