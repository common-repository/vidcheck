<?php
//echo "update page";
function vid_rating_update(){
    wp_enqueue_media();
    $i=sanitize_key($_GET['id']);;
    global $wpdb;
    $table_name = $wpdb->prefix . 'vidcheck_ratings';
    $ratings = $wpdb->get_results("SELECT id,name,slug,description,numericvalue,fe_image,color,bg_color from $table_name where id=$i");
    //  echo esc_attr($ratings[0]->numericvalue;
    ?>
<style>
    .vid_help_text{
    margin: 2px 0 5px;
    color: #646970;
    font-size: 13px !important;
}
</style>
<div class="wrap">
    <h1>Edit VidCheck Ratings</h1>
    
    <table class="form-table" role="presentation">
     
        <tbody>
        <form name="upd" action="#" method="post">
        <?php wp_nonce_field(plugin_basename(__FILE__), 'vidcheck_rating_edit_nonce'); ?>

            <input type="hidden" name="id" value="<?php echo esc_attr($ratings[0]->id); ?>">

            <tr class="form-field form-required term-name-wrap">
			<th scope="row"><label for="name">Rating Name</label></th>
            <td><input type="text" id="ratname" name="name" value="<?php echo esc_attr($ratings[0]->name); ?>">
                
                    <p class="vid_help_text">The Name of the Rating like TRUE, FALSE etc.</p>
                    </td>

           
            <tr class="form-field form-required term-name-wrap">
            <th scope="row"> <label for="tag-name">Numeric Value</label></th>
            <td><input name="numeric" id="numeric" type="number" aria-required="true"  value="<?php echo esc_attr($ratings[0]->numericvalue); ?>" required>
                <p class="vid_help_text">The Numeric Value you wish to assign to the rating, something like TRUE could be given a rating of 5 and False 1.</p></td>
            </tr>
            <tr class="form-field term-description-wrap">
            <th scope="row"> <label for="tag-description">Description</label></th>
            <td> <textarea name="description" id="tag-description" rows="5" cols="40"> <?php echo esc_attr($ratings[0]->description); ?></textarea required>
                <p class="vid_help_text">Description of the rating like the cases when you would assign that rating.</p></td>
            </tr>
            <tr class="form-field form-required term-name-wrap">
            <th scope="row">  <label for="tag-name">Text Color</label></th>
            <td> <input name="color" id="color" type="color" aria-required="true" required value="<?php echo esc_attr($ratings[0]->color); ?>">
                <p class="vid_help_text">The color of the text to be used with the rating.</p></td>
            </tr>
            <tr>
            <tr class="form-field form-required term-name-wrap">
            <th scope="row">  <label for="tag-name">Background Color</label></th>
            <td> <input name="bg_color" id="bg_color" type="color" aria-required="true" required value="<?php echo esc_attr($ratings[0]->bg_color); ?>">
                <p class="vid_help_text">The color to be displayed when the rating is used or displayed.</p></td>
            </tr>
            <tr>
       <th scope="row">  <label for="tag-image">Featured Image</label></th>
       <td>  <input name="fe_image" id="fe_image" type="hidden" aria-required="true" required value="<?php echo esc_attr($ratings[0]->fe_image); ?>">
           <input name="txtImage" class="form-control" id="btnImage" type="button" aria-required="true" value="Upload Image"><br><br>
                   <?php if(esc_attr($ratings[0]->fe_image) == '' || esc_attr($ratings[0]->fe_image) == NULL){ 
                       ?>

                      
                        <img src="<?php echo esc_url( plugins_url( 'no_rating.png', __FILE__ ) ); ?>" id="getImage" class="divhide"  style="width:100px; height:100px">
                        <?php
                   }
                   else{ 
                       ?>
                        

                       <img src="<?php echo esc_attr($ratings[0]->fe_image); ?>" id="getImage" class="divhide"  style="width:100px; height:100px">
                       <?php
                   } ?>        
                    <p>The image/icon you wish to use for the rating. </p>
                   <td></td>
       </tr>
           <tr> 
            
              <td>  <input type="submit" name="vid_rating_edit" id="submit" class="button button-primary" value="Update VidCheck Rating">	</td>	

            </p>
            </tr>

        </form>

        <?php

if (isset($_POST['vid_rating_edit']) ){
       
    if (!wp_verify_nonce($_POST['vidcheck_rating_edit_nonce'], plugin_basename(__FILE__))) {
        echo "Your Nonce Didn't Verify";
    }
    else{

     
            global $wpdb;
            $table_name=$wpdb->prefix.'vidcheck_ratings';
            $ratname = sanitize_text_field($_POST['name']);
            $slug = sanitize_title_with_dashes($_POST['name'], $protocols = null);
            $numeric = sanitize_text_field($_POST['numeric']);
            $description = sanitize_textarea_field($_POST['description']);
            $color=sanitize_hex_color($_POST['color']);
            $bg_color=sanitize_hex_color($_POST['bg_color']);
            $fe_image= sanitize_text_field($_POST['fe_image']);

            $id=sanitize_key($_POST['id']);
            $wpdb->update(
                $table_name,
                array(
                    'name' => $ratname,
                    'slug' => $slug,
                    'description' => $description,
                    'numericvalue'=>$numeric,
                    'fe_image' => $fe_image,
                    'color'=>$color,
                    'bg_color'=>$bg_color
                ),
                array(
                    'id'=>$id
                )
            );
            // $url=admin_url('admin.php?page=rating_list');
            // header("location:$url");
            $redirect = get_site_url() .'/wp-admin/admin.php?page=rating_list';
            wp_safe_redirect($redirect);
            exit;
        }
    }
    ?>
       
        </tbody>
    </table>
</div>
<script>

    jQuery('#btnImage').on('click',function(){
        var images = wp.media({
        title: 'Upload Claimant Image',
        multiple:false,
        }).open().on('select',function(e){
            var uploadedImages = images.state().get("selection").first();
            var selectedImages = uploadedImages.toJSON();
            console.log(selectedImages.url)
            jQuery('#getImage').removeClass('divhide'); 
            jQuery('#fe_image').val(selectedImages.url);
           jQuery('#getImage').attr('src',selectedImages.url); 



        // jQuery.each(selectedImages,function(index,image){
        //     console.log(image.url);
        // });


        })
    })
    </script>
    <?php
   
}


?>