## With/without button infinite scrolling 
#### (Works on any page – tags, categories, custom post type archives, search etc.)

<br/>

### Files -- [Credit](https://rudrastyh.com/wordpress/load-more-posts-ajax.html)

 - myloadmore.js
 - index.php
 - functions.php

<br/><br/>

## 1. With Load More button:

### `myloadmore.js` file 

```
jQuery(function($){ // use jQuery code inside this to avoid "$ is not defined" error
	$('.misha_loadmore').click(function(){
 
		var button = $(this),
		    data = {
			'action': 'loadmore',
			'query': misha_loadmore_params.posts, // that's how we get params from wp_localize_script() function
			'page' : misha_loadmore_params.current_page
		};
 
		$.ajax({ // you can also use $.post here
			url : misha_loadmore_params.ajaxurl, // AJAX handler
			data : data,
			type : 'POST',
			beforeSend : function ( xhr ) {
				button.text('Loading...'); // change the button text, you can also add a preloader image
			},
			success : function( data ){
				if( data ) { 
					button.text( 'More posts' ).prev().before(data); // insert new posts
					misha_loadmore_params.current_page++;
 
					if ( misha_loadmore_params.current_page == misha_loadmore_params.max_page ) 
						button.remove(); // if last page, remove the button
 
					// you can also fire the "post-load" event here if you use a plugin that requires it
					// $( document.body ).trigger( 'post-load' );
				} else {
					button.remove(); // if no data, remove the button as well
				}
			}
		});
	});
});
```

### index.php

```
<?php
global $wp_query; // you can remove this line if everything works for you
 
// don't display the button if there are not enough posts
if (  $wp_query->max_num_pages > 1 )
	echo '<div class="misha_loadmore">More posts</div>'; // you can use <a> as well
?>
```

<br/><br/>

## 2. Without Load More button 

### `myloadmore.js` file 

```
jQuery(function($){
	var canBeLoaded = true, // this param allows to initiate the AJAX call only if necessary
	    bottomOffset = 2000; // the distance (in px) from the page bottom when you want to load more posts
 
	$(window).scroll(function(){
		var data = {
			'action': 'loadmore',
			'query': misha_loadmore_params.posts,
			'page' : misha_loadmore_params.current_page
		};
		if( $(document).scrollTop() > ( $(document).height() - bottomOffset ) && canBeLoaded == true ){
			$.ajax({
				url : misha_loadmore_params.ajaxurl,
				data:data,
				type:'POST',
				beforeSend: function( xhr ){
					// you can also add your own preloader here
					// you see, the AJAX call is in process, we shouldn't run it again until complete
					canBeLoaded = false; 
				},
				success:function(data){
					if( data ) {
						$('#main').find('article:last-of-type').after( data ); // where to insert posts
						canBeLoaded = true; // the ajax is completed, now we can run it again
						misha_loadmore_params.current_page++;
					}
				}
			});
		}
	});
});

```

### index.php

```
// Just comment out this part.

<?php
global $wp_query; // you can remove this line if everything works for you
 
// don't display the button if there are not enough posts
if (  $wp_query->max_num_pages > 1 )
	echo '<div class="misha_loadmore">More posts</div>'; // you can use <a> as well
?>
```

## With/without button infinite scrolling 
#### (ACF Repeater field with custom post type -- books)


<br/>

### Files -- [Credit](https://silvawebdesigns.com/acf-repeater-load-more-using-ajax/)

 - front-page.php
 - functions.php 
    - repeater_load_more()
    - CPT--books