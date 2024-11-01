<?php

function vid_update_claim(){
    
    $video_id=sanitize_key($_GET['video_id']);
    $video_id = (int)$video_id;
    global $wpdb;
    $claim_id=sanitize_key($_GET['claim_id']);
    $claim_id = (int)$claim_id;
  
    $table_name = $wpdb->prefix .'vidcheck_ratings';
    $ratings = $wpdb->get_results("SELECT id,name,slug,description,numericvalue,color from $table_name");
    $table_name1 = $wpdb->prefix .'vidcheck_claimant';
    $claimant = $wpdb->get_results("SELECT id,name,slug,description,tagline from $table_name1");
    $table_name2 = $wpdb->prefix .'vidcheck_video';
    $video = $wpdb->get_results("SELECT * from $table_name2 where id=$video_id");
    $table_name3 = $wpdb->prefix .'vidcheck_claim';
    $claim = $wpdb->get_results("SELECT * from $table_name3 where id=$claim_id");

    $start_time = $claim[0]->start_time;
    $end_time = $claim[0]->end_time;
    $rating_id = $claim[0]->rating_id;
    $claimant_id = $claim[0]->claimant_id;
?>

<div id="wpbody" role="main">
   <div id="wpbody-content">
      <div class="wrap">
         <h1 id="add-new-user">
            Update Claim: <b><?php echo esc_attr($video[0]->title) ?></b>
         </h1>
         <div id="ajax-response"></div>
         <form method="post" class="validate" novalidate="novalidate">
         <?php wp_nonce_field(plugin_basename(__FILE__), 'vidcheck_update_new_claim_nonce'); ?>
  
            <table class="form-table" role="presentation">
               <tbody>
              

                  <tr class="form-field form-required">
                    <td colspan="2"> <Label>Start Time</Label>
                    <input type="text"  style="margin-top:10px;" name="start_time_form" id="start_time_form" value="<?php echo esc_attr($start_time) ?>" required>
                </td>
                    <td colspan="2"> <Label>End Time</Label>
                    <input type="text"  style="margin-top:10px;"  name="end_time_form" id="end_time_form" value="<?php echo esc_attr($end_time) ?>" required/>
                    </td>
                  </tr>
                  <tr class="form-field form-required">
                        <td width="25%">
                        <Label>Rating</Label><br>
                            <select style="margin-top:10px; width: 90%;" name="rating" id="rating" required> 
                            <option>Select a rating of the claim</option>
                            <?php 
                                    foreach($ratings as $rating){
                                            if($rating->id == $rating_id)
                                            {
                                                ?>
                                                <option selected value="<?php echo esc_attr($rating->id); ?>"><?php echo esc_attr($rating->name) ?></option>
                                                <?php
                                            } 
                                            else{
                                                ?>
                                                <option value="<?php echo esc_attr($rating->id); ?>"><?php echo esc_attr($rating->name) ?></option>
                                                <?php
                                            }
                                    }
                                ?>		
                            </select>
                                <p>The rating of the particular claim</p>
                        </td>
                        <td width="25%">
                        <Label>Claimant</Label><br>
                            <select style="margin-top:10px; width: 90%;" name="claimants" id="claimants" required>
                            <option>Select a claimant of the claim</option>
                            <?php 
                                    foreach($claimant as $claimants){
                                            if($claimants->id == $claimant_id)
                                            {
                                                ?>
                                                <option selected value="<?php echo esc_attr($claimants->id); ?>"><?php echo esc_attr($claimants->name) ?></option>
                                                <?php
                                            } 
                                            else{
                                                ?>
                                                <option value="<?php echo esc_attr($claimants->id); ?>"><?php echo esc_attr($claimants->name) ?></option>
                                                <?php
                                            }
                                    }
                                ?>		
                            </select>
                            <p>The person/entity where the claim is found</p>

                        </td>
                        <td width="25%">
                            <Label>Claim Date</Label><br>
                            <input style="margin-top:10px; width: 90%;" type="date" value="<?php echo esc_attr($claim[0]->claim_date); ?>" name="claim_data" id="claim_data">
                            <p>Date on which the Claim is made</p>
                        </td>
                        <td width="25%">
                            <Label>Checked Date</Label><br>
                            <input style="margin-top:10px; width: 90%;" type="date" value="<?php echo esc_attr($claim[0]->checked_date); ?>" name="checked_date" id="checked_date">
                            <p>Date on which the Claim is fact-checked</p>
                        </td>
                  
                  </tr>
                  <tr class="form-field form-required">
                    <td colspan="2"> <Label>Claim</Label><br>
                        <textarea style="margin-top:10px;" rows="5" name="claim" id="claim"> <?php echo esc_attr($claim[0]->claim); ?></textarea>
                                    <p>Description of the Claim</p>
                    </td>
                    <td colspan="2"> <Label>Fact</Label><br>
                        <textarea style="margin-top:10px;" rows="5" name="fact" id="fact"> <?php echo esc_attr($claim[0]->fact); ?></textarea>
                        <p>Description of the Fact</p>
                    </td>
                  </tr>
                  <tr>
                        <td  colspan="4">
                            <Label>Description</Label><br><br>
                            <span style="margin-top:10px;"><?php wp_editor(esc_textarea($claim[0]->description),'description')?></span>
                            <p>Detailed fact-check with sources & references</p>
                        </td>

                  </tr>
                  <tr>
                    <td colspan="4">
                         <label for="checked_date">Review Sources</label><br>
                         <p>List of all sources used for Fact-Checking and arriving at a rating with individual entries for each source along with this type</p>
                         <br>
                         <table>
                                    <?php 
                                     $review = json_decode($claim[0]->review_sources);
                                    
                                     if($review != null){
                                        for($i=0;$i<count($review);$i++){
                                            ?>
    
                                            <tr id="inputFormRow">
                                            <td>
                                            <td><input type="url" name="review[<?php echo esc_attr($i); ?>][title]" value="<?php echo esc_attr($review[$i]->title); ?>" id="review_title" class="form-control m-input" placeholder="Enter URL" autocomplete="off"></td>
                                            <td><input type="text" name="review[<?php echo esc_attr($i); ?>][desc]" value="<?php echo esc_attr($review[$i]->desc); ?>" id="review_desc" class="form-control m-input" placeholder="Enter Description" autocomplete="off"></td>
                                            <td>
                                            <button id="removeRow" type="button" class="btn btn-danger">Remove</button>
                                            <td>
                                            </tr>
                                            <?php
                                            }
                                     }
                                     else{
                                         $i = 0;
                                     }
                                    
                                    ?>

                                <div id="newRow"></div>
                        </table>
                                <button style="width: 100%;" id="addRow" type="button" class="button">Add Row</button>
                    </td>
                </tr>
               </tbody>
            </table>
            <input type="submit" name="submit_claim_new" id="submit_claim_newsub" class="button button-primary" value="Update Claim">
         </form>
           
      </div>
      <div class="clear"></div>
   </div>
   <!-- wpbody-content -->
   <div class="clear"></div>
</div>
<?php 
if (isset($_POST['submit_claim_new']) ){
    if (!wp_verify_nonce($_POST['vidcheck_update_new_claim_nonce'], plugin_basename(__FILE__))) {
        echo "Your Nonce Didn't Verify";
    }
    else{
        $start_time = sanitize_text_field($_POST['start_time_form']);
        $end_time = sanitize_text_field($_POST['end_time_form']);
        $rating = sanitize_key($_POST['rating']);
        $claimants = sanitize_key($_POST['claimants']);
        $claim_data = sanitize_title($_POST['claim_data']);
        $checked_date = sanitize_title($_POST['checked_date']);
        $claim = sanitize_text_field($_POST['claim']);
        $fact = sanitize_text_field($_POST['fact']);
        $description = sanitize_text_field($_POST['description']);
        
       
        if(isset($_POST['review'])){

            $review_dum = $_POST['review'];
            $review = [];
            for($i=0;$i<count($review_dum);$i++){
                $review[$i]["title"] = sanitize_text_field($review_dum[$i]["title"]);
                $review[$i]["desc"] = sanitize_text_field($review_dum[$i]["desc"]);
            }


            $review = json_encode($review);

        }
        else{
            $review = 'N;';
        }

        $claim_table = $wpdb->prefix . 'vidcheck_claim';

    
        $id=sanitize_key($_GET['claim_id']);
        global $wpdb;
        $wpdb->update(
            $claim_table,
            array(
                        'fact' => $fact,
                        'claim' => $claim,
                        'start_time' => $start_time,
                        'end_time' => $end_time,
                        'claimant_id' => $claimants,
                        'rating_id' => $rating,
                        'description' => $description,
                        'is_claim' => 'Null',
                        'video_id' => $video_id,
                        'claim_date' => $claim_data,
                        'checked_date' => $checked_date,
                        'review_sources' => $review,
            ),
            array(
                'id'=>$id
            )
        );
        
        $redirect = get_site_url() .'/wp-admin/admin.php?page=edit_new_claim&video_id='.$video_id;
             wp_safe_redirect($redirect);
             exit;
      
    }
}
?>
<script>
    jQuery(document).ready(function() {
        window.review_count = '<?php echo esc_attr($i); ?>';
       
    });
 
    jQuery("#addRow").click(function () {

            var html = '';
            html += '<tr id="inputFormRow">';
            html += '<td>';
            html += '<td><input type="url" name="review['+review_count+'][title]" id="review_title" class="form-control m-input" placeholder="Enter URL" autocomplete="off"></td>';
            html += '<td><input type="text" name="review['+review_count+'][desc]" id="review_desc" class="form-control m-input" placeholder="Enter Description" autocomplete="off"></td>';
            html += '<td>';
            html += '<button id="removeRow" type="button" class="btn btn-danger">Remove</button>';
            html += '<td>';
            html += '</tr>';
            review_count++;
            jQuery('#newRow').append(html);
        });

        // remove row
        jQuery(document).on('click', '#removeRow', function () {
            jQuery(this).closest('#inputFormRow').remove();
        });
</script>

<?php

}

?>