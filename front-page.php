<?php
/**
 * The front page template file
 *
 * If the user has selected a static page for their homepage, this is what will
 * appear.
 * Learn more: https://developer.wordpress.org/themes/basics/template-hierarchy/
 *
 * @package WordPress
 * @subpackage Twenty_Seventeen
 * @since Twenty Seventeen 1.0
 * @version 1.0
 */

get_header();?>

<div id="primary" class="content-area">
  <main id="main" class="site-main" role="main">
    <div id="books-gallery">
      <h1>ACF Repeater Field Infinite Scrooling</h1>
      <div class="row">
        <?php
if (have_rows('books')):
    // Total repeater fields
    $total = count(get_field('books'));
    // These are for displaying how many items we want to show in the first render
    // In this example 3
    $count = 0;
    $number = 2;

    while (have_rows('books')): the_row();

        $cover_image = get_sub_field('cover_image');
        $author = get_sub_field('author');
        $title = get_sub_field('title');?>

        <div class="card">
          <?php echo wp_get_attachment_image($cover_image, '', '', array('class' => 'img-cover')); ?>
          <div>
            Title : <?php echo $title ?>
          </div>
          <div>
            Author : <?php echo $author ?>
          </div>
        </div>

        <?php
        // End loop.
        if ($count == $number) {
            // check the number of repeater fields that we want to show in the first render
            break;
        }?>

        <?php $count++;endwhile;

else:
    // Do something...
endif;?>
      </div>

      <a id="gallery-load-more" href="javascript: repeater_load_more();" <?php if ($count > $number) {?>
        style="display: none;" <?php }?>>
        <h2 id="title-bg"><span>Load more</span></h2>
      </a>
    </div>
  </main>
</div>

<script type="text/javascript">
var my_repeater_field_post_id = <?php echo $post->ID; ?>;
var my_repeater_field_offset = <?php echo $number + 1; ?>;
// var my_repeater_field_nonce = '<?php echo wp_create_nonce('my_repeater_field_nonce'); ?>';
var my_repeater_ajax_url = '<?php echo admin_url('admin-ajax.php'); ?>';
var my_repeater_more = true;

function repeater_load_more() {

  jQuery.post(
    my_repeater_ajax_url, {
      'action': 'load_more',
      'post_id': my_repeater_field_post_id,
      'offset': my_repeater_field_offset,
      // 'nonce': my_repeater_field_nonce
    },
    function(json) {
      // add content to container
      // this ID must match the containter
      // you want to append content to
      jQuery('#books-gallery .row').append(json['content']);

      // update offset
      my_repeater_field_offset = json['offset'];
      // see if there is more, if not then hide the more link
      if (!json['more']) {
        // this ID must match the id of the show more link
        jQuery('#gallery-load-more').css('display', 'none');
      }
    },
    'json'
  );
}
</script>

<?php
get_footer();