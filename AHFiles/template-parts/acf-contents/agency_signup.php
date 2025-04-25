<?php
if (get_row_layout() == 'agency_signup') :
  $agency_signup_background = get_sub_field('agency_signup_background');
  $agency_signup_title = get_sub_field('agency_signup_title');
  $agency_signup_title_size = get_sub_field('agency_signup_title_size');
  $agency_signup_iframe_content = get_sub_field('agency_signup_iframe_content');
?>
    <section class="signup-section section-padding" id="agency-signup">
      <div class="container">
        <div class="row">
          <div class="col-md-12">
            <div class="text-white section-padding text-center" style="background-color: <?php echo $agency_signup_background; ?>; border-radius: 20px;">
            <div class="mx-auto" style="max-width: 860px">
              <<?php echo $agency_signup_title_size; ?> class="mb-5 "><?php echo $agency_signup_title; ?></<?php echo $agency_signup_title_size; ?>>
              <?php echo $agency_signup_iframe_content; ?>
              </div>
            </div>
          </div>
        </div><!-- row -->
      </div><!-- container -->
    </section>
<?php
endif; ?>