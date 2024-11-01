<?php
function vid_edit_new_claim() {
    wp_enqueue_script( 'vid_check-custom_js_react1', plugins_url( '/inc/js/ReactPlayer.standalone.js' , dirname(__FILE__ )));
    wp_enqueue_script( 'vid_check-custom_js_plyr', plugins_url( '/inc/js/plyr.min.js' , dirname(__FILE__) ));
    wp_enqueue_script( 'vid_check-custom_js_vidcheck', plugins_url( '/inc/js/vidcheck.js' , dirname(__FILE__) ));
    wp_enqueue_script( 'vid_check-custom_js_jqury', includes_url() . '/js/jquery/jquery.min.js' );
    wp_enqueue_style( 'vid_check-editor-style_plyr', plugins_url( '/inc/css/plyr.css' , dirname(__FILE__) ));
    wp_enqueue_style( 'vid_check-editor-style_vidcheck', plugins_url( '/inc/css/vidcheck.css' , dirname(__FILE__) ));

    wp_enqueue_media();
    $video_id=sanitize_key($_GET['video_id']);
    $video_id = (int)$video_id;
    global $wpdb;
    
    $table_name2 = $wpdb->prefix .'vidcheck_video';
    $video = $wpdb->get_results("SELECT * from $table_name2 where id=$video_id");
    $table_name3 = $wpdb->prefix .'vidcheck_claim';
    $table_name4 = $wpdb->prefix .'vidcheck_ratings';
    $claim = $wpdb->get_results("SELECT * from $table_name3 where video_id=$video_id");

    $claim = $wpdb->get_results("SELECT $table_name3.*, $table_name4.bg_color
    FROM $table_name3
    LEFT JOIN $table_name4 ON $table_name4.id = $table_name3.rating_id where video_id=$video_id");

    ?>

<style>
    .cust_input {
        padding: 3px 8px;
        font-size: 1.5em;
        line-height: 100%;
        height: 1.5em;
        width: 100%;
        outline: 0;
        margin: 0 0 3px;
        background-color: #fff;
    }

    .cust_textarea {
        width: 100%;
        margin: 0 0 3px;
    }

    .divhide {
        display: none;
    }

    .error_message {
        color: red;
    }
</style>

<div id="wpbody">
    
    <div id="wpbody-content">

        <form id="register_form" novalidate action="#" method="post">
            <?php wp_nonce_field(plugin_basename(__FILE__), 'vidcheck_edit_new_claim_nonce'); ?>
                        <div class="wrap">
                <h1><b></b>VidCheck: </b><?php echo esc_attr($video[0]->title) ?></h1> 



                <table width="100%" class="form-table">
                    <tr>
                        <td width="60%" style="vertical-align:top;">
                            <h2 class="title">Title</h2>
                            <input type="text" class="cust_input" name="video_title" size="30" id="video_title"
                                value="<?php echo esc_attr($video[0]->title) ?>" placeholder="Enter Title"
                                spellcheck="true" autocomplete="off">
                            <span class="divhide error_message" id="err_video_title">VidChek Title is Required</span>
                            <div>
                                <h3>URL</h3>
                                <input type="url" class="cust_input" class="form-control" name="video_slug"
                                    id="video_slug" value="<?php echo esc_attr($video[0]->url) ?>"
                                    placeholder="Paste url here" required>
                                <span class="divhide error_message" id="err_video_slug">Video URL is Required</span>
                                <span class="url_warning divhide">Enter Valid Video URL</span>
                            </div>
                            <input type="hidden" class="cust_input" class="form-control" name="total_duration"
                                id="total_duration" value="<?php echo esc_attr($video[0]->total_duration) ?>"
                                placeholder="Paste url here" required>
                            <span class="divhide error_message" id="err_total_duration">Video Duration is
                                Required</span>
                            <div>
                                <h3>Excerpt</h3>
                                <textarea class="cust_textarea" name="excerpt" id="tag-description" rows="5" cols="40"><?php echo esc_attr($video[0]->summary) ?></textarea required>
                                            <span class="divhide error_message" id="err_excerpt">VidCheck Excerpt is Required</span>
                                        </div>   
</td>
<td width="40%" style="vertical-align:top;">
                    
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
                                    <h3 for="end_time1">End Time  <a onclick="vid_functionName_start()">Now</a></h3> 
                                        <input class="cust_input" type="text" class="form-control" name="start_tim1" id="start_tim1" >
                                        <span class="divhide error_message" id="err_start_tim1">Start Time is Required</span>
                                    </div>
                                    <div class="vid_check_column6 divhide" style="margin-top: 10px;" >
                                    <h3 for="end_time1">Time  <a onclick="vid_functionName_end()">Now</a></h3> 
                                    <input class="cust_input" type="text" class="form-control" name="end_time1" id="end_time1" >
                                    <span class="divhide error_message" id="err_end_time1">End Time is Required</span>
                                    <br> <br>
                                    <button name="add_claim_submit" class="add_claim_submit button claim_submit">Add Claim</button>

                                    </div>

                                   
                              <br>
                              <br>


		</div>
        <div class="vid_check_column12">
        <?php 
        $all_start_time = [];
        $all_end_time = [];

for($i=0;$i<count($claim); $i++){

                ?>
            <div style="box-shadow: 1px 1px #686868ab; border: 1px solid #b4b4b4; padding:15px;">
                <div>
                Duration:
                <br><br>
            <?php
                
                echo esc_attr($claim[$i]->start_time)."-".esc_attr($claim[$i]->end_time);

                // list($h, $m, $s) = explode(':', $claim[$i]->start_time);
	            // $claim_start_time = ($m * 60) + $s;
               
                $str_time = preg_replace("/^([\d]{1,2})\:([\d]{2})$/", "00:$1:$2", $claim[$i]->start_time);
                sscanf($str_time, "%d:%d:%d", $hours, $minutes, $seconds);
                $claim_start_time = $hours * 3600 + $minutes * 60 + $seconds;

                $end_time = preg_replace("/^([\d]{1,2})\:([\d]{2})$/", "00:$1:$2", $claim[$i]->end_time);
                sscanf($end_time, "%d:%d:%d", $hours, $minutes, $seconds);
                $claim_end_time = $hours * 3600 + $minutes * 60 + $seconds;


                // list($m1, $s1) = explode(':', $claim[$i]->end_time);
	            // $claim_end_time = ($m1 * 60) + $s1;
                //echo ($claim_start_time);
                array_push($all_start_time, $claim_start_time);
               
                array_push($all_end_time, $claim_end_time);
            ?>
                <br><br>
                <b>Claim:</b>
                <br><br>
                <?php
                echo esc_attr($claim[$i]->fact);
            ?>
                <br><br>

                <b>Fact:</b>
                <br><br>
                <?php
                echo '<span style="color:'.esc_attr($claim[$i]->bg_color).'">'.esc_attr($claim[$i]->claim).'</span>';
            ?>
                    </div>
                    <br>  
                    <a href="<?php echo esc_url(admin_url('admin.php?page=update_claim&video_id='.esc_attr($video_id).'&claim_id='.esc_attr($claim[$i]->id))); ?>" class="update_claim_submit button button-primary button-large">Edit</a>
                    
                        <?php
                            $url = add_query_arg(
                                    [
                                        'page'=>'claim_delete',
                                        'action' => 'claim_delete',
                                        'claimnt_id'   => $claim[$i]->id,
                                        'video_id'   => $claim[$i]->video_id,
                                        'nonce'  => wp_create_nonce( 'claim_delete' ),
                                    ], admin_url()
                                );

                        ?>


                    <a href="<?php echo esc_url(wp_nonce_url( $url )); ?>" style="color: #e8004b; border-color: #e8004b;" class="button">Delete</a>
                    </div>
                <br>
              
                    <?php
}
$all_start_time = implode(',',$all_start_time);
$all_end_time = implode(',',$all_end_time);
?>
<br><br>
<input type="hidden" name="all_start_time[]" id="all_start_time" value="<?php echo esc_attr($all_start_time); ?>">
                <input type="hidden" name="all_end_time[]" id="all_end_time" value="<?php echo esc_attr($all_end_time); ?>">
                <input type="submit" name="save_video_details" class="button claim_submit" value="Save & Publish" />
                </form>
        <!-- <input type="submit" name="vidcheck_submit" class="button button-primary button-large" value="Submit" /> -->
        </div>
<div class="clear"></div>

</div><!-- wpbody-content -->
<div class="clear"></div>
</div><!-- wpbody -->

<script>
 var count = 0;
 jQuery(document).ready(function() {
        window.review_count = '<?php echo esc_attr($i); ?>';
     
       
    });
    jQuery("#addRow").click(function () {
        
        
       // alert(all_end_time);
       // alert('hi');
            var html = '';
            html += '<tr id="inputFormRow">';
            html += '<td>';
            html += '<td><input type="url" name="claim['+review_count+'][title]" id="claim_title" class="form-control m-input" placeholder="Enter URL" autocomplete="off"></td>';
            html += '<td><input type="text" name="claim['+review_count+'][desc]" id="claim_desc" class="form-control m-input" placeholder="Enter Description" autocomplete="off"></td>';
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
if(isset($_POST['delete_claim_submit'])){
        global $wpdb;
        $table_name=$wpdb->prefix.'vidcheck_claim';
        $i=sanitize_key($_POST['delete_claim_submit']);
        $wpdb->delete(
            $table_name,
            array('id'=>$i)
        );    
     $url = get_site_url() .'/wp-admin/admin.php?page=edit_new_claim&video_id='.$video_id;
    ?>
    <meta http-equiv="refresh" content="0; url=<?php echo esc_url($url) ?>" />
    <?php
}
if(isset($_POST['update_claim_submit'])){
    $url = get_site_url() .'/wp-admin/admin.php?page=update_claim&video_id='.$video_id.'&claim_id='.$_POST['update_claim_submit']; 
    ?>
        <meta http-equiv="refresh" content="0; URL='<?php echo esc_url($url) ?>'" />    
<?php

}
if (isset($_POST['add_claim_submit']) ){
    if (!wp_verify_nonce($_POST['vidcheck_edit_new_claim_nonce'], plugin_basename(__FILE__))) {
        echo "Your Nonce Didn't Verify";
    }
    else

    {
    
        $start_time =  sanitize_text_field($_POST['start_tim1']);
        $end_time =  sanitize_text_field($_POST['end_time1']);


                    $str_time = preg_replace("/^([\d]{1,2})\:([\d]{2})$/", "00:$1:$2", $start_time);
                    sscanf($str_time, "%d:%d:%d", $hours, $minutes, $seconds);
                    $claim_start_time = $hours * 3600 + $minutes * 60 + $seconds;
                    $end_time = preg_replace("/^([\d]{1,2})\:([\d]{2})$/", "00:$1:$2", $end_time);
                    sscanf($end_time, "%d:%d:%d", $hours, $minutes, $seconds);
                    $claim_end_time = $hours * 3600 + $minutes * 60 + $seconds;
                    $all_start_time = explode(",",$all_start_time);
                    $all_end_time = explode(",",$all_end_time);
                    $arra = [];
                    for($i=0; $i<count($all_start_time); $i++){
                    
                        if(($claim_start_time <= $all_start_time[$i] && $claim_end_time >= $all_end_time[$i]) || ($claim_end_time <= $all_start_time[$i] && $claim_start_time >= $all_end_time[$i])){

                            $arra[$i] = 1;
                        }
                        else{
                            $arra[$i] = 0;
                        }
                    
                    }
                    if (in_array(1, $arra)) {
                        echo var_dump($arra);
                    
                    }
                    else{
                    $url = get_site_url() .'/wp-admin/admin.php?page=add_new_claim&id='.$video_id.'&start_time='.$start_time.'&end_time='.$end_time;
                    }
        ?>
        <meta http-equiv="refresh" content="0; url=<?php echo esc_url($url) ?>" />
        <?php
    }
}
if (isset($_POST['save_video_details']) ){
    if (!wp_verify_nonce($_POST['vidcheck_edit_new_claim_nonce'], plugin_basename(__FILE__))) {
        echo "Your Nonce Didn't Verify";
    }
    else{
        
        global $wpdb;

        $video_title = sanitize_text_field($_POST['video_title']);
        $video_slug = sanitize_text_field($_POST['video_slug']);
        $excerpt = sanitize_text_field($_POST['excerpt']);
        $video_table = $wpdb->prefix . 'vidcheck_video';
        $posts = $wpdb->prefix . 'posts';
        $postsmeta = $wpdb->prefix . 'postmeta';
        $user = wp_get_current_user()->ID;
        $start_time =  sanitize_text_field($_POST['start_tim1']);
        $end_time =  sanitize_text_field($_POST['end_time1']);

        $date = date('Y-m-d H:i:s');
        //$slug=preg_replace('/[^A-Za-z0-9-]+/', '-', $video_title);
        $slug=sanitize_title_with_dashes($video_title);
        $posts = $wpdb->prefix . 'posts';
        $postsmeta = $wpdb->prefix . 'postmeta';
        $wpdb->update($posts,
        array(
            'post_author' => $user,
            'post_title' => $video_title
        ),
        array(
            'id'=>esc_attr($video[0]->post_id),
        )
        );

        $wpdb->update(
            $video_table,
            array(
                    'title' => $video_title,
                    'url' => $video_slug,
                    'summary' => $excerpt,
                    'claim_sources' => '',
            ),
            array(
                'id'=>$video_id
            )
            );    


        $url = get_site_url() .'/wp-admin/admin.php?page=edit_new_claim&video_id='.$video_id; 
            ?> 
            <meta http-equiv="refresh" content="0; url=<?php echo esc_url($url) ?>" />
                <?php
                    exit;
    }   
}       



   
    ?> 

        <?php
        
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
                                var url1 = jQuery("#video_slug").val();
                                var regexp = /(ftp|http|https):\/\/(\w+:{0,1}\w*@)?(\S+)(:[0-9]+)?(\/|\/([\w#!:.?+=&%@!\-\/]))?/
                        if(regexp.test(url1) == true){
                            jQuery('.vid_check_column6').removeClass('divhide'); 
                            jQuery('.url_warning').addClass('divhide');
                      
                            // var url = url1+"?origin=https://plyr.io&amp;iv_load_policy=3&amp;modestbranding=1&amp;playsinline=1&amp;showinfo=0&amp;rel=0&amp;enablejsapi=1";
                            //alert(url);
       
                            jQuery('#video_player_iframe').attr('src',url1); 
                                        const options = {
                                            autoplay: false,
                                            playsinline: true,
                                            clickToPlay: false,
                                            controls: ['play-large', 'play', 'progress', 'current-time', 'mute', 'volume', 'captions', 'settings', 'pip', 'airplay', 'fullscreen'],
                                            debug: true,
                                            loop: {
                                                active: true
                                            }
                                        }
                                    videoCont = new Plyr('#player', options);
                                    console.log(videoCont);
                                    //  alert(videoCont.duration);
                                }
                        else{
                            jQuery('.url_warning').removeClass('divhide'); 
                            jQuery('.vid_check_column6').addClass('divhide'); 
                        }
        });
        function vid_functionName_start(){
                    videoCont.play();
                    videoCont.pause();
                    videoCont.play();
                    var seconds = videoCont.currentTime;
                   
                if(seconds != 0){   
                    const d = Number(seconds);
                    const h = Math.floor(d / 3600);
                    const m = Math.floor((d % 3600) / 60);
                    const s = Math.floor((d % 3600) % 60);
                    const hDisplay = h > 0 ? `${h.toString().length > 1 ? `${h}` : `${0}${h}`}` : '00';
                    const mDisplay = m > 0 ? `${m.toString().length > 1 ? `${m}` : `${0}${m}`}` : '00';
                    const sDisplay = s > 0 ? `${s.toString().length > 1 ? `${s}` : `${0}${s}`}` : '00';
                    //jQuery("#start_tim1").val(`${hDisplay}:${mDisplay}:${sDisplay}`);


                    var minutes;
                    var hours = hDisplay;
                    minutes = mDisplay;
                    seconds = sDisplay;
                      var  count = (Math.trunc(seconds));
                    if(count < 10){
                        var start_tim1 = jQuery("#start_tim1").val(`${hDisplay}:${mDisplay}:${sDisplay}`);
                    }
                    else{
                        var start_tim1 = jQuery("#start_tim1").val(`${hDisplay}:${mDisplay}:${sDisplay}`);
                    }
                   

                    var all_start_time = jQuery('#all_start_time').val(); 
                    var all_end_time = jQuery('#all_end_time').val(); 
                    all_start_time = (all_start_time.split(",").map(Number));
                    all_end_time = (all_end_time.split(",").map(Number));
                    //var start_tim1 = jQuery.trim(jQuery("#start_tim1").val());
                    //var arr_str = start_tim1.split(":");
                    var seconds_str = hours*3600+ minutes*60+(+Math.trunc(seconds));
                    jQuery('#total_duration').val(videoCont.duration);

                    for(var i=0; i<all_start_time.length; i++){
                        if(seconds_str >= all_start_time[i] && seconds_str <= all_end_time[i]){
                            alert('Selected Time already exists in other Claim, Please choose other');
                            jQuery("#start_tim1").val('');
                            break;
                        }
                        else{
                            jQuery("#start_tim1").val(`${hDisplay}:${mDisplay}:${sDisplay}`);
                        }
                      
                    }
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
                    const d = Number(seconds);
                    const h = Math.floor(d / 3600);
                    const m = Math.floor((d % 3600) / 60);
                    const s = Math.floor((d % 3600) % 60);
                    const hDisplay = h > 0 ? `${h.toString().length > 1 ? `${h}` : `${0}${h}`}` : '00';
                    const  mDisplay = m > 0 ? `${m.toString().length > 1 ? `${m}` : `${0}${m}`}` : '00';
                    const sDisplay = s > 0 ? `${s.toString().length > 1 ? `${s}` : `${0}${s}`}` : '00';
                    
                    var minutes;
                    var hours = hDisplay;
                    minutes = mDisplay;
                    seconds = sDisplay;
                    var  count = (Math.trunc(seconds));
                    var end_time1 = jQuery("#end_time1").val(`${hDisplay}:${mDisplay}:${sDisplay}`);

                    jQuery('#total_duration').val(videoCont.duration);
                    var all_start_time = jQuery('#all_start_time').val(); 
                    var all_end_time = jQuery('#all_end_time').val(); 
                    all_start_time = (all_start_time.split(",").map(Number));
                    all_end_time = (all_end_time.split(",").map(Number));

                    //var start_tim1 = jQuery.trim(jQuery("#start_tim1").val());
                    //var arr_str = start_tim1.split(":");
                    var seconds_str = hours*3600+ minutes*60+(+Math.trunc(seconds));


                   // alert(seconds_str);

                    for(var i=0; i<all_start_time.length; i++){
                        if(seconds_str >= all_start_time[i] && seconds_str <= all_end_time[i]){
                            alert('Selected Time already exists in other Claim, Please choose other');
                            jQuery("#end_time1").val('');
                            break;
                        }
                        else{
                           jQuery("#end_time1").val(`${hDisplay}:${mDisplay}:${sDisplay}`)
                        }
                    }
                        var check_start_time = jQuery("#start_tim1").val();
                        var a = check_start_time.split(':'); // split it at the colons
                        // minutes are worth 60 seconds. Hours are worth 60 minutes.
                        var check_start_seconds = (+a[0]) * 60 * 60 + (+a[1]) * 60 + (+a[2]); 
                    //alert(check_start_seconds);
                        //alert(check_start_seconds);
                        var check_end_time = jQuery("#end_time1").val();
                        var b = check_end_time.split(':'); // split it at the colons
                        // minutes are worth 60 seconds. Hours are worth 60 minutes.
                        var check_end_seconds = (+b[0]) * 60 * 60 + (+b[1]) * 60 + (+b[2]); 
                    //alert(check_end_seconds);
                        // alert(check_start_seconds, check_end_seconds);

                        //const arr_end = check_end_time.split(":");
                        //const check_end_seconds = arr_end[0]*60+(+arr_end[1]);
                        //alert(check_end_seconds);

                        if(check_end_seconds > check_start_seconds){
                            jQuery("#end_time1").val(`${hDisplay}:${mDisplay}:${sDisplay}`)
                        }
                        else{
                            alert('End time is less than Start Time');
                            jQuery("#end_time1").val('');
                        }
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

                jQuery("#start_tim1").change(function(){
                   // alert('changed');
                });

        jQuery('#register_form').submit(function() {

       

      if (jQuery.trim(jQuery("#start_tim1").val()) == "") {
          jQuery('#err_start_tim1').removeClass('divhide'); 
         
      }
      else{
          jQuery('#err_start_tim1').addClass('divhide'); 
      }
      if (jQuery.trim(jQuery("#end_time1").val()) == "") {
          jQuery('#err_end_time1').removeClass('divhide');
          for(var i=0; i<all_start_time.length; i++){
            if(seconds_end >= all_start_time[i] && seconds_end <= all_end_time[i]){
                alert('exists');
            }
          
        }
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
</script>

            <?php

        }
?>