<?php

require_once '../config/config.php';


session_start();
if(!isset($_SESSION['mysid'])){
header("location:main_login.php");}

if(!isset($_GET['videoid'])){
header("location:main_login.php");}


$sessionid=$_SESSION['mysid'];
$videoid=$_GET['videoid']; 

$sql="select * from videos where videoid='$videoid'";
$result = mysql_query($sql);
$row = mysql_fetch_array($result);
$videotitle=$row['videotitle'];
$videourl=$row['videourl'];

$sql="select * from sessions where sessionid='$sessionid'";
$result = mysql_query($sql);
$row = mysql_fetch_array($result);
$userid=$row['user_id'];






 $data=array();
 //unset($data);

 $data2=array();

 

 class subtitles_store { 
	public  $subtitleid;
    public $start; 
    public $endl;
	public $text;
} 

$sql="select * from video_subtitles where videoid='$videoid' order by subtitleid";
$result = mysql_query($sql);
$num_rows = mysql_num_rows($result);
while($row = mysql_fetch_array($result))
  {   
    $subtitleid=$row['subtitleid'];
	$start=$row['start'];
	$end=$row['end'];
	$text=$row['text'];

	$subtitleobj=new subtitles_store();
    $subtitleobj->subtitleid = $row['subtitleid'];
	$subtitleobj->start = $row['start'];
    $subtitleobj->endl = $row['end'];
    $subtitleobj->text = $row['text'];
	array_push($data2, $subtitleobj);
     

  $data = array(
		    "videoid" => $videoid,
			"numsubtitles"=>$num_rows,
		    "subtitles"  =>$data2
		 
            );
	 
// echo json_encode($data);

  }




?>




<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.0 Transitional//EN">
<HTML>
 <HEAD>
  <!--script src="http://code.jquery.com/jquery-1.7.1.min.js"></script-->
  <script src="../build/jquery.js"></script>	
  <!--script src="../build/mediaelement.js"></script-->
  <script src="../build/mediaelement-and-player.min.js"></script>
  <script src="testforfiles.js"></script>
  <link rel="stylesheet" href="jquery-3.css" type="text/css" />
  <link rel="stylesheet" href="../build/mediaelementplayer.min.css" />
  
	 <title><?php echo $videotitle; ?></title>
	<meta charset="utf-8" />
 </HEAD>

 <BODY>

 

 <div id="video" >
 <h2>Video Title: <?php echo $videotitle; ?></h2><br>
 
<video id="player1" width="500" height="380">
    <source src="<?php echo $videourl; ?>" type="video/youtube" >
	 <!--track kind="subtitles" src="../media/graphic_design.srt" srclang = "el" /-->
	 

</video>







<span id="time"></span>
<span id="percent"></span>

<br><br>

<div class="container">
 <span id="label"></span>



<br><br>
<br><span id="examplecomframe"></span>

 </div>





<script>

 var timestamps = <?php echo json_encode($data); ?>;


var last = 0,
now,
old;

function showtime(ltime){
	var timetmp=ltime;
	var hrs = Math.floor(timetmp/3600);
    timetmp = timetmp - 3600 * hrs;
	var mins = Math.floor(timetmp/60);
	timetmp = timetmp - 60 * mins;
	var secs = Math.floor(timetmp);
	var ltimetext = (hrs < 10 ? "0" : "" ) + hrs + ":" 
				 + (mins < 10 ? "0" : "" ) + mins + ":" 
				 + (secs < 10 ? "0" : "" ) + secs;
	return ltimetext;


}

function showsection(t){
	
var text='';
      for(i=0;i<timestamps.numsubtitles; i++){
        if(t >= timestamps.subtitles[i].start && t <= timestamps.subtitles[i].endl){
			 text=timestamps.subtitles[i].text;
			 document.getElementById('label').innerHTML = text;
           } 

		  }

    if (text=='')
    {
	document.getElementById('label').innerHTML = ' ';
    }
      
    };






$('video').mediaelementplayer({
	//framesPerSecond: 20,
	features: ['playpause','progress','current','duration','tracks','volume'],
		
    // Hide controls when playing and mouse is not over the video
    
	
	
	success: function(me, node, player) {
		

		
old=0;
now=0;
 

//time_cuepoints = parseInt(me.duration/interval);

var events = ['loadstart', 'play','pause', 'ended','seeking','volumechange', 'muted'];
		
		
	//me.play();
	me.addEventListener('timeupdate', function() {
       

        //timetext=showtime(me.currentTime);
		now = parseInt(me.currentTime);
		timetext=showtime(me.currentTime);
		durationtext=me.duration;
        //document.getElementById('duration').innerHTML = 'Duration: '+durationtext;
		document.getElementById('time').innerHTML = 'Time : '+ timetext;
		percent=parseInt(me.currentTime/me.duration *100);
		document.getElementById('percent').innerHTML = 'percent : '+ percent;
		
		

        if (now!=old)
        {
		old=now;

		showsection(now);
        }
		

	}, false);

}});





</script>
  



 </BODY>
</HTML>
