<?php
function vid_claimant_delete(){
   
    
        if ( isset( $_GET['action'] )
            && isset( $_GET['nonce'] )
            && 'Claimant_Delete' === $_GET['action']
            && wp_verify_nonce( $_GET['nonce'], 'Claimant_Delete' ) ) {
    
                $i=sanitize_key($_GET['claimnt_id']);
                if($_GET['claimnt_id'] ){
                    global $wpdb;
                    $table_name=$wpdb->prefix.'vidcheck_claimant';
                
                    $wpdb->delete(
                        $table_name,
                        array('id'=>$i)
                    );
                }
    
            // Redirect to admin page.
            $redirect = get_site_url() .'/wp-admin/admin.php?page=Claimant_List';
             wp_safe_redirect($redirect);
             exit;
           

        }
    
}

add_action('init', 'vid_claimant_delete');
?>