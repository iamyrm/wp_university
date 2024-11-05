<?php get_header();

while (have_posts()) {
  the_post();
  pageBanner(array(
    'title' => 'This is a title',
    'subtitle' => 'This is subtitle',
    'photo' => 'https://img.freepik.com/free-photo/clean-shore-ban-stone-trees-green_1417-1275.jpg?t=st=1730806209~exp=1730809809~hmac=10be4f5bbc1428667acaf810af803c91d2908f8f6e29d70f3535a7b14b05238a&w=996',
  ));

?>


  <div class="container container--narrow page-section">
    <?php
    $theParent = wp_get_post_parent_id(get_the_ID());
    if ($theParent) {
    ?>
      <div class="metabox metabox--position-up metabox--with-home-link">
        <p>
          <a class="metabox__blog-home-link" href="<?php echo get_permalink($theParent) ?>"><i class="fa fa-home" aria-hidden="true"></i> Back to <?php echo get_the_title($theParent); ?></a> <span class="metabox__main">
            <?php the_title(); ?>
          </span>
        </p>
      </div>
    <?php
    }
    ?>

    <?php
    $testArray = get_pages(array(
      'child_of' => get_the_ID(),
    ));
    if ($theParent || $testArray) {
    ?> <div class="page-links">
        <h2 class="page-links__title"><a href="<?php echo get_permalink($theParent) ?>"><?php echo get_the_title($theParent) ?></a></h2>
        <ul class="min-list">
          <?php
          if ($theParent) {
            $findChildrenOf = $theParent;
          } else {
            $findChildrenOf = get_the_ID();
          }
          wp_list_pages(array(
            'title_li' => NULL,
            'child_of' => $findChildrenOf,
            'sort_column' => 'menu_order'
          ));
          ?>
        </ul>
      </div>

    <?php } ?>

    <div class="generic-content">
      <?php the_content(); ?>
    </div>
  </div>

<?php

}

get_footer();
?>