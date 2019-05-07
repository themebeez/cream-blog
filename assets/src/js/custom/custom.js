(function($) {

    'use strict';

    jQuery(document).ready(function() {


        /* 
        =============================
        = Init retina js  
        ================================
        */


        $('select').niceSelect();


        /* 
        =============================
        = Init retina js  
        ================================
        */

        retinajs();

        /*
        ===========================
        = Main navigation
        ====================================
        */


        $('.menu-toggle').on('click', function(e) {

            $('.main-navigation').slideToggle('medium');

            $('body').toggleClass('menu-toggle-active'); // add class to body

        });

        $('.main-navigation .menu-item-has-children').append('<span class="sub-toggle"> <i class="fa fa-caret-down" aria-hidden="true"></i> </span>');

        $('.main-navigation .page_item_has_children').append('<span class="sub-toggle"> <i class="fa fa-caret-down" aria-hidden="true"></i> </span>');


        $('.main-navigation .sub-toggle').on('click', function() {

            $(this).toggleClass('active-submenu');

            $(this).parent('.menu-item-has-children').children('ul.sub-menu').first().slideToggle('medium');

            $(this).parent('.page_item_has_children').children('ul.children').first().slideToggle('medium');

            if ($(this).hasClass('active-submenu')) {

                $(this).find('.fa').removeClass('fa-caret-down').addClass('fa-caret-up');

            } else {

                $(this).find('.fa').removeClass('fa-caret-up').addClass('fa-caret-down');
            }

        });

        $('.menu-item a[href="#"]').on('click', function(e) {

            e.preventDefault(); // prevent empty links clicks
        });


        /* 
        =============================
        = Init toggle search event  
        ================================
        */


        jQuery("body").on('click', '#search-toggle', function() {

            jQuery("#header-search").toggle()

        });


        /* 
        =================================
        = Canvas aside bar
        ====================================
        */


        var $CanvasRevelBtn = jQuery('#canvas-toggle');
        var $CanvasAside = jQuery('#canvas-aside');
        var $SideCanvasMask = jQuery('#canvas-aside-mask');

        $CanvasRevelBtn.on('click', function() {

            $CanvasAside.addClass('visible');
            $SideCanvasMask.addClass('visible');
        });

        $SideCanvasMask.on('click', function() {

            $CanvasAside.removeClass('visible');
            $SideCanvasMask.removeClass('visible');
        });


        /* 
        =============================
        = Init sticky header 
        ================================
        */

        jQuery("#cb-stickhead").sticky({ topSpacing: 0 });;


        /* 
        =============================
        = Init sticky sidebar 
        =====================================
        */

        jQuery('.cd-stickysidebar').theiaStickySidebar({
            additionalMarginTop: 30
        });



        /* 
        ===========================================
        = Configure lazyload ( lazysizes.js ) 
        ==================================================
        */


        var lazy = function lazy() {
            document.addEventListener('lazyloaded', function(e) {
                e.target.parentNode.classList.add('image-loaded');
                $.when().done(function() {
                    var cloele = $('.thumb');
                    cloele.removeClass('lazyloading');
                });

                // e.target.parentNode.classList.add('image-loaded');
                // e.target.parentNode.classList.remove('lazyloading');

                var container = $('#bricks-row');
                container.imagesLoaded().progress(function() {
                    container.masonry({
                        itemSelector: '.brick-item',
                    });
                });
            });
        }

        lazy();

        window.lazySizesConfig = window.lazySizesConfig || {};

        lazySizesConfig.preloadAfterLoad = false;
        lazySizesConfig.expandChild = 370;


        // init masonry 

        var container = $('#bricks-row');
        container.imagesLoaded().progress(function() {
            container.masonry({
                itemSelector: '.brick-item',
            });
        });



        /* 
        =================================================
        = Init carousel for main baner ( slider )
        ===========================================================
        */


        // layout 2

        jQuery('#cb-banner-style-2').owlCarousel({
            items: 1,
            loop: true,
            lazyLoad: false,
            margin: 5,
            smartSpeed: 800,
            nav: true,
            dots: false,
            autoplay: true,
            autoplayTimeout: 8000,
            autoplayHoverPause: true,
            navText: ["<i class='feather icon-arrow-left'></i>", "<i class='feather icon-arrow-right'></i>"],
        });


        // Layout six 

        jQuery('#cb-slider-style-6').owlCarousel({
            items: 1,
            loop: true,
            lazyLoad: false,
            margin: 0,
            smartSpeed: 900,
            nav: false,
            dots: false,
            autoplay: true,
            autoplayTimeout: 2000,
            autoplayHoverPause: true,
            navText: ["<i class='feather icon-arrow-left'></i>", "<i class='feather icon-arrow-right'></i>"],
        });

        /* 
        =============================
        = Append back to top btn 
        =====================================
        */

        jQuery('body').append('<div id="toTop" class="btn-general"><i class="feather icon-arrow-up"></i></div>');

        jQuery(window).on('scroll', function() {
            if (jQuery(this).scrollTop() != 0) {
                jQuery('#toTop').fadeIn();
            } else {
                jQuery('#toTop').fadeOut();
            }
        });

        jQuery("body").on('click', '#toTop', function() {

            jQuery("html, body").animate({ scrollTop: 0 }, 800);
            return false;

        });

    });

})(jQuery);