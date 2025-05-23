<?php
//Main Logic to display the agents in a tabbed format

$agent_types = get_terms([
    'taxonomy' => 'agent_type',
    'hide_empty' => false,
    'orderby' => 'name',
    'order' => 'ASC',
]);

$industries = get_terms([
    'taxonomy' => 'agent_industry',
    'hide_empty' => false,
    'orderby' => 'name',
    'order' => 'ASC',
]);
//Check if there are any agents

if(!$agent_types || !$industries) {
    echo '<div class="agent-tabs no-agents">No Agents Found</div>';
    return;
}
?>

<!-- Retreive the agent_types and industries -->
<ul>
<?php foreach($agent_types as $agent_type) : ?>
        <li class="" role="presentation">
            <?php echo esc_html($agent_type->name); ?>
        </li>
    <?php endforeach; ?>
</ul>

<ul>
    <?php foreach($industries as $industry) : ?>
        <li class="" role="presentation">
            <?php echo esc_html($industry->name); ?>
        </li>
    <?php endforeach; ?>
</ul>

<!-- Display the agents in a tabbed format -->
 
<ul class="nav nav-tabs" id="myTab" role="tablist">
    <?php foreach($agent_types as $agent_type) : ?>
        <li class="nav-item" role="presentation">
            <button class="nav-link" id="<?php echo $agent_type->slug; ?>-tab" data-bs-toggle="tab" data-bs-target="#<?php echo $agent_type->slug; ?>" type="button" role="tab" aria-controls="<?php echo $agent_type->slug; ?>" aria-selected="false"><?php echo $agent_type->name; ?></button>
        </li>
    <?php endforeach; ?>
</ul>
<div class="tab-content" id="myTabContent">
  <div class="tab-pane fade " id="" role="tabpanel">
        <ul class="nav nav-pills">
            <?php foreach($industries as $industry) : ?>
                <li class="nav-item" role="presentation">
                    <button class="nav-link" id="<?php echo $industry->slug; ?>-tab" data-bs-toggle="tab" data-bs-target="#<?php echo $industry->slug; ?>" type="button" role="tab" aria-controls="<?php echo $industry->slug; ?>" aria-selected="false"><?php echo $industry->name; ?></button>
                </li>
            <?php endforeach; ?>
        </ul>
        <div class="tab-content">
            <?php foreach($industries as $industry) : ?>
                <div class="tab-pane fade">
                <?php
                    $agentsList = new WP_Query([
                        'post_type' => 'agent',
                        'orderby' => 'rand',
                        'posts_per_page' => 6,
                        'tax_query' => [
                            'relation' => 'AND',
                            [
                                'taxonomy' => 'agent_type',
                                'field' => 'slug',
                                'terms' => $agent_type->slug,
                            ],
                            [
                                'taxonomy' => 'agent_industry',
                                'field' => 'slug',
                                'terms' => $industry->slug, 
                            ],
                        ]
                    ]);

                    if($agentsList->have_posts()) {
                        echo '<ul class="agent-list">';
                        while($agentsList->have_posts()) {
                            $agentsList -> the_post();
                            echo '<li>';
                            echo '<a href="' . get_the_permalink() . '">';
                            echo '<h3>' . get_the_title() . '</h3>';
                            echo '</a>';
                            echo '</li>';
                        }
                        echo '</ul>';
                        wp_reset_postdata();
                    }else{
                        echo '<div class="agent-tabs no-agents">No Agents Found</div>';
                    }
                ?>
                </div>
            <?php endforeach; ?>
        </div>
  </div>
</div>



