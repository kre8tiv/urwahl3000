<?php
	
function kr8_image_copyright_fields_to_edit($form_fields, $post) {
	$form_fields['copyright']['label'] = __('Copyright');
	$form_fields['copyright']['helps'] = __('Wird auf Start- und Übersichtsseiten angezeigt. Auf Einzeldarstellungen kann für den gleichen Zweck die obige "Beschriftung" benutzt werden.');
	$form_fields['copyright']['input'] = 'textarea';
	$form_fields['copyright']['value'] = get_post_meta($post->ID, '_copyright', true);
     
    return $form_fields;
}
add_filter('attachment_fields_to_edit', 'kr8_image_copyright_fields_to_edit', null, 2);

function kr8_image_copyright_fields_to_save($post, $attachment) {
	if( isset($attachment['copyright']) ){
		update_post_meta($post['ID'], '_copyright', $attachment['copyright']);
	}
	return $post;
}
add_filter('attachment_fields_to_save', 'kr8_image_copyright_fields_to_save', null, 2);