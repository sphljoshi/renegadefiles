<?php

// SHORTCODE to display Agent Tabs with Type and Industry filters
add_shortcode('agent_tabs', function() {
    ob_start();

    // Get the 'type' terms
    $types = get_terms([
        'taxonomy' => 'type',
        'hide_empty' => true,
        'order' => 'ASC'
    ]);
	$section_heading = get_sub_field('section_heading');
    if (!empty($types) && !is_wp_error($types)) :
    ?>
		
        <div class="agent-tabs">
        <div class="d-flex justify-content-between mb-5">
        <!-- Section Heading -->
        <?php if (!empty($section_heading)) {?>
          <div class="common-secondary-head">
            <h4 class="text-primary"><?php echo $section_heading;?></h4>
          </div>
        <?php }?>
            <!-- Type Tabs -->
            <div>
            <ul class="agent-type-tab-buttons">
                <?php foreach ($types as $index => $type) : ?>
                    <li class="<?php echo $index === 0 ? 'active' : ''; ?>">
                        <a href="#" data-type="<?php echo esc_attr($type->slug); ?>">
                            <?php echo esc_html($type->name); ?>
                        </a>
                    </li>
                <?php endforeach; ?>
            </ul>
        </div>
        </div>
            <!-- Industry Tabs (dynamic) -->
            <div class="d-flex" style="gap:16px">
                <ul class="agent-industry-tab-buttons mb-0"></ul><!-- Will Load via JS-->
                <ul style="padding: 0; margin:0; list-style: none; align-self: center"><li><a href="https://agents.agencyheight.com" target="blank" class="btn-tab btn-tab-more">More</a></li></ul>
            </div>
            <!-- Content area -->
            <div id="agent-tab-content" class="mt-5">
                <p><div class="spinner"></div></p> <!-- Will load via JS -->
            </div>
        </div>
            <script>
                document.addEventListener('DOMContentLoaded', function() {
                const typeTabs = document.querySelectorAll('.agent-type-tab-buttons a');
                const industryTabsContainer = document.querySelector('.agent-industry-tab-buttons');
                const contentArea = document.getElementById('agent-tab-content');

                let selectedType = '';
                let selectedIndustry = '';

                function loadIndustries(typeSlug) {
                    industryTabsContainer.innerHTML = '<li></li>';
                    fetch('<?php echo admin_url('admin-ajax.php'); ?>?action=load_industries_by_type&type=' + typeSlug)
                        .then(response => response.json())
                        .then(data => {
                            if (data.length > 0) {
                                let html = '';
                                data.forEach(function(industry) {
                                    html += '<li><a href="#" class="btn-tab" data-industry="'+industry.slug+'">'+industry.name+'</a></li>';
                                });
                                //html += '<a href="https://agents.agencyheight.com" class="btn-tab btn-tab-more">More</a>'
                                industryTabsContainer.innerHTML = html;

                                // Attach click event to new industry tabs
                                attachIndustryClickHandlers();
                            } else {
                                industryTabsContainer.innerHTML = '<li>No industries found.</li>';
                            }
                        });
                }

                function loadAgents(typeSlug, industrySlug) {
                    contentArea.innerHTML = '<div class="spinner"></div>';
                    fetch('<?php echo admin_url('admin-ajax.php'); ?>?action=load_agents_by_type_and_industry&type=' + typeSlug + '&industry=' + industrySlug)
                        .then(response => response.text())
                        .then(data => {
                            contentArea.innerHTML = data;
                        });
                }

                function attachIndustryClickHandlers() {
                    const industryTabs = document.querySelectorAll('.agent-industry-tab-buttons a');

                    industryTabs.forEach(tab => {
                        tab.addEventListener('click', function(e) {
                            e.preventDefault();

                            // Remove active from all
                            industryTabs.forEach(t => t.parentElement.classList.remove('active'));

                            // Active current
                            this.parentElement.classList.add('active');

                            selectedIndustry = this.dataset.industry;
                            loadAgents(selectedType, selectedIndustry);
                        });
                    });

                    // Auto-click first industry if available
                    if (industryTabs.length > 0) {
                        industryTabs[0].click();
                    }
                }

                // Default: load first Type
                if (typeTabs.length > 0) {
                    selectedType = typeTabs[0].dataset.type;
                    loadIndustries(selectedType);
                }

                typeTabs.forEach(tab => {
                    tab.addEventListener('click', function(e) {
                        e.preventDefault();

                        // Remove active class
                        typeTabs.forEach(t => t.parentElement.classList.remove('active'));
                        this.parentElement.classList.add('active');

                        selectedType = this.dataset.type;
                        selectedIndustry = '';
                        loadIndustries(selectedType);
                        contentArea.innerHTML = '<div class="spinner"></div>';
                    });
                });
            });
            </script>
    <?php
    else :
        echo '<p>No types found.</p>';
    endif;

    return ob_get_clean();
});
