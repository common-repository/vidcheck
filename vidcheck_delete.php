<?php

function vid_check_delete(){
   
        if ( isset( $_GET['action'] )
            && isset( $_GET['nonce'] )
            && 'Vidcheck_Delete' === $_GET['action']
            && wp_verify_nonce( $_GET['nonce'], 'Vidcheck_Delete' ) ) {
    
                global $wpdb;
                $table_name=$wpdb->prefix.'vidcheck_video';
                $table_posts=$wpdb->prefix.'posts';


                $i=sanitize_key($_GET['id']);


                $video = $wpdb->get_results("SELECT * from $table_name where id=$i");
                $post_id = (int)$video[0]->post_id;

                $wpdb->delete(
                    $table_name,
                    array('id'=>$i)
                );

                $wpdb->delete(
                    $table_posts,
                    array('id'=>$post_id)
                );

            // Redirect to admin page.
            $redirect = get_site_url() .'/wp-admin/admin.php?page=vidchecks-list';

             wp_safe_redirect($redirect);
             exit;

        }
}

add_action('init', 'vid_check_delete');
?>