<?php
if (get_row_layout() == 'carrier_slider_fluid_container_bg_selector') :
    $section_heading = get_sub_field('carr_section_heading');
    $carrier_listing = get_sub_field('carrier_listing_var2');
    $section_bg = get_sub_field('carr_section_background');
    $container_fluid = get_sub_field('container_width');
    $container_class = $container_fluid ? '' : 'container';

?>
    <section class="section-padding v2" style="background: <?php echo $section_bg; ?>;">
        <div class="<?php echo esc_attr($container_class) ?>">
            <?php
            if ($section_heading != '') { ?>
                <p class="muted-text mb-5 lead text-center">
                    <?php echo $section_heading; ?>
                </p><?php   
                }
                if ($carrier_listing) { ?>
                <div class="agency-logo-wrap">
                    <div class="item-animate">
                        <div class="item__item-wrap">
                            <div class="item__item-in">
                                <?php
                                $max_repeatations = 5;
                                $repeated_listing = array_slice($carrier_listing, 0, $max_repeatations);
                                //print_r($repeated_listing);
                                for ($i=0; $i<$max_repeatations; $i++){
                                foreach ($repeated_listing as $row) {
                                    if ($row['carrier_logo_v2'] && $row['carrier_logo_v2'] != '') {
                                        $url = ($row['carrier_link_v2']) ? $row['carrier_link_v2'] : 'javascript:void(0)'; ?>
                                        <span> <a href="<?php echo $url; ?>" aria-label="<?php echo $row['carrier_logo_v2']['alt']; ?>">
                                                <img src="<?php echo $row['carrier_logo_v2']['url']; ?>" alt="<?php echo $row['carrier_logo_v2']['alt']; ?>">
                                            </a></span>
                                <?php
                                    }
                                }
                             } ?>
                            </div>
                        </div>
                    </div>
                </div><!-- agency-logo-wrap -->
            <?php
                } ?>
        </div><!-- container -->
    </section><!-- agency-logo-slider -->
<?php
endif; ?>