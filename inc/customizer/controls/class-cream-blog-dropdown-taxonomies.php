<?php
/**
 * Custom customizer control class for dropdown taxonomies.
 *
 * @package    Cream_Blog
 * @author     Themebeez <themebeez@gmail.com>
 * @copyright  Copyright (c) 2018, Themebeez
 * @link       http://themebeez.com/themes/cream-blog/
 * @license    http://www.gnu.org/licenses/old-licenses/gpl-2.0.html
 */

if( class_exists( 'WP_Customize_Control' ) ) {
	/**
   * Class Cream_Blog_Dropdown_Taxonomies
   */
  class Cream_Blog_Dropdown_Taxonomies extends WP_Customize_Control {

  	public $type = 'dropdown-taxonomies';
  	public $taxonomy = '';

  	public function __construct( $manager, $id, $args = array() ) {
    	$our_taxonomy = 'category';
    	if ( isset( $args['taxonomy'] ) ) {
      	$taxonomy_exist = taxonomy_exists( esc_attr( $args['taxonomy'] ) );
      	if ( true === $taxonomy_exist ) {
        	$our_taxonomy = esc_attr( $args['taxonomy'] );
      	}
    	}	
      $args['taxonomy'] = $our_taxonomy;
      $this->taxonomy = esc_attr( $our_taxonomy );
      parent::__construct( $manager, $id, $args );
  	}

  	public function render_content() {
      $tax_args = array(
      	'hierarchical' => 0,
      	'taxonomy'     => $this->taxonomy,
      );
      $all_taxonomies = get_categories( $tax_args );
    	?>
    	<label>
      	<span class="customize-control-title"><?php echo esc_html( $this->label ); ?></span>
     		<select <?php echo esc_attr( $this->link() ); ?>>
        	<?php
          	printf('<option value="%s" %s>%s</option>', '', selected($this->value(), '', false),esc_html__('Select', 'cream-blog') );
         	?>
        	<?php if ( ! empty( $all_taxonomies ) ): ?>
          	<?php foreach ( $all_taxonomies as $key => $tax ): ?>
            <?php
              printf('<option value="%s" %s>%s</option>', esc_attr( $tax->term_id ), selected($this->value(), esc_attr( $tax->term_id ), false), esc_html( $tax->name ) );
            ?>
          	<?php endforeach ?>
       		<?php endif ?>
     		</select>
    	</label>
    	<?php
  	}
  }
}
