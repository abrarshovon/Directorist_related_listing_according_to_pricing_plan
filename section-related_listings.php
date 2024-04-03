<?php
/**
 * @author  wpWax
 * @since   6.6
 * @version 7.4.0
 */

if ( ! defined( 'ABSPATH' ) ) exit;
$current_listing_id = get_the_ID(); // Retrieve the ID of the current listing


// Assuming $listing_id holds the ID of the listing
global $wpdb;

// Prepare and execute the SQL query
$post_id = $wpdb->get_var( $wpdb->prepare( 
    "
    SELECT post_id
    FROM {$wpdb->prefix}postmeta
    WHERE meta_key = '_listing_id' AND meta_value = %s
    ",
    $current_listing_id
) );

// Check if a post ID was found

$payment_gateway = get_post_meta( $post_id, '_payment_gateway', true );



$related = $listing->get_related_listings();

if ( !$related->have_posts() ) {
	return;
}
?>
<?php
if ($payment_gateway === 'free') {
    // Show the section only if $payment_gateway is 'free'
?>
<div class="directorist-related <?php echo esc_attr( $class );?>" <?php $listing->section_id( $id ); ?>>

    <div class="directorist-related-listing-header">

        <h4><?php echo esc_html( $label );?></h4>

    </div>


    <div class="directorist-related-carousel" data-attr="<?php echo esc_attr( $listing->related_slider_attr() ); ?>">

        <?php foreach ( $related->post_ids() as $listing_id ): ?>

            <?php $related->loop_template( 'grid', $listing_id ); ?>
           

        <?php endforeach; ?>

    </div>

</div>
<?php
}
?>


