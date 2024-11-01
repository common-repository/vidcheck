<?php
function vid_claimant_list()
{

    wp_enqueue_media();
?>
<style type="text/css">
    .divhide {
        display: none;
    }

    .vid_help_text {
        margin: 2px 0 5px;
        color: #646970;
        font-size: 13px !important;
    }
</style>
<div class="wrap">
    <div id="wpbody" role="main">

        <div id="wpbody-content">


            <div class="wrap nosubsub">
                <h1 class="wp-heading-inline">VidCheck Claimants</h1>

                <br><br>
                <hr class="wp-header-end">

                <div id="ajax-response"></div>


                <div id="col-container" class="wp-clearfix">

                    <div id="col-left">
                        <div class="col-wrap">


                            <div class="form-wrap">
                                <h2>Add VidCheck Claimant</h2>

                                <form name="frm" action="#" method="post">
                                    <?php wp_nonce_field(plugin_basename(__FILE__) , 'vidcheck_claim_delete_nonce'); ?>

                                    <div class="form-field form-required term-name-wrap">
                                        <label for="tag-name">Claimant</label>
                                        <input name="ratname" id="ratname" type="text" aria-required="true" required>
                                        <p class="vid_help_text">The person or platform where the claim is made such as
                                            the name of a politician or a social media platform etc.</p>
                                    </div>

                                    <div class="form-field form-required term-name-wrap">
                                        <label for="tag-name">TagLine </label>
                                        <input name="tagline" id="tagline" type="text" aria-required="true" required>
                                        <p class="vid_help_text">The tagline for the claimant such as Designations
                                            (Prime Minister, President). You can also leave it empty.</p>
                                    </div>

                                    <div class="form-field term-description-wrap">
                                        <label for="tag-description">Description</label>
                                        <textarea name="description" id="tag-description" rows="5" cols="40"></textarea required>
	<p class="vid_help_text">The description of the claimant with additional details.</p>
</div>
<div class="form-field term-description-wrap">
	<label for="tag-image">Featured Image</label>
	<input name="imageName" id="imageName" type="hidden" aria-required="true" required val="">
	<input name="txtImage" class="form-control" id="btnImage" type="button" aria-required="true" value="Upload Image">
    <img src="" id="getImage" class="divhide" style="width:100px; height:100px">
    <p class="vid_help_text">The image to be used for the claimant</p>
</div>
    <p class="submit">
		<input type="submit" name="vid_claim_add" id="submit" class="button button-primary" value="Add New VidCheck Claimant">		
	</p>


    </form>
    <?php
    if (isset($_POST['vid_claim_add']))
    {
        if (!wp_verify_nonce($_POST['vidcheck_claim_delete_nonce'], plugin_basename(__FILE__)))
        {
            echo "Your Nonce Didn't Verify";
        }
        else
        {
            global $wpdb;

            $ratname = sanitize_text_field($_POST['ratname']);
            $slug = sanitize_title_with_dashes($_POST['ratname'], $protocols = null);
            $tagline = sanitize_text_field($_POST['tagline']);
            $description = sanitize_text_field($_POST['description']);

            if ($_POST['imageName'] == null)
            {
                
                $imageName = '';
            }
            else
            {
                $imageName = sanitize_textarea_field($_POST['imageName']);
            }
            $imageName = sanitize_textarea_field($imageName);

            $table_name = $wpdb->prefix . 'vidcheck_claimant';

            $wpdb->insert($table_name, array(
                'name' => $ratname,
                'slug' => $slug,
                'description' => $description,
                'imageName' => $imageName,
                'tagline' => $tagline,
            ));

        }
    }

?>
    </div>
</div>
</div><!-- /col-left -->

<div id="col-right">
<div class="col-wrap">
<h2>VidCheck Claimant List</h2>

<br>
	<table class="wp-list-table widefat fixed striped table-view-list tags">
	<thead>
	<tr>
        <th width="5%"><a> ID </a></th>
        <th width="50%"><a> Claimant </a></th>
        <th><a> Slug </a></th>
        <th><a> Featured Image </a></th>
        <th><a> Tag Line </a></th>

	</tr>
    	</thead>

	<tbody id="the-list" data-wp-lists="list:tag">
    <?php
    global $wpdb;
    $table_name = $wpdb->prefix . 'vidcheck_claimant';
    $claimants = $wpdb->get_results("SELECT id,name,slug,description,tagline,imageName from $table_name");
    foreach ($claimants as $claimant)
    {
?>
                <tr>
                    <td width="5%"><?php echo esc_attr($claimant->id); ?></td>
                    <td >
                        <strong><a class="row-title" href="#" aria-label="“Hello world!” (Edit)"><?php echo esc_attr($claimant->name); ?></a></strong>
                      
                        <div class="row-actions"><span class="edit">
                        <a href="<?php echo esc_url(admin_url('admin.php?page=Claimant_Update&id=' . esc_attr($claimant->id))); ?>" aria-label="Edit “Hello world!”">Edit</a> | </span>
                        <?php
        $url = add_query_arg(['page' => 'Claimant_Delete', 'action' => 'Claimant_Delete', 'claimnt_id' => $claimant->id, 'nonce' => wp_create_nonce('Claimant_Delete') , ], admin_url());

?>
                         <span class="trash"><a href="<?php echo esc_url(wp_nonce_url($url)); ?>" class="submitdelete" >Trash</a> | </span>
                         <!-- <span class="trash"><a href="<?php echo esc_url(admin_url('admin.php?page=Claimant_Delete&id=' . esc_attr($claimant->id))); ?>" class="submitdelete" >Trash</a> | </span> -->
                         <span class="view"><a href="<?php echo esc_url(admin_url('admin.php?page=Claimant_View&id=' . esc_attr($claimant->id))); ?>" rel="bookmark">View</a></span></div>
                    </td>
                  
                    <td><?php echo esc_attr($claimant->slug); ?></td>
                    <td>
                    <?php if (esc_attr($claimant->imageName) == '')
        {
           ?>
                        <img src="<?php echo esc_url( plugins_url( '/no_claim.png', __FILE__ ) ); ?>" style="width:50px; height:50px">

           <?php
            
        }
        else
        {
?>
                <img src="<?php echo esc_attr($claimant->imageName); ?>" style="width:50px; height:50px">
                        <?php
        } ?>
                   </td>
                    <td><?php echo esc_attr($claimant->tagline); ?></td>
                   
                </tr>
            <?php
    } ?>
	<tfoot>
	
    <th> ID </th>
        <th><a> Name</a> </th>
        <th> <a>Slug</a> </th>
        <th> <a>Image</a> </th>
        <th> <a>Tag Line</a> </th>

	</tfoot>

</table>
			
</form>


</div>
</div><!-- /col-right -->

</div><!-- /col-container -->

</div><!-- /wrap -->

</div><!-- wpbody-content -->
<script>
 

jQuery(function(){

    
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

        })
    })

    
});

</script>
    <?php
}
add_shortcode('short_rating_list', 'rating_list');

?>
