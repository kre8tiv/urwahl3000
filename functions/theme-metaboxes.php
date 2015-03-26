<?php
	

add_action( 'add_meta_boxes', 'kr8mb_add' );
function kr8mb_add()
{
    add_meta_box( 'kr8mb_pers_contact', 'Kontaktdaten', 'kr8mb_pers_contact_cb', 'person', 'normal', 'high' );
     add_meta_box( 'kr8mb_pers_position', 'Infos & Ämter', 'kr8mb_pers_position_cb', 'person', 'normal', 'high' );
}
	

/** PERSONEN: Kontaktdaten **/

function kr8mb_pers_contact_cb($post)
{
    // $post is already set, and contains an object: the WordPress post
    global $post;
    $values = get_post_custom( $post->ID );
    $www = isset( $values['kr8mb_pers_contact_www'] ) ? esc_attr( $values['kr8mb_pers_contact_www'][0] ) : '';
    $email = isset( $values['kr8mb_pers_contact_email'] ) ? esc_attr( $values['kr8mb_pers_contact_email'][0] ) : '';
	$facebook = isset( $values['kr8mb_pers_contact_facebook'] ) ? esc_attr( $values['kr8mb_pers_contact_facebook'][0] ) : '';
	$twitter = isset( $values['kr8mb_pers_contact_twitter'] ) ? esc_attr( $values['kr8mb_pers_contact_twitter'][0] ) : '';
	$anschrift = isset( $values['kr8mb_pers_contact_anschrift'] ) ? esc_html( $values['kr8mb_pers_contact_anschrift'][0] ) : '';
	$selected = isset( $values['my_meta_box_select'] ) ? esc_attr( $values['my_meta_box_select'][0] ) : '';
	$check = isset( $values['my_meta_box_check'] ) ? esc_attr( $values['my_meta_box_check'][0] ) : '';

    
     
    // We'll use this nonce field later on when saving.
    wp_nonce_field( 'my_meta_box_nonce', 'meta_box_nonce' );
    ?>
    <table class="form-table"><tbody>
    <tr>
	    <th scope="row"><label for="kr8mb_pers_contact_www">Website</label></th>
        <td><input type="text" name="kr8mb_pers_contact_www" id="kr8mb_pers_contact_www" value="<?php echo $www; ?>" /><br><span class="description">Inklusive http:// Beispiel: http://domain.de.</span></td>

	    <th scope="row"><label for="kr8mb_pers_contact_email">E-Mail</label></th>
        <td><input type="text" name="kr8mb_pers_contact_email" id="kr8mb_pers_contact_email" value="<?php echo $email; ?>" /><br><span class="description">vorname.nachname@domain.de</span></td>
    </tr>
    <tr>
	    <th scope="row"><label for="kr8mb_pers_contact_facebook">Facebook</label></th>
        <td><input type="text" name="kr8mb_pers_contact_facebook" id="kr8mb_pers_contact_facebook" value="<?php echo $facebook; ?>" /><br><span class="description">Vollständiger Link zum Facebook-Profil, inkl. http://</span></td>
	    <th scope="row"><label for="kr8mb_pers_contact_twitter">Twitter</label></th>
        <td><input type="text" name="kr8mb_pers_contact_twitter" id="kr8mb_pers_contact_twitter" value="<?php echo $twitter; ?>" /><br><span class="description">Nur der Twitter-Nutzername ohne @, z.b. gruenenrw.</span></td>
    </tr>    
    <tr>
	    <th scope="row"><label for="kr8mb_pers_contact_anschrift">Anschrift</label></th>
        <td><textarea name="kr8mb_pers_contact_anschrift" id="kr8mb_pers_contact_anschrift"><?php echo $anschrift; ?></textarea><br><span class="description">Platz für Anschrift, Telefon, Fax, etc.</span></td>
    </tr>
     
    </tbody></table>
    <?php    
}




add_action( 'save_post', 'kr8mb_pers_contact_save' );
function kr8mb_pers_contact_save( $post_id )
{
    // Bail if we're doing an auto save
    if( defined( 'DOING_AUTOSAVE' ) && DOING_AUTOSAVE ) return;
     
    // if our nonce isn't there, or we can't verify it, bail
    if( !isset( $_POST['meta_box_nonce'] ) || !wp_verify_nonce( $_POST['meta_box_nonce'], 'my_meta_box_nonce' ) ) return;
     
    // if our current user can't edit this post, bail
    if( !current_user_can( 'edit_post', $post_id ) ) return;
     
    // now we can actually save the data
    $allowed = array( 
        'a' => array( // on allow a tags
            'href' => array() // and those anchors can only have href attribute
        )
    );
     
    // Make sure your data is set before trying to save it
	if( isset( $_POST['kr8mb_pers_contact_www'] ) )
        update_post_meta( $post_id, 'kr8mb_pers_contact_www', wp_kses( $_POST['kr8mb_pers_contact_www'], $allowed ) );
	if( isset( $_POST['kr8mb_pers_contact_email'] ) )
        update_post_meta( $post_id, 'kr8mb_pers_contact_email', wp_kses( $_POST['kr8mb_pers_contact_email'], $allowed ) );
	if( isset( $_POST['kr8mb_pers_contact_facebook'] ) )
        update_post_meta( $post_id, 'kr8mb_pers_contact_facebook', wp_kses( $_POST['kr8mb_pers_contact_facebook'], $allowed ) );
    if( isset( $_POST['kr8mb_pers_contact_twitter'] ) )
        update_post_meta( $post_id, 'kr8mb_pers_contact_twitter', wp_kses( $_POST['kr8mb_pers_contact_twitter'], $allowed ) ); 
    if( isset( $_POST['kr8mb_pers_contact_anschrift'] ) )
        update_post_meta( $post_id, 'kr8mb_pers_contact_anschrift', esc_html( $_POST['kr8mb_pers_contact_anschrift'] ) );   
        
                 
}




/** PERSONEN: Positionen **/

function kr8mb_pers_position_cb($post)
{
    // $post is already set, and contains an object: the WordPress post
    global $post;
    $values = get_post_custom( $post->ID );
    $excerpt = isset( $values['kr8mb_pers_excerpt'] ) ? esc_html( $values['kr8mb_pers_excerpt'][0] ) : '';
    $amt = isset( $values['kr8mb_pers_pos_amt'] ) ? esc_attr( $values['kr8mb_pers_pos_amt'][0] ) : '';
    $listenplatz = isset( $values['kr8mb_pers_pos_listenplatz'] ) ? esc_attr( $values['kr8mb_pers_pos_listenplatz'][0] ) : '';

    
     
    // We'll use this nonce field later on when saving.
    wp_nonce_field( 'my_meta_box_nonce', 'meta_box_nonce' );
    ?>
    <table class="form-table"><tbody>
    <tr>
	    <th scope="row"><label for="kr8mb_pers_excerpt">Kurzbeschreibung</label></th>
        <td><textarea name="kr8mb_pers_excerpt" id="kr8mb_pers_excerpt"><?php echo $excerpt; ?></textarea><br><span class="description">Am besten zwei - drei kurze Sätze.</span></td>
    </tr>
    <tr>
	    <th scope="row"><label for="kr8mb_pers_pos_amt">Amt/Mandat</label></th>
        <td><input type="text" name="kr8mb_pers_pos_amt" id="kr8mb_pers_pos_amt" value="<?php echo $amt; ?>" /><br><span class="description">Nur der Twitter-Nutzername ohne @</span></td>

	    <th scope="row"><label for="kr8mb_pers_pos_listenplatz">Listenplatz</label></th>
        <td><input type="text" name="kr8mb_pers_pos_listenplatz" id="kr8mb_pers_pos_listenplatz" value="<?php echo $listenplatz; ?>" /><br><span class="description">Nur der Twitter-Nutzername ohne @</span></td>
    </tr>
    </tbody></table>
    <?php    
}




add_action( 'save_post', 'kr8mb_pers_position_save' );
function kr8mb_pers_position_save( $post_id )
{
    // Bail if we're doing an auto save
    if( defined( 'DOING_AUTOSAVE' ) && DOING_AUTOSAVE ) return;
     
    // if our nonce isn't there, or we can't verify it, bail
    if( !isset( $_POST['meta_box_nonce'] ) || !wp_verify_nonce( $_POST['meta_box_nonce'], 'my_meta_box_nonce' ) ) return;
     
    // if our current user can't edit this post, bail
    if( !current_user_can( 'edit_post', $post_id ) ) return;
     
    // now we can actually save the data
    $allowed = array( 
        'a' => array( // on allow a tags
            'href' => array() // and those anchors can only have href attribute
        )
    );
     
    // Make sure your data is set before trying to save it
	if( isset( $_POST['kr8mb_pers_excerpt'] ) )
        update_post_meta( $post_id, 'kr8mb_pers_excerpt', esc_html( $_POST['kr8mb_pers_excerpt'] ) );   

	if( isset( $_POST['kr8mb_pers_pos_amt'] ) )
        update_post_meta( $post_id, 'kr8mb_pers_pos_amt', wp_kses( $_POST['kr8mb_pers_pos_amt'], $allowed ) );
	if( isset( $_POST['kr8mb_pers_pos_listenplatz'] ) )
        update_post_meta( $post_id, 'kr8mb_pers_pos_listenplatz', wp_kses( $_POST['kr8mb_pers_pos_listenplatz'], $allowed ) );

}