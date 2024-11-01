<?php

function vid_claimant_view() {
    $i=sanitize_key($_GET['id']);
    global $wpdb;
    $table_name = $wpdb->prefix . 'vidcheck_claimant';
    $claimant = $wpdb->get_results("SELECT id,name,slug,description,tagline from $table_name where id=$i");
    
?>
<div class="wrap">
    <div id="wpbody" role="main">
        <div id="wpbody-content">
            <div class="wrap nosubsub">
                <h1 class="wp-heading-inline">Claimant Deatils of <?php echo esc_attr($claimant[0]->name) ?></h1>
                <table class="form-table" role="presentation">
                    <tbody>
                        <tr>
                            <th scope="row">Name</th>
                            <td>
                                <label for="rich_editing">
                                    <?php echo esc_attr($claimant[0]->name) ?>			
                                </label>
                            </td>
                        </tr>
                        <tr>
                            <th scope="row">URL</th>
                            <td>
                                <label for="rich_editing">
                                    <?php echo esc_attr($claimant[0]->slug) ?>			
                                </label>
                            </td>
                        </tr>
                      
                        <tr>
                            <th scope="row">Tag Line</th>
                            <td>
                                <label for="rich_editing">
                                
                                <?php echo esc_attr($claimant[0]->tagline) ?>			
                                </label>
                            </td>
                        </tr>
                        <tr>
                            <th scope="row">Description</th>
                            <td>
                                <label for="rich_editing">
                                    <?php echo esc_textarea($claimant[0]->description) ?>			
                                </label>
                            </td>
                        </tr>
                       
                    </tbody>
                </table>
            </div>
        </div>
    </div>    
</div>
<?php  
}
?>