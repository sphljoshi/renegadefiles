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
//Retreive the agnts based on the agent types and industries
print_r($agent_types);
print_r($industries);
//Check if there are any agents

if(!$agent_types || !$industries) {
    echo '<div class="agent-tabs no-agents">No Agents Found</div>';
    return;
}
?>


<!-- HTML for the agents tabbed display -->
<ul class="nav nav-tabs" id="myTab" role="tablist">
    <?php foreach($agent_types as $agent_type) : ?>
        <li class="nav-item" role="presentation">
            <button class="nav-link" id="<?php echo $agent_type->slug; ?>-tab" data-bs-toggle="tab" data-bs-target="#<?php echo $agent_type->slug; ?>" type="button" role="tab" aria-controls="<?php echo $agent_type->slug; ?>" aria-selected="false"><?php echo $agent_type->name; ?></button>
        </li>
    <?php endforeach; ?>
</ul>
<div class="tab-content" id="nav-tabContent">
  <div class="tab-pane fade show active" id="nav-home" role="tabpanel" aria-labelledby="nav-home-tab">
        <ul class="nav nav-pills">
            <?php foreach($industries as $industry) : ?>
                <li class="nav-item" role="presentation">
                    <button class="nav-link" id="<?php echo $industry->slug; ?>-tab" data-bs-toggle="tab" data-bs-target="#<?php echo $industry->slug; ?>" type="button" role="tab" aria-controls="<?php echo $industry->slug; ?>" aria-selected="false"><?php echo $industry->name; ?></button>
                </li>
            <?php endforeach; ?>
        </ul>
        <div class="tab-content"></div>
  </div>
</div>



