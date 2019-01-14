<?php
/**
 * Template part for displaying header layout one
 *
 * @link https://developer.wordpress.org/themes/basics/template-hierarchy/
 *
 * @package Cream_Blog
 */
?>
<header class="general-header header-style-3">
    <div class="header-inner">
        
        <div class="cb-header-top">
            <div class="cb-container">
                <div class="site-branding-holder">
                    <?php
                    /**
                    * Hook - cream_blog_site_identity.
                    *
                    * @hooked cream_blog_site_identity_action - 10
                    */
                    do_action( 'cream_blog_site_identity' );
                    ?>
                </div><!-- .site-branding-holder -->
            </div><!-- .cb-container -->
            <div class="mask"></div>
        </div><!-- .cb-header-top -->
        
        <?php $sticky_menu_id = cream_blog_main_menu_sticky_id(); ?>
        <div <?php if( !empty( $sticky_menu_id ) ) { ?>id="<?php echo esc_attr( $sticky_menu_id ); ?>"<?php } ?> class="cb-navigation-main-outer">
            <div class="cb-container">
                <div class="primary-menu-wrap">
                    <div class="menu-toggle">
                        <span class="hamburger-bar"></span>
                        <span class="hamburger-bar"></span>
                        <span class="hamburger-bar"></span>
                    </div><!-- .menu-toggle -->
                    <div class="main-navigation" id="main-nav">
        
                        <?php
                        /**
                        * Hook - cream_blog_main_menu.
                        *
                        * @hooked cream_blog_main_menu_action - 10
                        */
                        do_action( 'cream_blog_main_menu' );
                        ?>
                    </div><!-- #main-nav.main-navigation -->
                    <div class="nav-extraa">
                        <?php
                        /**
                        * Hook - cream_blog_sidebar_toggle_button.
                        *
                        * @hooked cream_blog_sidebar_toggle_button_action - 10
                        */
                        do_action( 'cream_blog_sidebar_toggle_button' );

                        /**
                        * Hook - cream_blog_search_button.
                        *
                        * @hooked cream_blog_search_button_action - 10
                        */
                        do_action( 'cream_blog_search_button' );

                        /**
                        * Hook - cream_blog_toogle_search_form.
                        *
                        * @hooked cream_blog_toogle_search_form_action - 10
                        */
                        do_action( 'cream_blog_toogle_search_form' );
                        ?>
                    </div><!-- .nav-extraa -->
                </div><!-- .primary-menu-wrap -->
            </div><!-- .cb-container -->
        </div><!-- .cb-navigation-main-outer -->
    </div><!-- .header-inner -->
</header><!-- .general-header.header-style-3.cb-mega-menu -->