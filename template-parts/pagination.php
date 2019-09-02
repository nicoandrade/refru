
<div class="clearfix"></div>
<?php
if ( ! class_exists( 'Jetpack' ) || ! Jetpack::is_module_active( 'infinite-scroll' ) ) :
	$temp_query = $wp_query;
	global $the_query;//The query from the portfolio

	if ( isset( $the_query ) ) {
		$wp_query = $the_query;
	}
	$pagination = get_the_posts_pagination( array(
	    'prev_text'          => esc_html__( 'Previous page', 'refru' ),
		'next_text'          => esc_html__( 'Next page', 'refru' )
	) );

	if ( $pagination ) {
		echo '<div class="pagination_wrap">';
		echo wp_kses_post( $pagination );
		echo '</div><!-- /pagination_wrap -->';
	}
	$wp_query = $temp_query;
	wp_reset_postdata();
endif;
?>