<?php
function ninja_forms_register_field_honeypot(){
	$args = array(
		'name' => __( 'Honey Pot', 'ninja-forms' ),
		'sidebar' => 'template_fields',
		'edit_function' => '',
		'display_function' => 'ninja_forms_field_honeypot_display',
		'save_function' => '',
		'group' => 'standard_fields',
		'default_label' => __( 'If you are a human and are seeing this field, please leave it blank.', 'ninja-forms' ),
		'edit_label' => false,
		'edit_desc' => false,
		'edit_label_pos' => false,
		'default_label_pos' => 'above',
		'default_value' => '',
		'edit_req' => false,
		'edit_custom_class' => false,
		'edit_help' => false,
		'edit_meta' => false,
		'edit_conditional' => false,
		'display_label' => true,
		'process_field' => false,
		'pre_process' => 'ninja_forms_field_honeypot_pre_process'
	);

	ninja_forms_register_field('_honeypot', $args);
}

add_action('init', 'ninja_forms_register_field_honeypot');



function ninja_forms_field_honeypot_display($field_id, $data){

	$field_class = ninja_forms_get_field_class($field_id);	?>

	<input id="ninja_forms_field_<?php echo $field_id;?>" name="ninja_forms_field_<?php echo $field_id;?>" type="text" class="<?php echo $field_class;?>" value="" rel="<?php echo $field_id;?>" />
	<?php

}

function ninja_forms_field_honeypot_pre_process( $field_id, $user_value ){
	global $ninja_forms_processing;

	$plugin_settings = get_option( 'ninja_forms_settings' );
	if(isset($plugin_settings['honeypot_error'])){
		$honeypot_error = $plugin_settings['honeypot_error'];
	}

	if( $ninja_forms_processing->get_action() != 'save' AND $ninja_forms_processing->get_action() != 'mp_save' AND !isset($_POST['_wp_login']) AND $user_value != '' ){
		if( is_object( $ninja_forms_processing)){
			if( $user_value != '' ){
				$ninja_forms_processing->add_error('honeypot-'.$field_id, $honeypot_error, $field_id);
			}
		}
	}
}