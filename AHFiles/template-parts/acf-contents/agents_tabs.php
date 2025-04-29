<?php
if (get_row_layout() == 'agents_tabs') :
  $shortcode = get_sub_field('shortcode');
  $section_heading = get_sub_field('section_heading');
?>
    <section class="agenctsTabs-section section-padding" id="agenctsTabs">
      <div class="container">
      <?php if (!empty($section_heading)) {?>
          <div class="common-secondary-head mb-5">
            <h4 class="text-primary"><?php echo $section_heading;?></h4>
          </div>
      <?php }?>
      <?php if (!empty($shortcode)){
          echo do_shortcode($shortcode);
      }
            ?>
      </div>
    </section>
<?php
endif; ?>