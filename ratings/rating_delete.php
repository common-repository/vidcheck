<?php
function vid_rating_delete(){
   
        if ( isset( $_GET['action'] )
            && isset( $_GET['nonce'] )
            && 'Rating_Delete' === $_GET['action']
            && wp_verify_nonce( $_GET['nonce'], 'Rating_Delete' ) ) {
    
                $i=sanitize_key($_GET['rating_id']);
                if($_GET['rating_id'] ){
                    global $wpdb;
                    $table_name=$wpdb->prefix.'vidcheck_ratings';
                
                    $wpdb->delete(
                        $table_name,
                        array('id'=>$i)
                    );
                }
    
            // Redirect to admin page.
            $redirect = get_site_url() .'/wp-admin/admin.php?page=rating_list';
             wp_safe_redirect($redirect);
             exit;
           

        }
    
}

add_action('init', 'vid_rating_delete');
?>