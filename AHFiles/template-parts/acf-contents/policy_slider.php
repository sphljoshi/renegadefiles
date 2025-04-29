<?php
if (get_row_layout() == 'policy_slider') :
  $section_heading = get_sub_field('section_heading_for_panel');
  $policy_listing = get_sub_field('policy_listing'); ?>
  <section class="section-muted section-padding">
    <div class="container">
      <?php
      if ($section_heading != '') { ?>
        <div class="common-secondary-head mb-5">
          <h4>
            <?php echo $section_heading; ?>
          </h4>
        </div>
    </div>
    <div class="policy-slider-wrap">
    <?php
      }
      if ($policy_listing) { ?>

      <div class="policy-slider">
        <?php
        echo count($policy_listing);
        $max_repeatations = 4;
        $repeated_listing = array_slice($policy_listing, 0, $max_repeatations);
        //print_r($repeated_listing);
        for ($i = 0; $i < $max_repeatations; $i++) {
          foreach ($repeated_listing as $row) {
            if ($row['policy_icon'] && $row['policy_icon'] != '') {
              $url = ($row['policy_link']['url']) ? $row['policy_link']['url'] : 'javascript:void(0)'; ?>
              <div class="panel-item">
                <a href="<?php echo $url; ?>" aria-label="<?php echo $row['policy_icon']['alt']; ?>">
                  <img class="d-inline-block" src="<?php echo $row['policy_icon']['url']; ?>" alt="<?php echo $row['policy_icon']['alt']; ?>">
                  <div><?php echo $row['policy_title']; ?></div>
                </a>
              </div>
        <?php
            }
          }
        }
        ?>
      </div><!-- policy-slider -->
    <?php
      } ?>
    </div>
    <?php print_r($repeated_listing);?><!-- policy-slider-wrap -->
  </section><!-- policy-slider -->
<?php
endif; ?>