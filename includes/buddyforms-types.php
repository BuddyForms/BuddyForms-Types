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

    $form->addElement(new Element_HTML( bf_form_ellement_accordion_start($selected_form_slug, __('WP Types','buddyforms')) ));

    $form->addElement(new Element_HTML('<p><a href="#" data-fieldtype="wp-types" class="bf_add_element_action">WP Types</a></p>'));


    $form->addElement(new Element_HTML( bf_form_ellement_accordion_end() ));

    return $form;
}
add_filter('buddyforms_admin_settings_sidebar_metabox','buddyforms_types_admin_settings_sidebar_metabox',1,2);

/*
 * Create the new Form Builder Form Element
 *
 */
function buddyforms_types_create_new_form_builder_form_element($form_fields, $form_slug, $field_type, $field_id){
    global $field_position;

    switch ($field_type) {

        case 'wp-types':
            //unset($form_fields);
            $boom = wpcf_admin_fields_get_fields_by_group(258);
            echo '<pre>';
            print_r($boom);
            echo '</pre>';
            $form_fields['general']['html']		= new Element_HTML('Hallo');
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
        case 'review-logic':

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