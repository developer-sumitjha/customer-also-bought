<?php

// Load CSS and JS on the frontend
function cab_frontend_scripts()
{

  // css
  wp_register_style(
    'cab-frontend-style',
    CAB_PLUGIN_URL . 'public/css/style.css',
    [],
    time()
  );
 

  // js
  wp_register_script(
    'cab-frontend-script',
    CAB_PLUGIN_URL . 'public/js/script.js',
    ['jquery'],
    time()
  );
 

  wp_enqueue_style('cab-frontend-style');
  wp_enqueue_script('cab-frontend-script');
}
// Enqueue Slick Carousel Scripts and Styles
function cab_enqueue_slick_carousel_assets() {
    // Enqueue Slick Carousel CSS
    wp_enqueue_style('slick-carousel-css', 'https://cdn.jsdelivr.net/npm/slick-carousel@1.8.1/slick/slick.css');
    wp_enqueue_style('slick-carousel-theme-css', 'https://cdn.jsdelivr.net/npm/slick-carousel@1.8.1/slick/slick-theme.css');

    // Enqueue Slick Carousel JS
    wp_enqueue_script('slick-carousel-js', 'https://cdn.jsdelivr.net/npm/slick-carousel@1.8.1/slick/slick.min.js', array('jquery'), '1.8.1', true);

    // Custom script to initialize the carousel
    wp_add_inline_script('slick-carousel-js', '
        jQuery(document).ready(function($) {
            $(".cab-related-products").slick({
                slidesToShow: 5,
                slidesToScroll: 2,
                autoplay: false,
                autoplaySpeed: 3000,
                arrows: true,
                dots: true,
                responsive: [
                    {
                        breakpoint: 1024,
                        settings: {
                            slidesToShow: 3,
                            slidesToScroll: 1
                        }
                    },
                    {
                        breakpoint: 768,
                        settings: {
                            slidesToShow: 2,
                            slidesToScroll: 1
                        }
                    },
                    {
                        breakpoint: 480,
                        settings: {
                            slidesToShow: 1,
                            slidesToScroll: 1
                        }
                    }
                ]
            });
        });
    ');
}

