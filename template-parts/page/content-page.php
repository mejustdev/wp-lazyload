<?php
/**
 * Template part for displaying page content in page.php
 *
 * @link https://developer.wordpress.org/themes/basics/template-hierarchy/
 *
 * @package WordPress
 * @subpackage Twenty_Seventeen
 * @since Twenty Seventeen 1.0
 * @version 1.0
 */
?>
<article id="post-<?php the_ID();?>" <?php post_class();?>>
  <header class="entry-header">
    <?php the_title('<h1 class="entry-title">', '</h1>');?>
    <?php twentyseventeen_edit_link(get_the_ID());?>
  </header><!-- .entry-header -->
  <div class="entry-content">
    <div id="books-gallery">
      <h1>ACF Flexible Content Infinite Scrooling</h1>
      <div class="row">
        <?php
// Check value exists.
if (have_rows('movies')):

    // Loop through rows.
    while (have_rows('movies')): the_row();

        // Case: Paragraph layout.
        if (get_row_layout() == 'information'):
            $image = get_sub_field('image');
            $artist = get_sub_field('artist');
            $description = get_sub_field('description');
            ?>
        <div class="card">
          <?php echo wp_get_attachment_image($image, '', '', array('class' => 'img-cover')); ?>
          <div>
            Artist : <?php echo $artist ?>
          </div>
          <div>
            Description : <?php echo $description ?>
          </div>
        </div>
        <?php
            // Case: Download layout.
        elseif (get_row_layout() == 'extra'):
            $info = get_sub_field('info');?>
        <div class="card">
          <h1>Info <?php echo $info ?></h1>
        </div>
        <?php
            // Case: Download layout.
        elseif (get_row_layout() == 'section'):
            // $detail_columns = get_sub_field('detail_columns');
            $rows = get_sub_field('detail_columns');
            if ($rows) {

                foreach ($rows as $row) {
                    $name = $row['name'];
                    $position = $row['position'];?>
        <div class="card">
          <div>
            Name : <?php echo $name ?>
          </div>
          <div>
            Position : <?php echo $position ?>
          </div>
        </div>

        <?php }

            }

        endif;

        // End loop.
    endwhile;

    // No value.
else:
    // Do something...
endif;

wp_link_pages(
    array(
        'before' => '<div class="page-links">' . __('Pages:', 'twentyseventeen'),
        'after' => '</div>',
    )
);
?>
      </div>
    </div>
  </div><!-- .entry-content -->
</article><!-- #post-<?php the_ID();?> -->