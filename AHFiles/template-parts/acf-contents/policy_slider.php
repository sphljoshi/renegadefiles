<?php
if (get_row_layout() == 'policy_slider') :
  $section_heading = get_sub_field('section_heading_for_panel');
  $policy_listing = get_sub_field('policy_listing'); ?>
  <section class="section-muted section-padding">
    <div class="container">
      <?php
      if ($section_heading != '') { ?>
      <div class="common-secondary-head">
        <h3>
          <?php echo $section_heading; ?>
        </h3>
        </div><?php
            }
            if ($policy_listing) { ?>
        <div class="agency-logo-wrap">
          <?php
              foreach ($policy_listing as $row) {
                if ($row['policy_icon'] && $row['policy_icon'] != '') {
                  $url = ($row['policy_link']['url']) ? $row['policy_link']['url'] : 'javascript:void(0)'; ?>
              <a href="<?php echo $url; ?>" aria-label="<?php echo $row['policy_icon']['alt']; ?>">
                <img src="<?php echo $row['policy_icon']['url']; ?>" alt="<?php echo $row['policy_icon']['alt']; ?>">
                <span><?php echo $row['policy_title']; ?></span>
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