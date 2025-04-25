<?php
if (get_row_layout() == 'policy_slider') :
  $section_heading = get_sub_field('section_heading');
  $policy_listing = get_sub_field('policy_listing'); ?>
  <section class="agency-logo-slider">
    <div class="container">
      <?php
      if ($section_heading != '') { ?>
        <h2>
          <?php echo $section_heading; ?>
        </h2><?php
            }
            if ($carrier_listing) { ?>
        <div class="agency-logo-wrap">
          <?php
              foreach ($carrier_listing as $row) {
                if ($row['carrier_logo'] && $row['carrier_logo'] != '') {
                  $url = ($row['carrier_link']) ? $row['carrier_link'] : 'javascript:void(0)'; ?>
              <a href="<?php echo $url; ?>" aria-label="<?php echo $row['carrier_logo']['alt']; ?>">
                <img src="<?php echo $row['carrier_logo']['url']; ?>" alt="<?php echo $row['carrier_logo']['alt']; ?>">
              </a><?php
                }
              } ?>
        </div><!-- agency-logo-wrap -->
      <?php
            } ?>
    </div><!-- container -->
  </section><!-- agency-logo-slider -->
<?php
endif; ?>