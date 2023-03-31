<p <?php echo get_block_wrapper_attributes(); ?>>
	<?php esc_html_e( 'Custom Users Block TEst – hello from a dynamic block!', 'custom-users-block' ); ?>
</p>

<?php


// Assuming you have the content of the post or page that contains the block saved in a variable called $content.

$blocks = parse_blocks( $content );

echo '<br><pre> '.print_r($blocks,true).'</pre><br>';
// foreach ( $blocks as $block ) {
//   if ( 'my-plugin/my-block' === $block['blockName'] ) {
//     $text = $block['attrs']['text'];
//     // Do something with the saved value of the "text" attribute.
//   }
// }


echo get_the_ID();
// Retrieve the saved attribute for the block
// $selected_option = get_post_meta(get_the_ID(), 'create-block/custom-users-block', true)['selectedOption'];
$selected_option = get_post_meta(get_the_ID(), 'create-block/custom-users-block-selectedOption', true);



echo '<br><pre>selected_option: '.print_r($selected_option,true).'</pre><br>';
// Render the select box with options
// echo '<select name="selectedOption">';
// echo '<option value="Option
