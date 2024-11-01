<?php
function vid_get_the_vid_permalink( $post = null ) {
	$post = get_post( $post );
	$link = get_permalink( $post );

	return apply_filters( 'the_vidcheck_permalink', $link, $post );
}

function vidchecks(){
    $addnew = get_site_url() .'/wp-admin/admin.php?page=add-new-vidcheck';
?>
<div class="wrap">
   <h1 class="wp-heading-inline">
      Vid Checks
   </h1>
   <a href="<?php echo esc_attr($addnew) ?>" class="page-title-action">Add New</a>
   <hr class="wp-header-end">
   <p  style="    text-align: center; font-size:15px;">For Full vidchek Page Short Code id <b>[all-vidchecks]</b></p>
   <form id="posts-filter" method="get">
      
 
      <input type="hidden" id="_wpnonce" name="_wpnonce" value="55b47868e3"><input type="hidden" name="_wp_http_referer" value="/wordpress/wp-admin/edit.php">	
      <br><br>
      <h2 class="screen-reader-text">Vid Checks list</h2>
      <table class="wp-list-table widefat fixed striped table-view-list posts">
         <thead>
            <tr>
               <th scope="col" style="width: 20%;" >Video Title</th>
               <th scope="col" style="width: 20%;">Video Source</th>
               <th scope="col" style="width: 20%;">Short Code</th>
               <th scope="col" style="width: 20%;">No of Claims</th>
               <th scope="col" style="width: 20%;">Date</th>
            </tr>
         </thead>
         <tbody id="the-list">
         <?php
            global $wpdb;
            $vidcheck_videos = $wpdb->prefix . 'vidcheck_video';
            $vidcheck_claim = $wpdb->prefix . 'vidcheck_claim';


            $vidchecks = $wpdb->get_results("SELECT * from $vidcheck_videos");

            foreach ($vidchecks as $videos) {
                ?>
                <tr id="post-1" class="iedit author-self level-0 post-1 type-post status-publish format-standard hentry category-uncategorized entry">
                    
                    <td  style="width: 40%;" data-colname="Title">
                        <strong><a href="#"><?php echo esc_attr($videos->title) ?></a></strong>
                      
                        <div class="row-actions"><span class="edit">
                        <a href="<?php echo esc_url(admin_url('admin.php?page=edit_new_claim&video_id=' . $videos->id)); ?>" aria-label="Edit “Hello world!”">Edit</a> | </span>
                        
                        <?php
                        $url = add_query_arg(
                                    [
                                        'page'=>'Vidcheck_Delete',
                                        'action' => 'Vidcheck_Delete',
                                        'id'   => $videos->id,
                                        'nonce'  => wp_create_nonce( 'Vidcheck_Delete' ),
                                    ], admin_url()
                                );

                        ?>
                         <span class="trash"><a href="<?php echo esc_url(wp_nonce_url( $url )); ?>" class="submitdelete" >Trash</a> | </span>
                         
                        

                           <?php
                                    global $wpdb;
                                    $vidcheck_posts = $wpdb->prefix . 'posts';
                                    $vidcheck_post_single = $wpdb->get_results("SELECT *
                                    FROM $vidcheck_posts
                                    WHERE $vidcheck_posts.id = $videos->post_id;");
        
         
                            ?>


                        <a href="<?php echo esc_url(site_url('vid_check/'.$vidcheck_post_single[0]->post_name)); ?>" aria-label="Edit “Hello world!”">View</a> | </span>
                    </td>
                    <td><a href="<?php echo esc_attr($videos->url) ?>"><?php echo esc_attr($videos->url) ?></a></td>

                    <td><a href="<?php echo esc_attr($videos->url) ?>">[single-vidchecks id=<?php echo esc_attr($videos->id) ?>]</a></td>
                  
                    <td class="comments column-comments" data-colname="Comments">
                            <?php
                                    global $wpdb;
                                    $vidcheck_claim = $wpdb->prefix . 'vidcheck_claim';
                                    $count = $wpdb->get_results("SELECT *
                                    FROM $vidcheck_claim
                                    WHERE $vidcheck_claim.video_id = $videos->id;");

                            ?>



                        <div class="post-com-count-wrapper">
                            <a href="#" class="post-com-count post-com-count-approved"><span class="comment-count-approved" aria-hidden="true"><?php echo esc_attr(sizeof($count)) ?></span></a><span class="post-com-count post-com-count-pending post-com-count-no-pending"><span class="comment-count comment-count-no-pending" aria-hidden="true">0</span><span class="screen-reader-text">No pending comments</span></span>		
                        </div>
                    </td>
                    <td class="date column-date" data-colname="Date">Published<br><?php echo esc_attr($videos->created_at) ?></td>
                </tr>
            <?php } ?>
         </tbody>
         <tfoot>
            <tr>
            <th scope="col" style="width: 20%;" >Video Title</th>
               <th scope="col" >Video</th>
               <th scope="col" >Short Code</th>

               <th scope="col" >No of Claims</th>
               <th scope="col" >Date</th>
            </tr>
         </tfoot>
      </table>
      
   </form>
 
 
</div>

<?php
}



?>
