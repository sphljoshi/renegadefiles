<?php
$producers_section_title = (get_sub_field('producers_section_title')) ? get_sub_field('producers_section_title') : get_field('producers_section_title', 'options');
$producer_choose_background_color = (get_sub_field('producer_choose_background_color')) ? get_sub_field('producer_choose_background_color') : get_field('producer_choose_background_color', 'options');
$bg_class = ($producer_choose_background_color == 'sky-blue') ? 'sky-blue' : '';
?>
<section class="producer-wrap employee-wrap <?php echo $bg_class; ?>">

    <div class="container">

        <div class="employee-header text-center">
            <?php if ($producers_section_title) { ?>
                <h2><?php echo $producers_section_title; ?></h2>
            <?php } ?>
        </div><!-- employee-header -->

    </div>
    <?php if (have_rows('producers_content')) : ?>

        <div class="container-left none">
            <div class="employee-slider producer">
                <?php while (have_rows('producers_content')) :
                    the_row();
                    $producer_image = get_sub_field('producer_image');
                    $producer_name = get_sub_field('producer_name');
                    $producer_address = get_sub_field('producer_address');
                    $producer_phone_number = get_sub_field('producer_phone_number');
                    $producer_email = get_sub_field('producer_email');
                ?>
                    <div class="item">
                        <div class="employee-flex justify-content-center">
                            <?php if ($producer_image) {
                                $alt = ($producer_image['alt']) ? $producer_image['alt'] : "agent-image"; ?>
                                <div class="producer-img">
                                <img src="<?php echo $producer_image['url']; ?>" alt="<?php echo $alt; ?>">
                                </div>
                            <?php }  ?>
                            <!-- employee-meta -->
                        </div>
                        <div class="employee-meta producer-meta mb-4">
                                <?php if ($producer_name) { ?>
                                    <h3 class="text-center text-white"><?php echo $producer_name; ?></h3>
                                <?php }
                                if ($producer_address) { ?>
                                    <p class="flex-location justify-content-center">
                                        <img src="<?php echo get_template_directory_uri(); ?>/images/location-icon.png" alt="location-icon">
                                        <?php echo $producer_address; ?></p>
                                <?php } ?>
                            </div><!-- employee-flex -->
                            <?php if ($producer_phone_number) { ?>
                            <p class="text-center my-2"><?php echo $producer_phone_number; ?></p>
                        <?php } ?>
                        <?php if ($producer_email) { ?>
                            <p class="text-center my-0"><?php echo $producer_email; ?></p>
                        <?php } ?>
                    </div><!-- item -->
                <?php endwhile; ?>

            </div><!-- employee-slider -->
        </div><!-- container-left -->

    <?php else :  ?>

        <?php if (have_rows('producers_content', 'options')) : ?>

            <div class="container-left">
                <div class="employee-slider producer">
                    <?php while (have_rows('producers_content', 'options')) :
                        the_row();
                        $producer_image = get_sub_field('producer_image', 'options');
                        $producer_name = get_sub_field('producer_name', 'options');
                        $producer_address = get_sub_field('producer_address', 'options');
                        $producer_phone_number = get_sub_field('producer_phone_number', 'options');
                        $producer_email = get_sub_field('producer_email', 'options');
                    ?>
                        <div class="item">
                            <div class="employee-flex justify-content-center">
                                <?php if ($producer_image) {
                                    $alt = ($producer_image['alt']) ? $producer_image['alt'] : "agent-image"; ?>
                                    <div class="producer-img">
                                        <img src="<?php echo $producer_image['url']; ?>" alt="<?php echo $alt; ?>">
                                    </div>
                                <?php }  ?>
                                <!-- employee-meta -->
                            </div>
                            <div class="employee-meta producer-meta mb-4">
                                    <?php if ($producer_name) { ?>
                                        <h3 class="text-center text-white"><?php echo $producer_name; ?></h3>
                                    <?php }
                                    if ($producer_address) { ?>
                                        <p class="flex-location justify-content-center">
                                            <img src="<?php echo get_stylesheet_directory_uri(); ?>/images/location-icon.png" alt="location-icon">
                                            <?php echo $producer_address; ?></p>
                                    <?php } ?>
                                </div><!-- employee-flex -->
                            <?php if ($producer_phone_number) { ?>
                            <p class="text-center my-2"><?php echo $producer_phone_number; ?></p>
                        <?php } ?>
                        <?php if ($producer_email) { ?>
                            <p class="text-center my-0"><?php echo $producer_email; ?></p>
                        <?php } ?>
                        </div><!-- item -->
                    <?php endwhile; ?>

                </div><!-- employee-slider -->
            </div><!-- container-left -->
        <?php endif; ?>
    <?php endif; ?>
</section>