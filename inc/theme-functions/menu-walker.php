<?php
/**
 * Descriptions on Header Menu
 * @author Bill Erickson
 * @link http://www.billerickson.net/code/add-description-to-wordpress-menu-items/
 * 
 * @param string $item_output, HTML outputp for the menu item
 * @param object $item, menu item object
 * @param int $depth, depth in menu structure
 * @param object $args, arguments passed to wp_nav_menu()
 * @return string $item_output
 */
function refru_header_menu_desc( $item_output, $item, $depth, $args ) {
	
	if( 'primary' == $args->theme_location && $depth < 2 && $item->description )
		$item_output = str_replace( '</a>', '<span class="description">' . $item->description . '</span></a>', $item_output );
		
	return $item_output;
}
add_filter( 'walker_nav_menu_start_el', 'refru_header_menu_desc', 10, 4 );