<?php

function vid_vidcheck_add() {
    wp_enqueue_script( 'vid_check-custom_js_react', plugins_url( '' , __FILE__ ) . '/inc/js/ReactPlayer.standalone.js' );
    wp_enqueue_script( 'vid_check-custom_js_plyr', plugins_url( '' , __FILE__ ) . '/inc/js/plyr.min.js' );
    wp_enqueue_script( 'vid_check-custom_js_vidcheck', plugins_url( '' , __FILE__ ) . '/inc/js/vidcheck.js' );
    wp_enqueue_script( 'vid_check-custom_js_jqury', includes_url() . '/js/jquery/jquery.min.js' );
    wp_enqueue_style( 'vid_check-editor-style_plyr', plugins_url( '' , __FILE__ ).'/inc/css/plyr.css' );
    wp_enqueue_style( 'vid_check-editor-style_vidcheck', plugins_url( '' , __FILE__ ).'/inc/css/vidcheck.css' );


    wp_enqueue_media();
    ?>
   
<style>
.cust_input{
    padding: 3px 8px;
    font-size: 1.5em;
    line-height: 100%;
    height: 1.5em;
    width: 100%;
    outline: 0;
    margin: 0 0 3px;
    background-color: #fff;
}
.cust_textarea{
    width: 100%;
    margin: 0 0 3px;
}

.divhide{
    display: none;
}
.error_message{
    color: red;
}
.vid_help_text{
    margin: 2px 0 5px;
    color: #646970;
    font-size: 13px !important;
}
</style>
<div id="wpbody">
<div id="wpbody-content">
		<span id="htmlcontent"></span>
<form id="register_form" novalidate action="#" method="post">
    <?php wp_nonce_field(plugin_basename(__FILE__), 'vidcheck_add_nonce'); ?>

		<div class="wrap">
            <h1>Add New Fact Check</h1>
            <table class="form-table">
                <tr >
                    <td width="60%" style="vertical-align:top;">
                    <h2 class="title">Fact Check Title</h2>
            <input type="text" class="cust_input" name="video_title" size="30" value="" id="video_title" placeholder="Enter Title" spellcheck="true" autocomplete="off">
            <p class="vid_help_text">The title of the 'Fact Check' Article</p>
            <span class="divhide error_message" id="err_video_title">VidChek Title is Required</span>
            <div>
                                            <h3>Video URL</h3>
                                            <input type="url" class="cust_input" class="form-control" name="video_slug" id="video_slug" placeholder="Paste url here" required>
                                            <p class="vid_help_text">The URL of the video you wish to fact-check (YouTube, Vimeo link etc.)</p>
                                            <span class="divhide error_message" id="err_video_slug">Video URL is Required</span>
                                            <input type="hidden" class="cust_input" class="form-control" name="total_duration" id="total_duration" placeholder="Paste url here" required>
                                            <span class="divhide error_message" id="err_total_duration">Video Duration is Required</span>
                                            <span class="url_warning divhide">Enter Valid Video URL</span>
                                        </div> 
                                        <div>
                                            <h3>Excerpt</h3>
                                            <textarea class="cust_textarea" name="excerpt" id="tag-description" rows="5" cols="40"></textarea required>
                                            <span class="divhide error_message" id="err_excerpt">VidCheck Excerpt is Required</span>
                                        </div>
                    </td>
                    <td width="40%" style="vertical-align:top;">
                    <!-- <h2 class="title">Claim Sources</h2><br>
                    <table>
                                <div id="newRow"></div>
                        </table>
                                <button style="width: 100%;" id="addRow" type="button" class="button">Add Row</button> -->
                    </td>

                </tr>           

            </table>
                                        <br>
                                        <div class="vid_check_column3" ></div>
                                        <div class="vid_check_column6 divhide">
                                        <div class="plyr__video-embed " id="player">
                                            <iframe  id="video_player_iframe" allowfullscreen allowtransparency allow="autoplay" ></iframe>
                                        </div>
                                        </div>
                                        <div class="vid_check_column3" ></div>

                                        <div class="vid_check_column6 divhide" style="margin-top: 10px;" >
                                    <h3 for="end_time1">Start time  <a onclick="vid_functionName_start()">Now</a></h3> 
                                        <input class="cust_input" type="text" class="form-control" name="start_tim1" id="start_tim1" required>
                                        <span class="divhide error_message" id="err_start_tim1">Start Time is Required</span>
                                    </div>
                                    <div class="vid_check_column6 divhide" style="margin-top: 10px;" >
                                    <h3 for="end_time1">End time  <a onclick="vid_functionName_end()">Now</a></h3> 
                                    <input class="cust_input" type="text" class="form-control" name="end_time1" id="end_time1" required>
                                    <span class="divhide error_message" id="err_end_time1">End Time is Required</span>
                                    <br> <br>
                                    <input type="submit" name="add_claim_submit" class="button claim_submit" value="Add Claim" />

                                    </div>
                                    </form>
                                  
		</div>
        <div class="vid_check_column12">
        <!-- <input type="submit" name="vidcheck_submit" class="button button-primary button-large" value="Submit" /> -->
        </div>

<div class="clear"></div>

</div><!-- wpbody-content -->
<div class="clear"></div>
</div><!-- wpbody -->
<script>
    jQuery('#register_form').submit(function() {
      
    if (jQuery.trim(jQuery("#start_tim1").val()) == "") {
        jQuery('#err_start_tim1').removeClass('divhide'); 
       
    }
    else{
        jQuery('#err_start_tim1').addClass('divhide'); 
    }
    if (jQuery.trim(jQuery("#end_time1").val()) == "") {
        jQuery('#err_end_time1').removeClass('divhide');
       
   }
   else{
        jQuery('#err_end_time1').addClass('divhide'); 
    }
    if (jQuery.trim(jQuery("#video_title").val()) == "") {
        jQuery('#err_video_title').removeClass('divhide');
    }
    else{
        jQuery('#err_video_title').addClass('divhide'); 
    }
    if (jQuery.trim(jQuery("#video_slug").val()) == "") {
        jQuery('#err_video_slug').removeClass('divhide');   
    }
    else{
        jQuery('#err_video_slug').addClass('divhide'); 
    }
    if (jQuery.trim(jQuery("#total_duration").val()) == "") {
        jQuery('#err_total_duration').removeClass('divhide');
    }
    else{
        jQuery('#err_total_duration').addClass('divhide'); 
    }
    if (jQuery.trim(jQuery("#tag-description").val()) == "") {
        jQuery('#err_excerpt').removeClass('divhide');
    }
    else{
        jQuery('#err_excerpt').addClass('divhide'); 
    }

   if (jQuery.trim(jQuery("#start_tim1").val()) === "" || jQuery.trim(jQuery("#tag-description").val()) === "" || jQuery.trim(jQuery("#total_duration").val()) === "" || jQuery.trim(jQuery("#end_time1").val()) === "" || jQuery.trim(jQuery("#video_title").val()) === "" || jQuery.trim(jQuery("#video_slug").val()) === "") {
        return false;
   }
   


});

 var count = 0;
    jQuery("#addRow").click(function () {
           
            var html = '';
            html += '<tr id="inputFormRow">';
            html += '<td>';
            html += '<td><input type="url" name="claim['+count+'][title]" id="claim_title" class="form-control m-input" placeholder="Enter URL" autocomplete="off"></td>';
            html += '<td><input type="text" name="claim['+count+'][desc]" id="claim_desc" class="form-control m-input" placeholder="Enter Description" autocomplete="off"></td>';
            html += '<td>';
            html += '<button id="removeRow" type="button" class="btn btn-danger">Remove</button>';
            html += '<td>';
            html += '</tr>';
            count++;
            jQuery('#newRow').append(html);
        });

        // remove row
        jQuery(document).on('click', '#removeRow', function () {
            jQuery(this).closest('#inputFormRow').remove();
        });
</script>
<?php

if (isset($_POST['add_claim_submit']) ){
    if (!wp_verify_nonce($_POST['vidcheck_add_nonce'], plugin_basename(__FILE__))) {
        echo "Your Nonce Didn't Verify";
    }
    else{ 
    global $wpdb;
    $video_title = sanitize_text_field($_POST['video_title']);
    $video_slug = sanitize_text_field($_POST['video_slug']);
    $total_duration = sanitize_key($_POST['total_duration']);
    $excerpt = sanitize_textarea_field($_POST['excerpt']);
    $video_table = $wpdb->prefix . 'vidcheck_video';
    $posts = $wpdb->prefix . 'posts';
    $postsmeta = $wpdb->prefix . 'postmeta';
    $user = wp_get_current_user()->ID;
    $start_time =  (sanitize_text_field($_POST['start_tim1']));
    $end_time =  (sanitize_text_field($_POST['end_time1']));
    $date = date('Y-m-d H:i:s');
    $slug=sanitize_title_with_dashes($video_title);
        $sql = $wpdb->prepare( "INSERT INTO ".$posts." (post_author,post_content, post_title, post_name,post_date,post_date_gmt,post_type ) VALUES ( %s,%s, %s, %s,%s, %s, %s)", $user,'[single-vidchecks id=1]',  $video_title, $slug,$date,$date,'vid_check' );
        $wpdb->query($sql);
        $postid=sanitize_key($wpdb->insert_id);


        $wpdb->update(
            $posts,
            array(
                    'post_content' => '[single-vidchecks id='.$postid.']',
            ),
            array(
                'id'=>$postid
            )
            ); 


        $sql2 = $wpdb->prepare( "INSERT INTO ".$postsmeta." (post_id,meta_key, meta_value) VALUES ( %s,%s, %s)", $postid,'_wp_page_template','templates/template-full-width.php' );
        $wpdb->query($sql2);




        $wpdb->insert(
            $video_table,
            array(
                'title' => $video_title,
                'url' => $video_slug,
                'summary' => $excerpt,
                'claim_sources' => '',
                'post_id' => $postid,
                'total_duration' => $total_duration
            )
        );
        $video_id=$wpdb->insert_id;
        $redirect = get_site_url() .'/wp-admin/admin.php?page=add_new_claim&id='.esc_attr($video_id).'&start_time='.esc_attr($start_time).'&end_time='.esc_attr($end_time); 
        
             wp_safe_redirect($redirect);
             exit;
      
            }   
        }
        



if(isset($_POST['vidcheck_submit'])){
    global $wpdb;

    $video_title = sanitize_text_field($_POST['video_title']);
    $video_slug = sanitize_text_field($_POST['video_slug']);
    $total_duration = sanitize_key($_POST['total_duration']);
    $excerpt = sanitize_textarea_field($_POST['excerpt']);
    //$totalclaimsize = sanitize_text_field($_POST['totalclaimsize']);
    // $claim = sanitize_text_field($_POST['claim']);
    // $claim = serialize($claim);
    $video_table = $wpdb->prefix . 'vidcheck_video';
    $claim_table = $wpdb->prefix . 'vidcheck_claim';
    $posts = $wpdb->prefix . 'posts';
    $postsmeta = $wpdb->prefix . 'postmeta';


        // $slug=preg_replace('/[^A-Za-z0-9-]+/', '-', $video_title);
        $slug=sanitize_title_with_dashes($video_title);
        // $video_id = $wpdb->insert_id;
        $user = wp_get_current_user();
        $date = date('Y-m-d H:i:s');

        
        $sql = $wpdb->prepare( "INSERT INTO ".$posts." (post_author,post_content, post_title, post_name,post_date,post_date_gmt,post_type ) VALUES ( %s,%s, %s, %s,%s, %s, %s)", $user,'[single-vidchecks id=1]',  $video_title, $slug,$date,$date,'vid_check' );
        $wpdb->query($sql);
        $postid=sanitize_key($wpdb->insert_id);

        $sql2 = $wpdb->prepare( "INSERT INTO ".$postsmeta." (post_id,meta_key, meta_value) VALUES ( %s,%s, %s)", $postid,'_wp_page_template','templates/template-full-width.php' );
        $wpdb->query($sql2);

        $wpdb->insert(
            $video_table,
            array(
                'title' => $video_title,
                'url' => $video_slug,
                'summary' => $excerpt,
                'claim_sources' => '',
                'post_id' => $postid,
                'total_duration' => $total_duration
            )
        );
        $video_id=sanitize_key($wpdb->insert_id);

        $wpdb->update(
            $posts,
            array(
                'post_content' => "[single-vidchecks id=$video_id]",
            ),
            array(
                'id'=>$postid
            )
        );


    // for($i=1;$i<=$totalclaimsize;$i++){
    //     $start_tim = sanitize_text_field($_POST['start_tim'.$i]);
    //     $end_time = sanitize_text_field($_POST['end_time'.$i]);
    //     $rating = sanitize_text_field($_POST['rating'.$i]);
    //     $claimant = sanitize_text_field($_POST['claimant'.$i]);
    //     $claim_content = sanitize_text_field($_POST['claim_content'.$i]);
    //     $fact_content = sanitize_text_field($_POST['fact_content'.$i]);
    //     $claim_date = sanitize_text_field($_POST['claim_date'.$i]);
    //     $checked_date = sanitize_text_field($_POST['checked_date'.$i]);
    //     $description = sanitize_text_field($_POST['description'.$i]);
    //     $review= sanitize_text_field($_POST['review'.$i]);

        
    //     $review = serialize($review);

    //     $wpdb->insert(
    //         $claim_table,
    //         array(
    //             'fact' => $fact_content,
    //             'claim' => $claim_content,
    //             'start_time' => $start_tim,
    //             'end_time' => $end_time,
    //             'claimant_id' => $claimant,
    //             'rating_id' => $rating,
    //             'review_sources' => $review,
    //             'description' => $description,
    //             'is_claim' => 'Null',
    //             'video_id' => $video_id,
    //             'claim_date' => $claim_date,
    //             'checked_date' => $checked_date,
    //         )
    //     );
    // }
    $url = get_site_url() .'/wp-admin/admin.php?page=vidchecks-list';
    ?> 
<meta http-equiv="refresh" content="1; url=<?php echo esc_url($url) ?>" />
        <?php
        exit;
    }
?>


       

<script>
     jQuery("#post_title").change(function(){
        var slug = jQuery("#post_title").val();
        var f_slug = slug
        .toLowerCase()
        .replace(/ /g,'-')
        .replace(/[^\w-]+/g,'')
        ;
        jQuery('#slug').val(f_slug);

    });
    jQuery("#playvideo").click(function(){
      jQuery("#video_slug").val() += "?autoplay=1";
     });
    
         var videoCont = 0;
        jQuery(document).ready(function(){
            
            const seconds = 0;
            const format = val => `0${Math.floor(val)}`.slice(-2)
            const hours = seconds / 3600
            const minutes = (seconds % 3600) / 60

            // alert([hours, minutes, seconds % 60].map(format).join(':'));

            // jQuery("#start_tim1").val([ minutes, seconds % 60].map(format).join(':'));

            jQuery('#video_slug').on('input',function(e){

                            


                                var url1 = jQuery("#video_slug").val();
                                
                            
                                var regexp = /(ftp|http|https):\/\/(\w+:{0,1}\w*@)?(\S+)(:[0-9]+)?(\/|\/([\w#!:.?+=&%@!\-\/]))?/
                        if(regexp.test(url1) == true){
                            jQuery('.vid_check_column6').removeClass('divhide'); 
                            jQuery('.url_warning').addClass('divhide');
                        

                                    jQuery('#video_player_iframe').attr('src',url1); 
                                        const options = {
                                            autoplay: false,
                                            playsinline: true,
                                            clickToPlay: false,
                                            displayDuration: true,
                                            controls: ['play-large', 'play', 'progress', 'current-time', 'mute', 'volume', 'captions', 'settings', 'pip', 'airplay', 'fullscreen'],
                                            debug: true,
                                            loop: {
                                                active: true
                                            }
                                        }
                                    videoCont = new Plyr('#player', options);
                                    console.log(videoCont);
                                   
                                        jQuery('#htmlcontent').text(videoCont[0]);
                                       

                                   

                                }
                        else{
                            jQuery('.url_warning').removeClass('divhide'); 
                            jQuery('.vid_check_column6').addClass('divhide'); 
                        }
                    
                });
            

        });
        function vid_functionName_start(){
           videoCont.play();
                    videoCont.pause();
                    videoCont.play();
                    var seconds = videoCont.currentTime;
                   
                    if(seconds != 0){  
                        var minutes;

                        const d = Number(seconds);
                        const h = Math.floor(d / 3600);
                        const m = Math.floor((d % 3600) / 60);
                        const s = Math.floor((d % 3600) % 60);
                        const hDisplay = h > 0 ? `${h.toString().length > 1 ? `${h}` : `${0}${h}`}` : '00';
                        const mDisplay = m > 0 ? `${m.toString().length > 1 ? `${m}` : `${0}${m}`}` : '00';
                        const sDisplay = s > 0 ? `${s.toString().length > 1 ? `${s}` : `${0}${s}`}` : '00';
                      
                        jQuery("#start_tim1").val(`${hDisplay}:${mDisplay}:${sDisplay}`);
                        console.log(videoCont.duration);
                                            jQuery('#total_duration').val(videoCont.duration);
                    }
                    else{
                    alert('Play Video');
                    videoCont.play();
                }
        }
        function vid_functionName_end(){
           videoCont.play();
                    videoCont.pause();
                    videoCont.play();
                    var seconds = videoCont.currentTime;
                    if(seconds != 0){  
                    var minutes;

                    const d = Number(seconds);
                    const h = Math.floor(d / 3600);
                    const m = Math.floor((d % 3600) / 60);
                    const s = Math.floor((d % 3600) % 60);
                    const hDisplay = h > 0 ? `${h.toString().length > 1 ? `${h}` : `${0}${h}`}` : '00';
                    const mDisplay = m > 0 ? `${m.toString().length > 1 ? `${m}` : `${0}${m}`}` : '00';
                    const sDisplay = s > 0 ? `${s.toString().length > 1 ? `${s}` : `${0}${s}`}` : '00';

                    var check_start_time = jQuery("#start_tim1").val();
                        var a = check_start_time.split(':'); // split it at the colons
                        // minutes are worth 60 seconds. Hours are worth 60 minutes.
                        var check_start_seconds = (+a[0]) * 60 * 60 + (+a[1]) * 60 + (+a[2]); 


                    if(seconds > check_start_seconds)   {
                        jQuery("#end_time1").val(`${hDisplay}:${mDisplay}:${sDisplay}`);
                    }
                    else{
                        alert('End time is less than Start Time');

                        jQuery("#end_time1").val('');
                    }
                    console.log(videoCont.duration);
                                        jQuery('#total_duration').val(videoCont.duration);
                                    }
                    else{
                    alert('Play Video');
                    videoCont.play();
                }
        }
        function vid_functionName(id) {
                    var seconds = videoCont.currentTime;
                    var minutes;
                    minutes = Math.floor(seconds/60);
                    seconds = seconds%60;
                    
                }
</script>

            <?php

        }
?>