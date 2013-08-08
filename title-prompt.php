<?php
/*
Plugin Name: Title Prompt
Plugin URI: http://wordpress.org/extend/plugins/titleprompt/
Description: Tweaking the WordPress title prompt.
Version: 0.1
Author: Shaun Andrews
Author URI: http://automattic.com
License: GPLv2 or later
License URI: http://www.gnu.org/licenses/gpl-2.0.html
*/

// Enqueue some new styles
add_action( 'admin_print_styles', 'tp_add_wp_admin_style' );
function tp_add_wp_admin_style() {
	wp_enqueue_style( 'title-prompt', plugins_url( "title-prompt.css", __FILE__ ), array(), '20111209' );
}

// Update the Post Title HTML
add_action( 'edit_form_after_title', 'tp_post_title_wrap_html' );
function tp_post_title_wrap_html( $post ) { ?>
<div id="post-title">
	<label id="title-prompt" for="title"><?php echo apply_filters( 'enter_title_here', __( 'Enter title here' ), $post ); ?></label>
	<input type="text" name="post_title" size="30" value="<?php echo esc_attr( htmlspecialchars( $post->post_title ) ); ?>" id="title" autocomplete="off" />
</div>
<script type="text/javascript">
/**
 * Title Prompt JS
 */
(function($) {
	// Replace the old with the new
	var old_title_wrap = $( '#titlewrap' ),
		new_title_wrap = $( '#post-title' );
	old_title_wrap.replaceWith( new_title_wrap );

	// Check if the is a title, and hide the label
	if ( $( '#title' ).val() != '' )
		$( '#title-prompt' ).hide();

	// Mark the label as active when focused on the input
	$( '#title' ).focus( function() {
		$( '#title-prompt' ).addClass( 'active' );
	});

	// Check the text typed and react occordingly
	$( '#title' ).blur( function () {
		if ( $( this ).val() == '' ) {
			$( '#title-prompt' ).fadeIn();
			$( '#title-prompt' ).removeClass( 'active' );
		} else {
			$( '#title-prompt' ).hide();
			$( '#title-prompt' ).removeClass( 'active' );
		}
	});
})(jQuery);
</script>
<?php }