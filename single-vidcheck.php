<?php
wp_enqueue_script( 'vid_check-custom_js_react', plugins_url( '' , __FILE__ ) . '/inc/js/ReactPlayer.standalone.js' );
wp_enqueue_script( 'vid_check-custom_js_plyr', plugins_url( '' , __FILE__ ) . '/inc/js/plyr.min.js' );
wp_enqueue_script( 'vid_check-custom_js_vidcheck', plugins_url( '' , __FILE__ ) . '/inc/js/vidcheck.js' );
wp_enqueue_script( 'vid_check-custom_js_jquery', includes_url() . '/js/jquery/jquery.min.js' );
wp_enqueue_style( 'vid_check-editor-style', plugins_url( '' , __FILE__ ).'/inc/css/plyr.css' );

$values = shortcode_atts(
    array(
        "id"=>"0"
    ),
    $params, //dynamic
    'single-vidchecks'
);

    $i = $values['id'];

    $i = (int)$i;
    global $wpdb;
                $table_name = $wpdb->prefix .'vidcheck_ratings';
                $ratings = $wpdb->get_results("SELECT id,name,slug,description,numericvalue,color,bg_color from $table_name");
                
                $table_name1 = $wpdb->prefix .'vidcheck_claimant';
                $claimant = $wpdb->get_results("SELECT id,name,slug,description,tagline from $table_name1");
            
                $table_name2 = $wpdb->prefix .'vidcheck_video';
                $video = $wpdb->get_results("SELECT * from $table_name2 where post_id=$i");

                $video_id = esc_attr($video[0]->id);
                $table_name3 = $wpdb->prefix .'vidcheck_claim';
                $claim = $wpdb->get_results("SELECT * from $table_name3 where video_id=$video_id");

                $vidchecks = $wpdb->get_results("SELECT $table_name3.*, $table_name.name, $table_name.id, $table_name.bg_color, $table_name.color
                FROM $table_name3
                LEFT JOIN $table_name
                ON $table_name3.rating_id=$table_name.id
                WHERE $table_name3.video_id=$video_id
                ORDER BY $table_name3.id;");
?>

<style>
.claim_hide{
    display: none;
}
.vid_mark {
    border: 3px solid #004d88 !important;
}
</style>

<div class="entry-content">
<style>
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
    width: 50%;
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
  
  .vidcheck tr {
    display: block;
  }
  
  .vidcheck td {
    display: block;
    width: 100%;
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

</style>
    

    <p> <?php echo esc_attr($video[0]->created_at); ?> </p>
    <input type="hidden" name="video_slug" id="video_slug" value = "<?php echo esc_attr($video[0]->url); ?>">


    <table width="100%" class="vidcheck form-table">
        <tr style="background-color: #e8e8e8;border: 0;">
            <th  style="border: 0;">
                <p>Title: <?php echo esc_attr($video[0]->title); ?></p>

                <small>  <img style="display: inline-block; opacity: 1; margin-bottom: -6px;" src="<?php echo esc_url(plugins_url( '' , __FILE__ )); ?>/inc/icons/clock.png" width="20px" height="20px">
                            
                             <?php 
                                    $hours = floor(esc_attr($video[0]->total_duration) / 3600);
                                    $mins = floor(esc_attr($video[0]->total_duration) / 60 % 60);
                                    $secs = floor(esc_attr($video[0]->total_duration) % 60);
                                    $total_duration = $hours.": ".$mins.": ".$secs;
                             ?>
                             
                             <p style="display: inline-block;"> <?php echo esc_attr($total_duration); ?> </php>
                              </p></small><br>
               <small style="display: inline-block;">&#x2924;<a href="<?php echo esc_attr($video[0]->url); ?>" target="_blank"> View Original Source</a><small>
            </th>
            <th style="border: 0;">
                <p><?php echo esc_attr(count($claim)) ?></php> Claims in Total</span><br>
                        
                        
                        <?php 

                           
                            $ratin = [];

                            for($j=0; $j<count($vidchecks); $j++){
                                array_push($ratin,(int)$vidchecks[$j]->rating_id);
                            }

                            $ratin = array_keys(array_flip($ratin));

                            

                            for($i=0; $i<count($ratin); $i++){
                               
                                $rat_id = (int)$ratin[$i];
                                $vid_id = (int)esc_attr($video[0]->id);
                                $count = $wpdb->get_results("SELECT COUNT(id) as count
                                            FROM $table_name3
                                            WHERE $table_name3.rating_id=$rat_id and $table_name3.video_id=$vid_id
                                            ");

                                    for($kk=0; $kk<count($vidchecks); $kk++){
                                        if($vidchecks[$kk]->rating_id == $rat_id){
                                            $color = $vidchecks[$kk]->color;
                                            $bg_color = $vidchecks[$kk]->bg_color;
                                            break;
                                        }
                                    }
                                ?>  

                                

                                    <p style="color:<?php echo esc_attr($color); ?> !important;margin: 0 0 0 0; background-color: <?php echo esc_attr($bg_color); ?>"> <?php echo esc_attr($count[0]->count); ?> <?php echo esc_attr($vidchecks[$i]->name); ?></p>
                                <?php
                            }

                    ?>

            </th>

        </tr>
        <tr>
            <td colspan="2">        
               <p><?php echo esc_html($video[0]->summary) ?> </p>
            </td>
        </tr>

    </table>

    <table width="100%"  class="vidcheck">
            <tr>
                            <td style="vertical-align:top; border-top: 1px solid #f0f0f000; border-left: 1px solid #f0f0f000; border-bottom: 1px solid #f0f0f000;">            
                            <div class="plyr__video-embed " id="player">
                                            <iframe  id="video_player_iframe" allowfullscreen allowtransparency allow="autoplay" ></iframe>
                                        </div>

                                        <?php 
                                            $total_mints = (int)esc_attr($video[0]->total_duration);
                                            $total_sec =  esc_attr($video[0]->total_duration);
                                            $timers = [];
                                         
                                        for($i=0; $i<count($vidchecks); $i++){
                                       
                                           $start = array_map('intval', explode(':', $vidchecks[$i]->start_time ));
                                           $start_time = $start[0]*3660+$start[1]*60+$start[2];
                                           $end = array_map('intval', explode(':', $vidchecks[$i]->end_time ));
                                           $end_time = $end[0]*3660+$end[1]*60+$end[2];
                                           
                                           $width=round(($end_time-$start_time)/$total_sec*100);

                                           $timers[$i]['start'] = $start_time;
                                           $timers[$i]['end'] = $end_time;
                                           $timers[$i]['bg_color'] =$vidchecks[$i]->bg_color;



                                                ?>



                                            <?php


                                        }
                                       
                                             $final_timers = [];
                                             $size = 0;
                                             
                                            for($i=0; $i<count($timers); $i++){

                                                if($i==0){
                                                    if($timers[$i]['start'] != 0){
                                                        $final_timers[$size]['start'] = 0;
                                                        $final_timers[$size]['end'] = $timers[$i]['start'];
                                                        $final_timers[$size]['bg_color'] = "#ffffff";
                                                        $final_timers[$size]['value'] = 999;
                                                        $width=round(($final_timers[$size]['end']-$final_timers[$size]['start'])/$total_sec*100);
                                                            $final_timers[$size]['width'] = $width;
                                                        $size++;
                                                        $final_timers[$size]['start'] = $timers[$i]['start'];
                                                        $final_timers[$size]['end'] = $timers[$i]['end'];
                                                        $final_timers[$size]['bg_color'] = $timers[$i]['bg_color'];
                                                         $final_timers[$size]['value'] = $i;
                                                        $width=round(($final_timers[$size]['end']-$final_timers[$size]['start'])/$total_sec*100);
                                                            $final_timers[$size]['width'] = $width;
                                                        $size++;
                                                    }
                                                    if($timers[$i]['start'] == 0){
                                                        $final_timers[$size]['start'] = $timers[$i]['start'];
                                                        $final_timers[$size]['end'] = $timers[$i]['end'];
                                                        $final_timers[$size]['bg_color'] =  $timers[$i]['bg_color'];
                                                         $final_timers[$size]['value'] = $i;
                                                        
                                                        $width=round(($final_timers[$size]['end']-$final_timers[$size]['start'])/$total_sec*100);
                                                            $final_timers[$size]['width'] = $width;
                                                            $final_timers[$size]['index'] = $width;
                                                        $size++;
                                                    
                                                    }
                                                    
                                                    if(count($timers) == 1){
                                                        if($timers[$i]['end'] != $total_sec){
                                                            $final_timers[$size]['start'] = $timers[$i]['end'];
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
                                                
                                                else if($i == count($timers)-1){
                                                    if($timers[$i]['end'] == $total_sec){
                                                        $final_timers[$size]['start'] = $timers[$i]['start'];
                                                        $final_timers[$size]['end'] = $timers[$i]['end'];
                                                        $final_timers[$size]['bg_color'] = $timers[$i]['bg_color'];
                                                         $final_timers[$size]['value'] = $i;
                                                        $width=round(($final_timers[$size]['end']-$final_timers[$size]['start'])/$total_sec*100);
                                                            $final_timers[$size]['width'] = $width;
                                                        $size++;
                                                    }
                                                    else{
                                                        $final_timers[$size]['start'] = $timers[$i-1]['end'];
                                                        $final_timers[$size]['end'] = $timers[$i]['start'];
                                                        $final_timers[$size]['bg_color'] = "#ffffff";
                                                        $final_timers[$size]['value'] = 999;
                                                        $width=round(($final_timers[$size]['end']-$final_timers[$size]['start'])/$total_sec*100);
                                                            $final_timers[$size]['width'] = $width;
                                                        $size++;

                                                        $final_timers[$size]['start'] = $timers[$i]['start'];
                                                        $final_timers[$size]['end'] = $timers[$i]['end'];
                                                        $final_timers[$size]['bg_color'] = $timers[$i]['bg_color'];
                                                         $final_timers[$size]['value'] = $i;
                                                        $width=round(($final_timers[$size]['end']-$final_timers[$size]['start'])/$total_sec*100);
                                                            $final_timers[$size]['width'] = $width;
                                                        $size++;

                                                        
                                                        $final_timers[$size]['start'] = $timers[$i]['end'];
                                                        $final_timers[$size]['end'] = $total_sec;
                                                        $final_timers[$size]['bg_color'] = "#ffffff";
                                                        $final_timers[$size]['value'] = 999;
                                                        $width=round(($final_timers[$size]['end']-$final_timers[$size]['start'])/$total_sec*100);
                                                            $final_timers[$size]['width'] = $width;
                                                        $size++;

                                                    }
                                                }
                                                else{
                                                        if($timers[$i]['start'] != $timers[$i-1]['end']){
                                                            $final_timers[$size]['start'] = $timers[$i-1]['end']; 
                                                            $final_timers[$size]['end'] = $timers[$i]['start']; 
                                                            $final_timers[$size]['bg_color'] = "#ffffff";
                                                            $final_timers[$size]['value'] = 999;
                                                        $width=round(($final_timers[$size]['end']-$final_timers[$size]['start'])/$total_sec*100);
                                                            $final_timers[$size]['width'] = $width;
                                                            $size++;

                                                            $final_timers[$size]['start'] = $timers[$i]['start']; 
                                                            $final_timers[$size]['end'] = $timers[$i]['end']; 
                                                            $final_timers[$size]['bg_color'] = $timers[$i]['bg_color'];
                                                             $final_timers[$size]['value'] = $i;
                                                        $width=round(($final_timers[$size]['end']-$final_timers[$size]['start'])/$total_sec*100);
                                                            $final_timers[$size]['width'] = $width;
                                                            $size++;
                                                        }
                                                        if($timers[$i]['start'] == $timers[$i-1]['end']){
                                                            $final_timers[$size]['start'] = $timers[$i]['start']; 
                                                            $final_timers[$size]['end'] = $timers[$i]['end']; 
                                                            $final_timers[$size]['bg_color'] = $timers[$i]['bg_color'];
                                                             $final_timers[$size]['value'] = $i;

                                                        $width=round(($final_timers[$size]['end']-$final_timers[$size]['start'])/$total_sec*100);
                                                            $final_timers[$size]['width'] = $width;
                                                            $size++;
                                                        }
                                                        
                                                }                                              
                                                
                                            }   

                                                ?>
                                                <table width="100%"><tr style="display:flex">
                                                <?php
                                            for($i=0; $i<count($final_timers); $i++){
                                                ?>
                                                
                                                <td class="fixed_mark pre_play_<?php echo esc_attr($i) ?>" onclick="vid_change_duration(<?php echo esc_attr($i) ?>, <?php echo esc_attr($final_timers[$i]['start']) ?>)" id="vidcheck_marked_<?php echo esc_attr($final_timers[$i]['value']); ?>"  style="height: 50px; background:<?php echo esc_attr($final_timers[$i]['bg_color']); ?>; width:<?php echo esc_attr($final_timers[$i]['width']); ?>%"></td>


                                                <?php
                                            }
                                            ?>
                                            </tr>
                                            </table>

                                            
                            </td>
                            <td  style="vertical-align:top;">
                                
                                    <?php
                                        for($i=0; $i<count($vidchecks); $i++){
                                    ?>
                                    
                                    <div id="claim_list_<?php echo esc_attr($i) ?>" class="claim_hide claims_data">
                                    <div style=" text-align: center;">
                                        <table width="100%" class="form-table">
                                        <tr style="display:flex">
                                        <td width="10%" style="border-right: 1px solid #f0f0f000;">
                                            <?php 
                                                if($i != 0){
                                            ?>
                                            <a class="claim_list btn-sm" onclick="vid_prev_item(<?php echo esc_attr($i)-1 ?>)">  &#x2770;</a>
                                            <?php 
                                                }
                                            ?>
                                            </td><td width="80%" style="border-right: 1px solid #f0f0f000;">
                                        List of Claims
                                        </td><td width="10%" style="border-left: 1px solid #f0f0f000;">
                                            <?php 
                                                if($i != count($vidchecks)-1){
                                            ?>
                                            <a class="claim_list btn-sm"  onclick="vid_next_item(<?php echo esc_attr($i)+1 ?>)">  &#x2771;</a>
                                            
                                            <?php 
                                                }
                                            ?> 
                                            </td> 
                                            </tr>
                                            </table>
                                    </div> 
                                       
                                        <div>
                                            <b>Fact</b><br>
                                            <p><?php echo esc_attr($vidchecks[$i]->fact) ?></p>
                                        </div>
                                       
                                        <div>
                                            <b>Claim </b><br>
                                            <p><?php echo esc_attr($vidchecks[$i]->claim) ?><br></p>
                                        </div>
                                    </div>
                                    <?php
                                        }                                
                                    ?>
                <br>
                            </td>
            </tr>
    </table>
    <div>
        <?php
            for($i=0; $i<count($vidchecks); $i++){
        ?> 
        <div id="claim_list_des_<?php echo esc_attr($i) ?>" class="claim_hide claims_datades">
                <span  class="vidcheck_title_box1"><h5>Description of Claim</h5></span>
                <p><?php echo esc_attr(str_replace("&nbsp;","<br>", $vidchecks[$i]->description));?></p>
                <p  class="vidcheck_title_box1"><b>Resources</b></p>
                <p  class="vidcheck_title_box1"><b>Review Sources</b></p>
                <?php 


                if($vidchecks[$i]->review_sources != NULL || $vidchecks[$i]->review_sources != 'N;' || $vidchecks[$i]->review_sources != ''){
                    $sources = json_decode($vidchecks[$i]->review_sources);
               
                    if(count($sources) >= 1 ){
                        for($j=0; $j<count($sources); $j++){
                            ?>
                               <p>-> <?php echo esc_attr($sources[$j]->desc); ?>
                               <a href="<?php echo esc_attr($sources[$j]->title);?>">
                               <?php echo esc_attr($sources[$j]->title);?>    </a></p> 
                             <?php
                         }
                    }
                }
                else{
                    ?>
                        <p>- No Review Sources Available</p>
                    <?php
                }
               
                             

                ?>
            </div>
        <?php 
            }
        ?> 
       
                                 
    
    </div>


</div>


<script>
jQuery(document).ready(function() {
    jQuery('#claim_list_0').removeClass('claim_hide');
    jQuery('#claim_list_des_0').removeClass('claim_hide');
    jQuery('.fixed_mark').removeClass('vid_mark');
    jQuery('#vidcheck_marked_0').addClass('vid_mark');

    var time = 0;
    vid_videoload(time);

});

function vid_videoload(time){
    
            var url1 = jQuery("#video_slug").val();
                console.log(url1);                  
                                var regexp = /(ftp|http|https):\/\/(\w+:{0,1}\w*@)?(\S+)(:[0-9]+)?(\/|\/([\w#!:.?+=&%@!\-\/]))?/
                        if(regexp.test(url1) == true){
                            jQuery('.vid_check_column6').removeClass('divhide'); 
                            jQuery('.url_warning').addClass('divhide');
                          

                            var url = url1+"?origin=https://plyr.io&amp;iv_load_policy=3&amp;modestbranding=1&amp;playsinline=1&amp;showinfo=0&amp;rel=0&amp;enablejsapi=1";
                            jQuery('#video_player_iframe').attr('src',url1); 
          
               const options = {
                   autoplay: false,
                   playsinline: true,
                   clickToPlay: false,
                   controls: [ 'progress','pip','play'],
                   debug: true,
                   loop: {
                       active: true
                   }
     
                }
                    videoCont = new Plyr('#player', options);
                    videoCont.play();
                }
}

function vid_change_duration(count, time){
    //alert(time);
    //vid_videoload(time);
    videoCont.currentTime = time;
    videoCont.muted = false;

    videoCont.play();
    jQuery('.fixed_mark').removeClass('vid_mark');
    jQuery('.pre_play_'+count).addClass('vid_mark');
    videoCont.play();
    

}
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

