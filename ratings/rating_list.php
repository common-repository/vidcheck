<?php

function vid_rating_list() {
    wp_enqueue_media();
    ?>
    <style type="text/css">
.divhide{
    display: none;
}
.vid_help_text{
    margin: 2px 0 5px;
    color: #646970;
    font-size: 13px !important;

}
</style>

    <div class="wrap">
    <div id="wpbody" role="main">

<div id="wpbody-content">

		
<div class="wrap nosubsub">
<h1 class="wp-heading-inline">VidCheck Ratings</h1>

<br><br>
<hr class="wp-header-end">

<div id="ajax-response"></div>


<div id="col-container" class="wp-clearfix">

<div id="col-left">
<div class="col-wrap">

	
<div class="form-wrap">
<h2>Add VidCheck Ratings</h2>

<form name="frm" action="#" method="post">
<?php wp_nonce_field(plugin_basename(__FILE__), 'vidcheck_rating_delete_nonce'); ?>

<div class="form-field form-required term-name-wrap">
	<label for="tag-name">Rating Name</label>
	<input name="ratname" id="ratname" type="text" aria-required="true" required>
	<p class="vid_help_text">The Name of the Rating like TRUE, FALSE etc.</p>
</div>
<!--
<div class="form-field form-required term-name-wrap">
	<label for="tag-name">URL</label>
	<input name="slug" id="slug" type="text" aria-required="true">
</div> -->
<div class="form-field form-required term-name-wrap">
	<label for="tag-name">Numeric Value</label>
	<input name="numeric" id="numeric" type="number" aria-required="true" required>
	<p class="vid_help_text">The Numeric Value you wish to assign to the rating, something like TRUE could be given a rating of 5 and False 1.</p>
</div>
<div class="form-field term-description-wrap">
	<label for="tag-description">Description</label>
	<textarea name="description" id="tag-description" rows="5" cols="40"></textarea required>
	<p class="vid_help_text">Description of the rating like the cases when you would assign that rating.</p>
</div>
<div class="form-field form-required term-name-wrap">
	<label for="tag-name">Text Color</label>
	<input name="color" id="color" type="color" aria-required="true" required>
	<p class="vid_help_text">The color of the text to be used with the rating.</p>
</div>
<div class="form-field form-required term-name-wrap">
	<label for="tag-name">Backgroud Color</label>
	<input name="bg_color" id="bg_color" type="color" aria-required="true" required>
	<p class="vid_help_text">The color to be displayed when the rating is used or displayed.</p>
</div>
<div class="form-field term-description-wrap">
	<label for="tag-image">Featured Image</label>
	<input name="fe_image" id="fe_image" type="hidden" aria-required="true" required val="">
	<input name="txtImage" class="form-control" id="btnImage" type="button" aria-required="true" value="Upload Image">
    <img src="" id="getImage" class="divhide" style="width:100px; height:100px">
    <p class="vid_help_text">The image/icon you wish to use for the rating. </p>
</div>
    <p class="submit">
		<input type="submit" name="vid_rating_add" id="submit" class="button button-primary" value="Add New VidCheck Rating">		<span class="spinner"></span>
	</p>

    </form>
    <?php
    if (isset($_POST['vid_rating_add']) ){
        if (!wp_verify_nonce($_POST['vidcheck_rating_delete_nonce'], plugin_basename(__FILE__))) {
            echo "Your Nonce Didn't Verify";
        }
        else{

            global $wpdb;
            $ratname = sanitize_text_field($_POST['ratname']);
            $slug = sanitize_title_with_dashes($_POST['ratname'], $protocols = null);
            $numeric = sanitize_text_field($_POST['numeric']);
            $description = sanitize_textarea_field($_POST['description']);
            $color=sanitize_hex_color($_POST['color']);
            $bg_color=sanitize_hex_color($_POST['bg_color']);

            if($_POST['fe_image'] == null){
                $fe_image=  '';
                
            }
            else{
                $fe_image=sanitize_text_field($_POST['fe_image']);
            }

            $fe_image= sanitize_text_field($fe_image);
    
            $table_name = $wpdb->prefix . 'vidcheck_ratings';

            $wpdb->insert(
                $table_name,
                array(
                    'name' => $ratname,
                    'slug' => $slug,
                    'description' => $description,
                    'numericvalue'=>$numeric,
                    'fe_image' => $fe_image,
                    'color'=>$color,
                    'bg_color'=>$bg_color
                )
            );
            $url = get_site_url() .'/wp-admin/admin.php?page=rating_list';

            ?>
            <meta http-equiv="refresh" content="0; url=<?php echo esc_url($url) ?>" />
            <?php
            exit;
        }
    }

?>
    </div>
</div>
</div><!-- /col-left -->

<div id="col-right">
<div class="col-wrap">
<h2>VidCheck Ratings List</h2>
<br>
	<table class="wp-list-table widefat fixed striped table-view-list tags">
	<thead>
	<tr>
        <th width="10%"><a> ID </a></th>
        <th  width="20%"><a> Rating Name </a></th>
        <th><a> URL </a></th>
        <th><a> Numeric Value </a></th>
        <th> <a>Image</a> </th>
        <th><a> Color Schema </a></th>

	</tr>
    	</thead>

	<tbody id="the-list" data-wp-lists="list:tag">
    <?php
            global $wpdb;
            $table_name = $wpdb->prefix . 'vidcheck_ratings';
            $ratings = $wpdb->get_results("SELECT id,name,slug,description,numericvalue,fe_image,color,bg_color from $table_name");
            foreach ($ratings as $rating) {
                ?>
                <tr>
                    <td><?php echo esc_attr($rating->id); ?></td>
                    <td>
                        <strong><a class="row-title" href="#" aria-label="“Hello world!” (Edit)"><?php echo esc_attr($rating->name); ?></a></strong>
                      
                        <div class="row-actions"><span class="edit">
                        <a href="<?php echo esc_url(admin_url('admin.php?page=Rating_Update&id=' . esc_attr($rating->id))); ?>" aria-label="Edit “Hello world!”">Edit</a> | </span>
                       
                        <?php
                        $url = add_query_arg(
                                    [
                                        'page'=>'Rating_Delete',
                                        'action' => 'Rating_Delete',
                                        'rating_id'   => $rating->id,
                                        'nonce'  => wp_create_nonce( 'Rating_Delete' ),
                                    ], admin_url()
                                );

                        ?>

<span class="trash"><a href="<?php echo esc_url(wp_nonce_url( $url )); ?>" class="submitdelete" >Trash</a> | </span>

                         <span class="view"><a href="<?php echo esc_url(admin_url('admin.php?page=Rating_View&id=' . esc_attr($rating->id))); ?>" rel="bookmark">View</a></span></div>
                    </td>
                    <td><?php echo esc_attr($rating->slug); ?></td>
                    <td><?php echo esc_attr($rating->numericvalue); ?></td>
                    <td>
                    <?php if(esc_attr($rating->fe_image) == ''){ 
                        ?>
                        
                        <img src="<?php echo esc_url( plugins_url( 'no_rating.png',__FILE__) ); ?>" style="width:50px; height:50px">
                        <?php
                    }
                    else{ 
                        ?>
                        
                <img src="<?php echo esc_attr($rating->fe_image); ?>" style="width:50px; height:50px">
                        <?php
                    } ?>
                   </td>
                    <td> <span style="color:<?php echo esc_attr($rating->color); ?>; background-color:<?php echo esc_attr($rating->bg_color); ?>; padding: 5px; border-radius: 3px;">Text</span> 
                    </td>
                   
                </tr>
            <?php } ?>
	<tfoot>
	
    <th> ID </th>
        <th><a> Name</a> </th>
        <th> <a>URL</a> </th>
        <th> <a>Numeric Value</a> </th>
        <th> <a>Image</a> </th>
        <th> <a>Color</a> </th>

	</tfoot>

</table>
			
</form>
<script>
 

jQuery(function(){

    jQuery('#btnImage').on('click',function(){
        var images = wp.media({
        title: 'Upload Rating Image',
        multiple:false,
        }).open().on('select',function(e){
            var uploadedImages = images.state().get("selection").first();
            var selectedImages = uploadedImages.toJSON();
            console.log(selectedImages.url)
            jQuery('#getImage').removeClass('divhide'); 
            jQuery('#fe_image').val(selectedImages.url);
           jQuery('#getImage').attr('src',selectedImages.url); 

        })
    })

    
});

</script>

</div>
</div><!-- /col-right -->

</div><!-- /col-container -->

</div><!-- /wrap -->

</div><!-- wpbody-content -->

    <?php

}
add_shortcode('short_rating_list', 'rating_list');
?>
