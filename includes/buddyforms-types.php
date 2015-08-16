<?php

/*
 * Add a new form element to the form create view sidebar
 *
 * @param object the form object
 * @param array selected form
 *
 * @return the form object
 */

function buddyforms_types_admin_settings_sidebar_metabox($form, $selected_form_slug){

    $form->addElement(new Element_HTML('
		<div class="accordion-group postbox">
			<div class="accordion-heading"><p class="accordion-toggle" data-toggle="collapse" data-parent="#accordion_'.$selected_form_slug.'" href="#accordion_'.$selected_form_slug.'_wp_types_options">WP Types</p></div>
		    <div id="accordion_'.$selected_form_slug.'_wp_types_options" class="accordion-body collapse">
				<div class="accordion-inner">'));

    $form->addElement(new Element_HTML('<p><a href="wp-types/'.$selected_form_slug.'" class="action">WP Types</a></p>'));


    $form->addElement(new Element_HTML('
				</div>
			</div>
		</div>'));

    return $form;
}
add_filter('buddyforms_admin_settings_sidebar_metabox','buddyforms_types_admin_settings_sidebar_metabox',1,2);

/*
 * Create the new Form Builder Form Element
 *
 */
function buddyforms_types_create_new_form_builder_form_element($form_fields, $form_slug, $field_type, $field_id){
    global $field_position;
    $buddyforms_options = get_option('buddyforms_options');

    switch ($field_type) {

        case 'wp-types':
            //unset($form_fields);
            $boom = wpcf_admin_fields_get_fields_by_group(258);
            echo '<pre>';
            print_r($boom);
            echo '</pre>';
            $form_fields['full']['html']		= new Element_HTML('Hallo');
            break;

    }

    return $form_fields;
}
add_filter('buddyforms_form_element_add_field','buddyforms_types_create_new_form_builder_form_element',1,5);

/*
 * Display the new Form Element in the Frontend Form
 *
 */
function buddyforms_types_create_frontend_form_element($form, $form_args){

    extract($form_args);

    if(!isset($customfield['type']))
        return $form;

    switch ($customfield['type']) {
        case 'Review-Logic':

            $post = get_post($post_id);

            if($post_id == 0 ){
                $form->addElement( new Element_Button( 'Save', 'submit', array('class' => 'bf-submit', 'name' => 'edit-draft')));
            } else {
                if($post->post_status == 'edit-draft'){
                    $form->addElement( new Element_Button( 'Save', 'submit', array('class' => 'bf-submit', 'name' => 'submitted')));
                    $form->addElement( new Element_Button( 'Submit for types', 'submit', array('class' => 'bf-submit', 'name' => 'awaiting-types')));
                } else {
                    $form->addElement( new Element_Button( 'Save new Draft', 'submit', array('class' => 'bf-submit', 'name' => 'edit-draft')));
                }
            }

            add_filter('buddyforms_create_edit_form_button', 'buddyforms_types_buddyforms_create_edit_form_button', 10, 1);

            break;
    }

    return $form;
}
add_filter('buddyforms_create_edit_form_display_element','buddyforms_types_create_frontend_form_element',1,2);