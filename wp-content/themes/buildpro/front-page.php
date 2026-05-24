<?php

get_header();
?>

<main class="bp-landing" id="primary">
    <?php
    get_template_part('template-parts/sections/hero');
    get_template_part('template-parts/sections/features');
    get_template_part('template-parts/sections/projects');
    get_template_part('template-parts/sections/stages');
    get_template_part('template-parts/sections/cta');
    get_template_part('template-parts/sections/modal');
    ?>
</main>

<?php
get_footer();
