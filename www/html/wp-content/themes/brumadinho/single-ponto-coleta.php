<?php

get_header();
if (have_posts()): the_post();
?>
	<main role="main">
		um teste
	</main>
<?php 
endif;
get_footer();