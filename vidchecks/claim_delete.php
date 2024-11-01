<?php
function vid_claim_delete(){
   
        if ( isset( $_GET['action'] )
            && isset( $_GET['nonce'] )
            && 'claim_delete' === $_GET['action']
            && wp_verify_nonce( $_GET['nonce'], 'claim_delete' ) ) {
    
                $video_id=sanitize_key($_GET['video_id']);
                $video_id = (int)$video_id;

                $claim_id=sanitize_key($_GET['claimnt_id']);
                $claim_id = (int)$claim_id;

            
                global $wpdb;
                $table_name=$wpdb->prefix.'vidcheck_claim';
                $i=sanitize_key($claim_id);
                $wpdb->delete(
                    $table_name,
                    array('id'=>$i)
                );    
    
            // Redirect to admin page.
            $redirect = get_site_url() .'/wp-admin/admin.php?page=edit_new_claim&video_id='.$video_id;

             wp_safe_redirect($redirect);
             exit;
           

        }
      
    
}

add_action('init', 'vid_claim_delete');
?>