<?php
//echo "update page";
ob_start();
function vid_claimant_update(){
    wp_enqueue_media();

    //echo "update page in";
    $i=sanitize_key($_GET['id']);
    global $wpdb;
    $table_name = $wpdb->prefix . 'vidcheck_claimant';
    $ratings = $wpdb->get_results("SELECT id,name,slug,description,tagline,imageName from $table_name where id=$i");
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
    <h1>Edit VidCheck Claimant</h1>
    
    <table class="form-table" role="presentation">
     
    
        <tbody>
        <form name="upd" action="#" method="post">
        <?php wp_nonce_field(plugin_basename(__FILE__), 'vidcheck_claim_edit_nonce'); ?>

            <input type="hidden" name="id" value="<?php echo esc_attr($ratings[0]->id); ?>">

            <tr class="form-field form-required term-name-wrap">
			<th scope="row"><label for="name">Claimant</label></th>
            <td><input type="text" name="name" id="ratname" value="<?php echo esc_attr($ratings[0]->name); ?>">
                
                    <p class="vid_help_text">The person or platform where the claim is made such as the name of a politician or a social media platform etc.</p>
                    </td>

            <tr class="form-field form-required term-name-wrap">
            <th scope="row"> <label for="tag-name">URL</label></th>
            <td>  <input name="slug" id="slug" type="text" aria-required="true" value="<?php echo esc_attr($ratings[0]->slug); ?>">
            </tr>
            <tr class="form-field form-required term-name-wrap">
            <th scope="row"> <label for="tag-name">Tag Line</label></th>
            <td><input name="tagline" id="tagline" type="text" aria-required="true"  value="<?php echo esc_attr($ratings[0]->tagline); ?>" required>
                <p class="vid_help_text">The tagline for the claimant such as Designations (Prime Minister, President). You can also leave it empty</p></td>
            </tr>
            <tr class="form-field term-description-wrap">
            <th scope="row"> <label for="tag-description">Description</label></th>
            <td> <textarea name="description" id="tag-description" rows="5" cols="40"> <?php echo esc_attr($ratings[0]->description); ?></textarea required>
                <p class="vid_help_text">The description of the claimant with additional details.</p></td>
            </tr>
        <tr>
       
        <th scope="row">  <label for="tag-image">Featured Image</label></th>
        <td>  <input name="imageName" id="imageName" type="hidden" aria-required="true" required value="<?php echo esc_attr($ratings[0]->imageName); ?>">
            <input name="txtImage" class="form-control" id="btnImage" type="button" aria-required="true" value="Upload Image"><br><br>
            
                    <?php if(esc_attr($ratings[0]->imageName) == ''){ 
                         ?>
                         

                         <img src="<?php echo esc_url( plugins_url( '/no_claim.png', __FILE__ ) ); ?>" id="getImage" class="divhide"  style="width:100px; height:100px">
                         <?php

                    }
                    else{ 
                        ?>
                        <img src="<?php echo esc_attr($ratings[0]->imageName); ?>" id="getImage" class="divhide"  style="width:100px; height:100px">
                        <?php
                    } ?>        
            <p class="vid_help_text">The image to be used for the claimant</p>
                    <td></td>
        </tr>
           <tr> 
            
              <td>  <input type="submit" name="vid_claim_edit" id="submit" class="button button-primary" value="Update VidCheck Claimant">	</td>	

            </p>
            </tr>

        </form>

        <?php

if (isset($_POST['vid_claim_edit']) ){
       
    if (!wp_verify_nonce($_POST['vidcheck_claim_edit_nonce'], plugin_basename(__FILE__))) {
        echo "Your Nonce Didn't Verify";
    }
    else{
    global $wpdb;
    $table_name=$wpdb->prefix.'vidcheck_claimant';

        $ratname = sanitize_text_field($_POST['name']);
        $slug = sanitize_title_with_dashes($_POST['name'], $protocols = null);
        $tagline = sanitize_text_field($_POST['tagline']);
        $description = sanitize_textarea_field($_POST['description']);
        $imageName = sanitize_textarea_field($_POST['imageName']);


        $id=sanitize_key($_POST['id']);
        $wpdb->update(
            $table_name,
            array(
                'name' => $ratname,
                'slug' => $slug,
                'description' => $description,
                'tagline'=>$tagline,
                'imageName' => $imageName,
            ),
            array(
                'id'=>$id
            )
        );

            $redirect = get_site_url() .'/wp-admin/admin.php?page=Claimant_List';
             wp_safe_redirect($redirect);
             exit;
    }                   
}

        ?>
       
        </tbody>
    </table>
</div>
<script>

    jQuery("#ratname").change(function(){
        var slug = jQuery("#ratname").val();
        var f_slug = slug
        .toLowerCase()
        .replace(/ /g,'-')
        .replace(/[^\w-]+/g,'')
        ;
        jQuery('#slug').val(f_slug);

    });
    jQuery('#btnImage').on('click',function(){
        var images = wp.media({
        title: 'Upload Claimant Image',
        multiple:false,
        }).open().on('select',function(e){
            var uploadedImages = images.state().get("selection").first();
            var selectedImages = uploadedImages.toJSON();
            console.log(selectedImages.url)
            jQuery('#getImage').removeClass('divhide'); 
            jQuery('#imageName').val(selectedImages.url);
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