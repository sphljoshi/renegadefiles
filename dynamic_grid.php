<?php

if (get_row_layout() == 'dynamic_grid') :
    $dynamic_grid_contents = get_sub_field('dynamic_grid_contents');
    $dynamic_grid_columns = get_sub_field('dynamic_grid_columns');
    $section_title_size = get_sub_field('dynamic_grid_section_title_size');
?>
    <section class="dynamic-grid-section" style="background-color: <?php echo get_sub_field('section_bg_color'); ?>">
        <div class="container">
            <?php if (!empty(get_sub_field('dynamic_grid_section_title'))) { ?>
                <<?php echo ($section_title_size); ?> class="mb-5"><?php echo get_sub_field('dynamic_grid_section_title'); ?></<?php echo ($section_title_size); ?>>
                    <?php } ?>

                    <?php if (!empty(get_sub_field('dynamic_grid_section_content'))) { ?>
                        <?php echo get_sub_field('dynamic_grid_section_content'); ?>
                    <?php } ?>
                <div class="row">
                    
                        <?php foreach ($dynamic_grid_contents as $value) {
                            $col_size = 12 / $dynamic_grid_columns;
                            $dynamic_grid_item_image = $value['dynamic_grid_item_image'];
                            $dynamic_grid_item_title = $value['dynamic_grid_item_title'];
                            $dynamic_grid_item_title_size = $value['dynamic_grid_item_title_size'];
                            $dynamic_grid_item_content = $value['dynamic_grid_item_content'];
                            $dynamic_grid_item_link = $value['dynamic_grid_item_link'];
                            if ($dynamic_grid_item_link) :
                                $dynamic_grid_item_link_url = $dynamic_grid_item_link['url'];
                                $dynamic_grid_item_link_title = $dynamic_grid_item_link['title'];
                                $dynamic_grid_item_link_target = $dynamic_grid_item_link['target'] ? $dynamic_grid_item_link['target'] : '_self';
                            endif;
                            if (empty($dynamic_grid_item_title) && empty($dynamic_grid_item_content) && empty($dynamic_grid_item_link_url)) {
                            } else {
                        ?>
                                <div class="col-md-<?php echo $col_size; ?> text-center mt-sm-4">
                                    <div class="col-content card-muted h-100">
                                        <?php if (!empty($dynamic_grid_item_image['url'])) { ?>
                                            <div class="col-content-image mb-3">
                                                <img src="<?php echo $dynamic_grid_item_image['url'];?>" alt="<?php echo $dynamic_grid_item_image['alt'];?>" style="width: 100px; height: auto">
                                            </div>
                                        <?php } ?>
                                        <?php if (!empty($dynamic_grid_item_title)) { ?>
                                            <div class="col-content-title">
                                                <<?php echo $dynamic_grid_item_title_size; ?>><?php echo $dynamic_grid_item_title; ?></<?php echo $dynamic_grid_item_title_size; ?>>
                                            </div>
                                        <?php } ?>
                                        <div class="col-content-content mb-3">
                                            <?php if (!empty($dynamic_grid_item_content)) { ?>
                                                <?php echo $dynamic_grid_item_content; ?>
                                            <?php } ?>
                                        </div>
                                        <?php if (!empty($dynamic_grid_item_link_url)) { ?>
                                            <div class="btn primary-btn">
                                                <a href="<?php echo esc_url($dynamic_grid_item_link_url); ?>" target="<?php echo esc_attr($dynamic_grid_item_link_target); ?>">
                                                        <span><?php echo $dynamic_grid_item_link_title; ?></span>
                                                </a>
                                            </div>
                                        <?php } ?>
                                    </div>
                                </div><!-- col -->
                        <?php }
                        } ?>
                    </div><!-- row -->
        </div><!-- container -->
        </div>
    </section>

<?php
endif; ?>