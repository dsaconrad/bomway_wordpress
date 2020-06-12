<?php
/**
 * Shows a breadcrumb for all types of pages.  This is a wrapper function for the Breadcrumb_Trail class,
 * which should be used in theme templates.
 *
 * @since  0.1.0
 * @access public
 *
 * @param  array $args Arguments to pass to Breadcrumb_Trail.
 *
 * @return void
 */
if( !function_exists('maxstoreplus_breadcrumb_trail')){
    function maxstoreplus_breadcrumb_trail( $args = array() ) {

        $breadcrumb = apply_filters( 'breadcrumb_trail_object', null, $args );

        if ( !is_object( $breadcrumb ) ) {
            $breadcrumb = new Maxstoreplus_breadcrumb_trail( $args );
        }

        return $breadcrumb->trail();
    }

}

if( class_exists('Breadcrumb_Trail') && !class_exists('Maxstoreplus_breadcrumb_trail') ){
	class Maxstoreplus_breadcrumb_trail extends Breadcrumb_Trail{
		/**
	 * Formats the HTML output for the breadcrumb trail.
	 *
	 * @since  0.6.0
	 * @access public
	 * @return string
	 */
	public function trail() {

		// Set up variables that we'll need.
		$breadcrumb = '';
		$item_count = count( $this->items );
		$item_position = 0;

		// Connect the breadcrumb trail if there are items in the trail.
		if ( 0 < $item_count ) {

			// Add 'browse' label if it should be shown.
			if ( true === $this->args['show_browse'] && trim( $this->labels['browse'] ) != '' ) {
				$breadcrumb .= sprintf( '<h2 class="trail-browse">%s</h2>', $this->labels['browse'] );
			}

			// Add the number of items and item list order schema.
			//$breadcrumb .= sprintf( '<meta name="numberOfItems" content="%d" />', absint( $item_count ) );
			//$breadcrumb .= '<meta name="itemListOrder" content="Ascending" />';

			// Open the unordered list.

			// Loop through the items and add them to the list.
			foreach ( $this->items as $item ) {

				// Iterate the item position.
				++$item_position;

				// Check if the item is linked.
				preg_match( '/(<a.*?>)(.*?)(<\/a>)/i', $item, $matches );

				// Wrap the item text with appropriate itemprop.
				$item = !empty( $matches ) ? sprintf( '%s<span itemprop="name">%s</span>%s', $matches[1], $matches[2], $matches[3] ) : sprintf( '<span itemprop="name">%s</span>', $item );

				// Add list item classes.
				$item_class = 'trail-item';

				if ( 1 === $item_position && 1 < $item_count ) {
					$item_class .= ' trail-begin';
				}

				elseif ( $item_count === $item_position ) {
					$item_class .= ' trail-end';
				}

				// Create list item attributes.
				$attributes = 'itemprop="itemListElement" itemscope itemtype="http://schema.org/ListItem" class="' . $item_class . '"';

				// Build the meta position HTML.
				$meta = sprintf( '<meta itemprop="position" content="%s" />', absint( $item_position ) );

				// Build the list item.
				$breadcrumb .= sprintf( '%s', $item);
			}

			// Close the unordered list.

			// Wrap the breadcrumb trail.
			$breadcrumb = sprintf(
				'<%1$s aria-label="%2$s" class="breadcrumb-trail breadcrumbs breadcrumb">%3$s%4$s%5$s</%1$s>',
				tag_escape( $this->args['container'] ),
				esc_attr( $this->labels['aria_label'] ),
				$this->args['before'],
				$breadcrumb,
				$this->args['after']
			);
		}

		// Allow developers to filter the breadcrumb trail HTML.
		$breadcrumb = apply_filters( 'breadcrumb_trail', $breadcrumb, $this->args );

		if ( false === $this->args['echo'] ) {
			return $breadcrumb;
		}

		echo $breadcrumb;
	}
	}
}