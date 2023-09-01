<?php
function starterkit_block_category( $categories, $post ) {
	return array_merge(
		$categories,
		array(
			array(
				'slug' => 'eb-blocks',
				'title' => __( 'EB Blocks', 'eb-blocks' ),
			),
		)
	);
}
add_filter( 'block_categories_all', 'starterkit_block_category', 10, 2);