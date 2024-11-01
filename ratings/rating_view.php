<?php

function vid_rating_view() {
    $i=sanitize_key($_GET['id']);
    global $wpdb;
    $table_name = $wpdb->prefix . 'vidcheck_ratings';
    $ratings = $wpdb->get_results("SELECT id,name,slug,description,numericvalue,color from $table_name where id=$i");
?>

<div class="wrap">
    <div id="wpbody" role="main">
        <div id="wpbody-content">
            <div class="wrap nosubsub">
                <h1 class="wp-heading-inline">Ratings Deatils of <?php echo esc_attr($ratings[0]->name) ?>		</h1>
                <table class="form-table" role="presentation">
                    <tbody>
                        <tr>
                            <th scope="row">Name</th>
                            <td>
                                <label for="rich_editing">
                                    <?php echo esc_attr($ratings[0]->name) ?>			
                                </label>
                            </td>
                        </tr>
                        <tr>
                            <th scope="row">URL</th>
                            <td>
                                <label for="rich_editing">
                                    <?php echo esc_attr($ratings[0]->slug) ?>			
                                </label>
                            </td>
                        </tr>
                        <tr>
                            <th scope="row">Numeric Value</th>
                            <td>
                                <label for="rich_editing">
                                    <?php echo esc_attr($ratings[0]->numericvalue) ?>			
                                </label>
                            </td>
                        </tr>
                        <tr>
                            <th scope="row">Color</th>
                            <td>
                                <label for="rich_editing">
                                
                                <span style="color:<?php echo esc_attr($ratings[0]->color) ?>; background-color:<?php echo esc_attr($ratings[0]->color) ?>">__________</span>
                                    		
                                </label>
                            </td>
                        </tr>
                        <tr>
                            <th scope="row">Description</th>
                            <td>
                                <label for="rich_editing">
                                    <?php echo esc_html($ratings[0]->description) ?>			
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