<?php
/*Template Name: Home Page AH Reimagined */
get_header();
//Including Related Flexible Contents
if (have_rows('add_site_layouts')) :
    while (have_rows('add_site_layouts')) : the_row();
        get_template_part('template-parts/acf-contents/' . get_row_layout());
    endwhile;
else :
    get_template_part('template-parts/content', 'page');
endif;
get_footer();
