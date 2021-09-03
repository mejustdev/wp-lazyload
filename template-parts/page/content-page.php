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
    <div id="movies-gallery">
      <h1>ACF Flexible Content Infinite Scrooling</h1>
      <div class="row">
        <?php
// Check value exists.
if (have_rows('movies')) {
    // Total flexible content layouts
    $total = count(get_field('movies'));
    // These are for displaying how many items we want to show in the first render
    // In this example 2 ($number + 1)
    $count = 0;
    $number = 1;

    // Loop through rows.
    while (have_rows('movies')) {the_row();

        // Case: information layout.
        if (get_row_layout() == 'information') {
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
if ($count == $number) {
                // check the number of flexible content fields that we want to show in the first render
                break;
            }

            $count++;
            // Case: extra layout.
        } else if (get_row_layout() == 'extra') {
            $info = get_sub_field('info');?>
        <div class="card">
          <h1>Info <?php echo $info ?></h1>
        </div>
        <?php
if ($count == $number) {
                // check the number of flexible content fields that we want to show in the first render
                break;
            }

            $count++;
            // Case: section layout.
        } else if (get_row_layout() == 'section') {
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
            ;
            if ($count == $number) {
                // check the number of flexible content fields that we want to show in the first render
                break;
            }

            $count++;
        }
    }
    ;

// No value.
} else {
    return;
}
;?>
      </div>
      <a id="movies-load-more" href="javascript: flexible_content_load_more();" <?php if ($count > $number) {?>
        style="display: none;" <?php }?>>
        <h2 id="title-bg"><span>Load more</span></h2>
      </a>
    </div>
  </div><!-- .entry-content -->
</article><!-- #post-<?php the_ID();?> -->
<script type="text/javascript">
var my_repeater_field_post_id = <?php echo $post->ID; ?>;
var my_repeater_field_offset = <?php echo $number + 1; ?>;
// var my_repeater_field_nonce = '<?php echo wp_create_nonce('my_repeater_field_nonce'); ?>';
var my_repeater_ajax_url = '<?php echo admin_url('admin-ajax.php'); ?>';
var my_repeater_more = true;

function flexible_content_load_more() {

  jQuery.post(
    my_repeater_ajax_url, {
      // action names must be unique in entire website
      'action': 'load_more_flex',
      'post_id': my_repeater_field_post_id,
      'offset': my_repeater_field_offset,
      // 'nonce': my_repeater_field_nonce
    },
    function(json) {
      // add content to container
      // this ID must match the container
      // We want to append content to
      jQuery('#movies-gallery .row').append(json['content']);

      // update offset
      my_repeater_field_offset = json['offset'];
      // see if there is more, if not then hide the more link
      if (!json['more']) {
        // this ID must match the id of the show more link
        jQuery('#movies-load-more').css('display', 'none');
      }
    },
    'json'
  );
}
</script>