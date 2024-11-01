<?php
function vid_custom_echo($x, $length)
{
  if(strlen($x)<=$length)
  {
    echo esc_attr($x);
  }
  else
  {
    $y=substr($x,0,$length) . '...';
    echo esc_attr($y);
  }
}
wp_enqueue_script( 'vid_check-custom_js_player_react', plugins_url( '' , __FILE__ ) . '/inc/js/ReactPlayer.standalone.js' );
wp_enqueue_script( 'vid_check-custom_js_plyr', plugins_url( '' , __FILE__ ) . '/inc/js/plyr.min.js' );
wp_enqueue_script( 'vid_check-custom_js', plugins_url( '' , __FILE__ ) . '/inc/js/vidcheck.js' );
wp_enqueue_style( 'vid_check-editor-style', plugins_url( '' , __FILE__ ).'/inc/css/plyr.css' );



global $wpdb;
            $table_name = $wpdb->prefix .'vidcheck_ratings';
            $ratings = $wpdb->get_results("SELECT id,name,slug,description,numericvalue,color,bg_color from $table_name");
            
            $table_name1 = $wpdb->prefix .'vidcheck_claimant';
            $claimant = $wpdb->get_results("SELECT id,name,slug,description,tagline from $table_name1");
            
                $table_name2 = $wpdb->prefix .'vidcheck_video';
                $video = $wpdb->get_results("SELECT * from $table_name2");

          

?>
<style>
.claim_hide{
    display: none;
}
/* .form-table th,
td {
    border-color: #d7aeae00 !important;
    border: 0.1rem solid #dcd7ca00 !important;
} */

.vid_mark {
    border: 3px solid #004d88 !important;
}
</style>

<div>

    

  
    <input type="hidden" name="video_slug" id="video_slug" value = "<?php echo esc_attr($video[0]->url); ?>">

    <?php 
        for($i=0;$i<count($video);$i++){
            $video_id = $video[$i]->id;
            
            $table_name3 = $wpdb->prefix .'vidcheck_claim';
            $claim = $wpdb->get_results("SELECT * from $table_name3 where video_id=$video_id");

            $vidchecks = $wpdb->get_results("SELECT $table_name3.*, $table_name.name, $table_name.id, $table_name.bg_color, $table_name.color
            FROM $table_name3
            LEFT JOIN $table_name
            ON $table_name3.rating_id=$table_name.id
            WHERE $table_name3.video_id=$video_id
            ORDER BY $table_name3.id;");

           

    ?>
        <table class="vidcheck" >
            <tbody >
            <tr>
                <td style="vertical-align:top; border-top: 1px solid #f0f0f000; border-left: 1px solid #f0f0f000; border-bottom: 1px solid #f0f0f000;">            
                    <?php
                     
                        if(preg_match('/(http(s|):|)\/\/(www\.|)yout(.*?)\/(embed\/|watch.*?v=|)([a-z_A-Z0-9\-]{11})/i',  $video[$i]->url, $results))   {
                            ?>
                            <img style="display: block !important; opacity: 1;" src="http://img.youtube.com/vi/<?php echo esc_attr($results[6]); ?>/mqdefault.jpg" width="100%">
                            <?php
                        }

                    ?>
                    
                   
                    <?php
                       if(preg_match("/(https?:\/\/)?(www\.)?(player\.)?vimeo\.com\/([a-z]*\/)*([0-9]{6,11})[?]?.*/", $video[$i]->url, $output_array)) {
                        ?>
                        <img src="https://vumbnail.com/<?php echo esc_attr($output_array[5]) ?>.jpg" style="opacity: 1 !important"/>
                       <?php
                        }

                    ?>
                   
                    

                </td>
                <td style="vertical-align:top;">
                <?php
                        $posts_table = $wpdb->prefix . 'posts';
                        $video_iid = $video[$i]->post_id;
                        $slug = $wpdb->get_results("SELECT * from $posts_table where id=$video_iid");
                        
                    ?>

                <a href="<?php echo esc_url(get_site_url()); ?>/vid-check/<?php echo esc_attr($slug[0]->post_name) ?>"><b><?php vid_custom_echo($video[$i]->title, 40); ?> </b></a><br>
                            <small >
                            
                            <img style="display: inline-block; opacity: 1; margin-bottom: -6px;" src="<?php echo esc_url(plugins_url( 'inc/icons/clock.png', __FILE__  )); ?>" width="20px" height="20px">
                            <p style="display: inline-block;"><?php echo esc_attr($video[$i]->created_at); ?> </p></small>
                            <p style="margin-bottom: 5px;"> <?php echo vid_custom_echo(esc_html($video[$i]->summary), 100); ?> </p>
                            <p style="margin-bottom: 5px;"><b><?php echo esc_attr(count($claim)) ?></php> Claims in Total</b></span><br>
                            <?php 

                            
                                $ratin = [];

                                for($j=0; $j<count($vidchecks); $j++){
                                    array_push($ratin,(int)$vidchecks[$j]->rating_id);
                                }
                                for($kk=0; $kk<count(array_unique($ratin)); $kk++){
                                    $rat_id = (int)$ratin[$kk];
                                    $vid_id = (int)$video[$i]->id;
                                    $count = $wpdb->get_results("SELECT COUNT(id) as count
                                                FROM $table_name3
                                                WHERE $table_name3.rating_id=$rat_id and $table_name3.video_id=$vid_id
                                                ");
                                    ?>  
                                        <p style="font-weight: 600; color:<?php echo esc_attr($vidchecks[$kk]->bg_color); ?> !important;margin: 0 0 0 0; "> <?php echo esc_attr($count[0]->count); ?> <?php echo esc_attr($vidchecks[$kk]->name); ?></p>
                                    <?php
                                }

                             ?>

                            <!-- Stable -->
                              
                            
                            <?php
                                      $total_mints = (int)$video[$i]->total_duration;
                                      $total_sec =  (int)$video[$i]->total_duration;
                                      $timers = [];
                                   
                                  for($iik=0; $iik<count($vidchecks); $iik++){
                                 
                                     $start = array_map('intval', explode(':', $vidchecks[$iik]->start_time ));
                                     $start_time = $start[0]*3660+$start[1]*60+$start[2];
                                     $end = array_map('intval', explode(':', $vidchecks[$iik]->end_time ));
                                     $end_time = $end[0]*3660+$end[1]*60+$end[2];

                                     $width=round(($end_time-$start_time)/$total_sec*100);

                                     $timers[$iik]['start'] = $start_time;
                                     $timers[$iik]['end'] = $end_time;
                                     $timers[$iik]['bg_color'] =$vidchecks[$iik]->bg_color;

                                     $final_timers = [];
                                     $size = 0;
                                        for($kkij=0; $kkij<count($timers); $kkij++){
                                                

                                            if($kkij==0){
                                                if($timers[$kkij]['start'] != 0){
                                                    $final_timers[$size]['start'] = 0;
                                                    $final_timers[$size]['end'] = $timers[$kkij]['start'];
                                                    $final_timers[$size]['bg_color'] = "#ffffff";
                                                    $final_timers[$size]['value'] = 999;
                                                    $width=round(($final_timers[$size]['end']-$final_timers[$size]['start'])/$total_sec*100);
                                                        $final_timers[$size]['width'] = $width;
                                                    $size++;
                                                    $final_timers[$size]['start'] = $timers[$kkij]['start'];
                                                    $final_timers[$size]['end'] = $timers[$kkij]['end'];
                                                    $final_timers[$size]['bg_color'] = $timers[$kkij]['bg_color'];
                                                     $final_timers[$size]['value'] = $kkij;
                                                    $width=round(($final_timers[$size]['end']-$final_timers[$size]['start'])/$total_sec*100);
                                                        $final_timers[$size]['width'] = $width;
                                                    $size++;
                                                }
                                                if($timers[$kkij]['start'] == 0){
                                                    $final_timers[$size]['start'] = $timers[$kkij]['start'];
                                                    $final_timers[$size]['end'] = $timers[$kkij]['end'];
                                                    $final_timers[$size]['bg_color'] = $timers[$kkij]['bg_color'];
                                                     $final_timers[$size]['value'] = $kkij;
                                                    
                                                    $width=round(($final_timers[$size]['end']-$final_timers[$size]['start'])/$total_sec*100);
                                                        $final_timers[$size]['width'] = $width;
                                                        $final_timers[$size]['index'] = $width;
                                                    $size++;
                                                   
                                                }
                                                if(count($timers) == 1){
                                                    if($timers[$kkij]['end'] != $total_sec){
                                                        $final_timers[$size]['start'] = $timers[$kkij]['end'];
                                                        $final_timers[$size]['end'] = $total_sec;
                                                        $final_timers[$size]['bg_color'] = "#ffffff";
                                                         $final_timers[$size]['value'] = 999;
                                                        
                                                        $width=round(($final_timers[$size]['end']-$final_timers[$size]['start'])/$total_sec*100);
                                                            $final_timers[$size]['width'] = $width;
                                                            $final_timers[$size]['index'] = $width;
                                                        $size++;
                                                    }
                                                }
                                            }
                                            
                                            else if($kkij == count($timers)-1){
                                                if($timers[$kkij]['end'] == $total_sec){
                                                    $final_timers[$size]['start'] = $timers[$kkij]['start'];
                                                    $final_timers[$size]['end'] = $timers[$kkij]['end'];
                                                    $final_timers[$size]['bg_color'] = $timers[$kkij]['bg_color'];
                                                     $final_timers[$size]['value'] = $kkij;
                                                    $width=round(($final_timers[$size]['end']-$final_timers[$size]['start'])/$total_sec*100);
                                                        $final_timers[$size]['width'] = $width;
                                                    $size++;
                                                }
                                                else{
                                                    $final_timers[$size]['start'] = $timers[$kkij-1]['end'];
                                                    $final_timers[$size]['end'] = $timers[$kkij]['start'];
                                                    $final_timers[$size]['bg_color'] = "#ffffff";
                                                    $final_timers[$size]['value'] = 999;
                                                    $width=round(($final_timers[$size]['end']-$final_timers[$size]['start'])/$total_sec*100);
                                                        $final_timers[$size]['width'] = $width;
                                                    $size++;

                                                    $final_timers[$size]['start'] = $timers[$kkij]['start'];
                                                    $final_timers[$size]['end'] = $timers[$kkij]['end'];
                                                    $final_timers[$size]['bg_color'] = $timers[$kkij]['bg_color'];
                                                     $final_timers[$size]['value'] = $kkij;
                                                    $width=round(($final_timers[$size]['end']-$final_timers[$size]['start'])/$total_sec*100);
                                                        $final_timers[$size]['width'] = $width;
                                                    $size++;

                                                    
                                                    $final_timers[$size]['start'] = $timers[$kkij]['end'];
                                                    $final_timers[$size]['end'] = $total_sec;
                                                    $final_timers[$size]['bg_color'] = "#ffffff";
                                                    $final_timers[$size]['value'] = 999;
                                                    $width=round(($final_timers[$size]['end']-$final_timers[$size]['start'])/$total_sec*100);
                                                        $final_timers[$size]['width'] = $width;
                                                    $size++;

                                                }
                                            }
                                            else{
                                                    if($timers[$kkij]['start'] != $timers[$kkij-1]['end']){
                                                        $final_timers[$size]['start'] = $timers[$kkij-1]['end']; 
                                                        $final_timers[$size]['end'] = $timers[$kkij]['start']; 
                                                        $final_timers[$size]['bg_color'] = "#ffffff";
                                                        $final_timers[$size]['value'] = 999;
                                                    $width=round(($final_timers[$size]['end']-$final_timers[$size]['start'])/$total_sec*100);
                                                        $final_timers[$size]['width'] = $width;
                                                        $size++;

                                                        $final_timers[$size]['start'] = $timers[$kkij]['start']; 
                                                        $final_timers[$size]['end'] = $timers[$kkij]['end']; 
                                                        $final_timers[$size]['bg_color'] = $timers[$kkij]['bg_color'];
                                                         $final_timers[$size]['value'] = $kkij;
                                                    $width=round(($final_timers[$size]['end']-$final_timers[$size]['start'])/$total_sec*100);
                                                        $final_timers[$size]['width'] = $width;
                                                        $size++;
                                                    }
                                                    if($timers[$kkij]['start'] == $timers[$kkij-1]['end']){
                                                        $final_timers[$size]['start'] = $timers[$kkij]['start']; 
                                                        $final_timers[$size]['end'] = $timers[$kkij]['end']; 
                                                        $final_timers[$size]['bg_color'] = $timers[$kkij]['bg_color'];
                                                         $final_timers[$size]['value'] = $kkij;

                                                    $width=round(($final_timers[$size]['end']-$final_timers[$size]['start'])/$total_sec*100);
                                                        $final_timers[$size]['width'] = $width;
                                                        $size++;
             
                                                        

                                                    }
                                                    
                                            }


                                        }
                                        
                                       
                                        
                                  }
                            ?>
                                <table style="width: 100%;">
                                    <tr style="display: flex; ">
                                        <?php 
                                    
                                        for($fik=0; $fik<count($final_timers); $fik++){
                                            if(count($claim) > 0)
                                            {
                                            ?>

                                            <td class="fixed_mark"  style="height: 20px;  background:<?php echo esc_attr($final_timers[$fik]['bg_color']); ?>; width:<?php echo esc_attr($final_timers[$fik]['width']); ?>%"></td>


                                            <?php
                                            }
                                        }
                                        
                                        ?>
                                </tr>
                                </table>



                </td>
            </tr>
            </tbody>
        </table>
        <br>

    <?php
        }
   ?>
    
    
   
   <?php
        
    ?>

</div>
<style>
    .vidcheck {
  border-collapse: collapse;
  margin: 0;
  padding: 0;
  width: 100%;
  table-layout: fixed;
}


.vidcheck tr {
  background-color: #f8f8f8;
}

.vidcheck th,
.vidcheck td {
  text-align: left;
}

.vidcheck th {
  font-size: .85em;
  letter-spacing: .1em;
  text-transform: uppercase;
}

@media screen and (max-width: 600px) {
  


  .vidcheck thead {
    border: none;
    clip: rect(0 0 0 0);
    height: 1px;
    margin: -1px;
    overflow: hidden;
    padding: 0;
    position: absolute;
    width: 1px;
  }
  .no-display {
    opacity: 1 !important;
}
  .vidcheck tr {
    display: block;
  }
  
  .vidcheck td {
    display: block;
  }
  
  .vidcheck td::before {
    /*
    * aria-label has no advantage, it won't be read inside a table
    content: attr(aria-label);
    */
    content: attr(data-label);
    float: left;
    font-weight: bold;
    text-transform: uppercase;
  }
  
  .vidcheck td:last-child {
    border-bottom: 0;
  }
}
</style>
<?php
?>




<script>
jQuery(document).ready(function() {
    jQuery('#claim_list_0').removeClass('claim_hide');
    jQuery('#claim_list_des_0').removeClass('claim_hide');
    jQuery('.fixed_mark').removeClass('vid_mark');
    jQuery('#vidcheck_marked_0').addClass('vid_mark');

    
    

    var url1 = jQuery("#video_slug").val();
                console.log(url1);                  
                                var regexp = /(ftp|http|https):\/\/(\w+:{0,1}\w*@)?(\S+)(:[0-9]+)?(\/|\/([\w#!:.?+=&%@!\-\/]))?/
                        if(regexp.test(url1) == true){
                            jQuery('.vid_check_column6').removeClass('divhide'); 
                            jQuery('.url_warning').addClass('divhide');
                        

                            var url = url1+"?origin=https://plyr.io&amp;iv_load_policy=3&amp;modestbranding=1&amp;playsinline=1&amp;showinfo=0&amp;rel=0&amp;enablejsapi=1";
                                    jQuery('#video_player_iframe').attr('src',url); 
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
});
function vid_prev_item(id){
    jQuery('.claims_data').addClass('claim_hide');
    jQuery('#claim_list_'+id).removeClass('claim_hide');
    jQuery('.claims_datades').addClass('claim_hide');
    jQuery('#claim_list_des_'+id).removeClass('claim_hide');
    jQuery('.fixed_mark').removeClass('vid_mark');
    jQuery('#vidcheck_marked_'+id).addClass('vid_mark');
}

function vid_next_item(id){
    jQuery('.claims_datades').addClass('claim_hide');
    jQuery('#claim_list_des_'+id).removeClass('claim_hide');
    jQuery('.claims_data').addClass('claim_hide');
    jQuery('#claim_list_'+id).removeClass('claim_hide');
    jQuery('.fixed_mark').removeClass('vid_mark');
    jQuery('#vidcheck_marked_'+id).addClass('vid_mark');
}

    </script>
