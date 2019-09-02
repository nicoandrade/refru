<?php
/**
 * Custom template tags for this theme.
 *
 * Eventually, some of the functionality here could be replaced by core features.
 *
 * @package Refru
 */

if ( ! function_exists( 'refru_metadata' ) ):
/**
 * Prints HTML with meta information for the current post-date/time and author.
 */
    function refru_metadata() {

        echo '<ul>';

        $time_string = '<time class="entry-date published updated" datetime="%1$s"><a href="%2$s">%3$s</a></time>';
        if ( get_the_time( 'U' ) !== get_the_modified_time( 'U' ) ) {
            $time_string = '<time class="entry-date published" datetime="%1$s"><a href="%2$s">%3$s</a></time><time class="updated" datetime="%4$s">%5$s</time>';
        }

        $time_string = sprintf( $time_string,
            esc_attr( get_the_date( 'c' ) ),
            esc_url( get_permalink() ),
            esc_html( get_the_date() ),
            esc_attr( get_the_modified_date( 'c' ) ),
            esc_html( get_the_modified_date() )
        );

        echo '<li class="meta_date">' . $time_string . '</li>';

        $avatar = get_avatar( get_the_author_meta( 'ID' ), 25 );

        $byline = sprintf(
            esc_html_x( 'by %s', 'post author', 'refru' ),
            '<span class="author vcard"><a class="url fn n" href="' . esc_url( get_author_posts_url( get_the_author_meta( 'ID' ) ) ) . '">' . esc_html( get_the_author() ) . '</a></span>'
        );

        echo '<li class="meta_author">' . $avatar . $byline . '</li>';

        // Hide category and tag text for pages.
        if ( 'post' === get_post_type() && is_single() ) {
            /* translators: used between list items, there is a space after the comma */
            $categories_list = get_the_category_list( esc_html__( ', ', 'refru' ) );
            if ( $categories_list && refru_categorized_blog() ) {
                printf( '<li class="meta_categories"><span class="cat-links">' . esc_html__( 'In %1$s', 'refru' ) . '</span></li>', $categories_list ); // WPCS: XSS OK.
            }
            /* translators: used between list items, there is a space after the comma */
            $tags_list = get_the_tag_list( '', esc_html__( ', ', 'refru' ) );
            if ( $tags_list ) {
                printf( '<li class="meta_tags"><span class="tags-links">' . esc_html__( 'Tagged %1$s', 'refru' ) . '</span></li>', $tags_list ); // WPCS: XSS OK.
            }
        }

        if ( ! post_password_required() && ( comments_open() || get_comments_number() ) ) {
            echo '<li class="meta_comments"><span class="comments-link">';
            if ( get_comments_number() > 0 && is_single() ) {
                esc_html_e( 'With ', 'refru' );
            }
            comments_popup_link( esc_html__( 'Leave a comment', 'refru' ), esc_html__( '1 Comment', 'refru' ), esc_html__( '% Comments', 'refru' ) );
            echo '</span></li>';
        }

        echo '</ul>';

    }
endif;

/**
 * Returns true if a blog has more than 1 category.
 *
 * @return bool
 */
function refru_categorized_blog() {
    if ( false === ( $all_the_cool_cats = get_transient( 'refru_categories' ) ) ) {
        // Create an array of all the categories that are attached to posts.
        $all_the_cool_cats = get_categories( array(
            'fields'     => 'ids',
            'hide_empty' => 1,

            // We only need to know if there is more than one category.
             'number'     => 2,
        ) );

        // Count the number of categories that are attached to the posts.
        $all_the_cool_cats = count( $all_the_cool_cats );

        set_transient( 'refru_categories', $all_the_cool_cats );
    }

    if ( $all_the_cool_cats > 1 ) {
        // This blog has more than 1 category so refru_categorized_blog should return true.
        return true;
    } else {
        // This blog has only 1 category so refru_categorized_blog should return false.
        return false;
    }
}

/**
 * Flush out the transients used in refru_categorized_blog.
 */
function refru_category_transient_flusher() {
    if ( defined( 'DOING_AUTOSAVE' ) && DOING_AUTOSAVE ) {
        return;
    }
    // Like, beat it. Dig?
    delete_transient( 'refru_categories' );
}
add_action( 'edit_category', 'refru_category_transient_flusher' );
add_action( 'save_post', 'refru_category_transient_flusher' );
