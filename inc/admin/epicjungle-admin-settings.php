<?php

if(!defined('ABSPATH')){
	exit;
}

?>
<div class="wrap epicjungle-theme-settings">
	<h1><?php echo __( 'Configurações do tema EpicJungle', 'epicjungle' ); ?></h1>

	<form action="admin.php?page=epicjungle-settings" method="post">

					
        <div id="epicjungle-woocommerce-settings">
            <div class=" mb-3">
                <input class="toggle-switch" type="checkbox" id="ej_display_sale_badge" checked="yes">
                <label class="toggle-switch-label" for="ej_display_sale_badge">Toggle this switch element</label>
            </div>
        </div>

	<?php submit_button(); ?>
	</form>
</div>