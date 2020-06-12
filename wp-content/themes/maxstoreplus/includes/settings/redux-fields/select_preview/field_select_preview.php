<?php

/**
 * Redux Framework is free software: you can redistribute it and/or modify
 * it under the terms of the GNU General Public License as published by
 * the Free Software Foundation, either version 2 of the License, or
 * any later version.
 * Redux Framework is distributed in the hope that it will be useful,
 * but WITHOUT ANY WARRANTY; without even the implied warranty of
 * MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE. See the
 * GNU General Public License for more details.
 * You should have received a copy of the GNU General Public License
 * along with Redux Framework. If not, see <http://www.gnu.org/licenses/>.
 *
 * @package     ReduxFramework
 * @subpackage  Field_Date
 * @author      Daniel J Griffiths (Ghost1227)
 * @author      Dovy Paukstys
 * @author      Kevin Provance (kprovance)
 * @version     3.0.0
 */

// Exit if accessed directly
if ( !defined( 'ABSPATH' ) ) {
	exit;
}

// Don't duplicate me!
if ( !class_exists( 'ReduxFramework_select_preview' ) ) {
	/**
	 * Main ReduxFramework_date class
	 *
	 * @since       1.0.0
	 */
	class ReduxFramework_select_preview
	{
		/**
		 * Field Constructor.
		 * Required - must call the parent constructor, then assign field and value to vars, and obviously call the render field function
		 *
		 * @return        void
		 * @since         1.0.0
		 * @access        public
		 */
		function __construct( $field, $value, $parent )
		{
			$this->parent = $parent;
			$this->field  = $field;
			$this->value  = $value;
		}

		/**
		 * Field Render Function.
		 * Takes the vars and outputs the HTML for the field in the settings
		 *
		 * @return        void
		 * @since         1.0.0
		 * @access        public
		 */
		public function render()
		{
			echo '<div class="container-select-preview">';
			echo '<select id="' . $this->field['id'] . '-select-preview" name="' . $this->field['name'] . $this->field['name_suffix'] . '" class="select2 redux-select-item redux-select-images">';
			foreach ( $this->field['options'] as $key => $value ) {
				$selected = selected( $this->value, $key, false );
				echo '<option data-preview="' . $value['preview'] . '" value="' . $key . '" ' . $selected . '>' . $value['title'] . '</option>';
			}
			echo '</select>';
			$url = '';
			if ( isset( $this->field['options'][$this->value] ) ) {
				$url = $this->field['options'][$this->value]['preview'];
			}
			echo '<div class="preview"><img src="' . esc_url( $url ) . '" alt="preview"></div>';
			echo "</div>";
		}

		/**
		 * Enqueue Function.
		 * If this field requires any scripts, or css define this function and register/enqueue the scripts/css
		 *
		 * @return        void
		 * @since         1.0.0
		 * @access        public
		 */
		public function enqueue()
		{
			if ( $this->parent->args['dev_mode'] ) {
				wp_enqueue_style(
					'redux-field-select-preview-css',
					get_theme_file_uri( 'includes/settings/redux-fields/select_preview/field_select_preview.css' ),
					array(),
					time(),
					'all'
				);
			}
			wp_enqueue_script(
				'redux-field-select_preview-js',
				get_theme_file_uri( 'includes/settings/redux-fields/select_preview/field_select_preview.js' ),
				array( 'jquery', 'jquery-ui-core', 'jquery-ui-datepicker', 'redux-js' ),
				time(),
				true
			);
		}
	}
}