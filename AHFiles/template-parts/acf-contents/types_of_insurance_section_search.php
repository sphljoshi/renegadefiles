<?php
if (get_row_layout() == 'types_of_insurance_section_search') :
	$heading = get_sub_field('section_title');
	$iframe_content = get_sub_field('iframe_content');
    ?>
	<section class="gradient-bg">
		<div class="container">
			<div class="row">
				<div class="col-md-12">
					<?php if(!empty($heading)){ ?>
						<h2 class=""><?php echo $heading; ?></h2>
					<?php } ?>
				<?php
                    if($iframe_content){
                    ?>
                    <div class="iframe-home"><?php echo $iframe_content; ?></div>
                    <?php
                    }?>
				</div>
			</div>
		</div>
		<!-- container -->
	</section>
<?php
endif; ?>