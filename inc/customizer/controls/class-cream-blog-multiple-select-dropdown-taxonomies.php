<?php
/**
 * Custom customizer control class for multiple select dropdown taxonomies.
 *
 * @package    Cream_Blog
 * @author     Themebeez <themebeez@gmail.com>
 * @copyright  Copyright (c) 2018, Themebeez
 * @link       http://themebeez.com/themes/cream-blog/
 * @license    http://www.gnu.org/licenses/old-licenses/gpl-2.0.html
 */

if ( ! class_exists( 'WP_Customize_Control' ) ) {
	return;
}

/**
 * Multiple taxonomy terms select dropdown control.
 *
 * @since 1.0.0
 *
 * @see WP_Customize_Control
 */
class Cream_Blog_Multiple_Select_Dropdown_Taxonomies extends WP_Customize_Control {
	/**
	 * The type of control being rendered.
	 *
	 * @since 1.0.0
	 *
	 * @var string
	 */
	public $type = 'multiple-select-dropdown-taxonomies';

	/**
	 * Renders the control wrapper and calls $this->render_content() for the internals.
	 *
	 * @since 1.0.0
	 */
	public function render_content() {

		$default_values = ( $this->value() ) ? $this->value() : array();
		$choices        = $this->choices;
		?>
			<label>
				<span class="customize-control-title">
					<?php echo esc_html( $this->label ); ?>
				</span>
				<?php
				if ( $this->description ) {
					?>
					<span class="description customize-control-description">
					<?php echo wp_kses_post( $this->description ); ?>
					</span>
					<?php
				}
				?>
				<select multiple="multiple" class="hs-chosen-select" <?php $this->link(); ?>>
					<?php
					if ( $choices ) {
						foreach ( $choices as $value => $label ) {
							$selected = '';
							if ( is_array( $default_values ) && array_key_exists( $value, $default_values ) ) {
								$selected = 'selected';
							} else {
								$selected = ( $default_values === $value ) ? 'selected' : '';
							}
							?>
							<option
								value="<?php echo esc_attr( $value ); ?>"
								<?php echo $selected; // phpcs:ignore ?>
							><?php echo esc_html( $label ); ?></option>
							<?php
						}
					}
					?>
				</select>
			</label>
		<?php
	}
}
