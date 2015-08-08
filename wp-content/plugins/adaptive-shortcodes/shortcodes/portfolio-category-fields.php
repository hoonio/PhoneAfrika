<?php

/**
 * Add logic for icon support on Portfolio Category
 */


function adap_sc_tax_select_field($field, $t_id = null)
{
	$meta = $t_id !== null ? get_option("taxonomy_$t_id") : null;
	$meta = is_array($meta) && isset($meta[$field['id']]) ? $meta[$field['id']] : null;

	$field['id'] = 'term_meta[' . $field['id'] . ']';

	echo '<div class="form-field">';

	echo '<select name="', $field['id'], '" id="', $field['id'], '">';
	foreach ($field['options'] as $name => $value) {
		echo '<option value="', $value, '"', $meta == $value ? ' selected="selected"' : '', '>', $name, '</option>';
	}
	echo '</select>';
	echo '<p class="cmb_metabox_description description">', $field['desc'], '</p>';

	echo '</div>';
}

// Add term page
function adap_sc_add_portfolio_cat_custom_fields()
{
	global $icon_listing;
	global $entypo_listing;
	global $icon_type_listing;

	// this will add the custom meta field to the add new term page
	?>

	<?php

	adap_sc_tax_select_field(array(
		'id' => 'icon_type',
		'options' => array_merge($icon_type_listing, array('None' => 'none')),
		'desc' => 'The Icon set to draw the portfolio category\'s icon from'
	));

	adap_sc_tax_select_field(array(
		'id' => 'entypo_icon',
		'options' => $entypo_listing,
		'desc' => 'The icon to use if using the Entypo Icon Set'
	));
	adap_sc_tax_select_field(array(
		'id' => 'fontawesome_icon',
		'options' => $icon_listing,
		'desc' => 'The icon to use if using the FontAwesome Icon Set'
	));
}

add_action('portfolio_category_add_form_fields', 'adap_sc_add_portfolio_cat_custom_fields', 10, 2);

// Edit term page
function adap_sc_edit_portfolio_cat_custom_fields($term)
{
	global $icon_listing;
	global $entypo_listing;
	global $icon_type_listing;

	// put the term ID into a variable
	$t_id = $term->slug;

	// retrieve the existing value(s) for this meta field. This returns an array
	$term_meta = get_option("taxonomy_$t_id"); ?>

	<tr class="form-field">
		<?php

		adap_sc_tax_select_field(array(
			'id' => 'icon_type',
			'options' => array_merge($icon_type_listing, array('None' => 'none')),
			'desc' => 'The Icon set to draw the portfolio category\'s icon from'
		), $t_id);

		adap_sc_tax_select_field(array(
			'id' => 'entypo_icon',
			'options' => $entypo_listing,
			'desc' => 'The icon to use if using the Entypo Icon Set'
		), $t_id);
		adap_sc_tax_select_field(array(
			'id' => 'fontawesome_icon',
			'options' => $icon_listing,
			'desc' => 'The icon to use if using the FontAwesome Icon Set'
		), $t_id);
		?>
	</tr>
<?php
}

add_action('portfolio_category_edit_form_fields', 'adap_sc_edit_portfolio_cat_custom_fields', 10, 2);

// Save extra taxonomy fields callback function.
function adap_sc_save_portfolio_cat_custom_meta($term_id)
{
	if (isset($_POST['term_meta'])) {
		$term = get_term($term_id, 'portfolio_category');
		$t_id = $term->slug;
		$term_meta = get_option("taxonomy_$t_id");
		$cat_keys = array_keys($_POST['term_meta']);
		foreach ($cat_keys as $key) {
			if (isset ($_POST['term_meta'][$key])) {
				$term_meta[$key] = $_POST['term_meta'][$key];
			}
		}
		// Save the option array.
		update_option("taxonomy_$t_id", $term_meta);
	}
}

add_action('edited_portfolio_category', 'adap_sc_save_portfolio_cat_custom_meta', 10, 2);
add_action('create_portfolio_category', 'adap_sc_save_portfolio_cat_custom_meta', 10, 2);

function adap_sc_get_portfolio_cat_option($key, $t_id)
{
	$meta = $t_id !== null ? get_option("taxonomy_$t_id") : null;
	return is_array($meta) && isset($meta[$key]) ? $meta[$key] : null;
}