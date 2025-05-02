<?php
$heading = (get_field('display_heading', get_the_ID()));
$sub_heading = (get_field('sub_heading', get_the_ID()));
$cta_banner_type = get_field('cta_banner_type', get_the_ID());
?>

<section class="signup-section section-padding" id="agency-signup-api">
    <div class="container">
        <div class="text-white section-padding text-center px-5" style="background-color: #6878c4; border-radius: 20px;">
            <div class="mx-auto" style="max-width: 860px">
                <h3 class="mb-4">
                    <?php
                    echo $heading;
                    //print_r($cta_banner_type);
                    ?>
                </h3>
                <p class="mb-4"><?php echo $sub_heading; ?></p>
                <div class="location-search agent-registration-form" id="agent-registration-form">
                    <?php
                     get_template_part('template-parts/forms/agent-registration-form-template'); ?>
                </div>
            </div>
        </div>
    </div>
</section>