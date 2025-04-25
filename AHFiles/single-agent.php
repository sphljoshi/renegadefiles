<?php

/**
 * The template for displaying all single agent posts
 *
 * @link https://developer.wordpress.org/themes/basics/template-hierarchy/#single-post
 * 
 *
 * 
 * @package agencyheight
 */

get_header();
$agent_link = get_field('agent_link');

?>
<section class="agent-single-page" style="background-color: #FAFAFA; padding: 50px 0;">
    <div class="agent-wrapper">
        <div class="container">
            <div class="row">
                <div class="col-md-8">
                    <h2><?php the_title(); ?></h2>
                    <?php echo esc_html($agent_link); ?>
                </div>
                <div class="col-md-4">
                    <div class="agent-image">
                        <?php the_post_thumbnail('full', array('class' => 'img-fluid')); ?>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

<?php
get_footer();?>