<?php

require_once '../config/config.php';


		
	     

?>

<html>
<head>
<script>
function validateForm() {
    var x = document.forms["myForm"]["videotitle"].value;
    if (x == null || x == "") {
        alert("Video Title must be filled out");
        return false;
    }

	 var x = document.forms["myForm"]["videourl"].value;
    if (x == null || x == "") {
        alert("Video Url must be filled out");
        return false;
    }
}
</script>

<style type="text/css">
  form {
  text-align: center;
   }

 

  </style>
</head>
<body>


 
<body>



<br><br><br><br>

<form name="myForm" action="previewvideo.php" onsubmit="return validateForm()" method="post">


VIDEO TITLE: <br><input type="text" name="videotitle"  size="30"><br><br>
VIDEO  URL  :  <br> <input type="text" name="videourl"  size="60"><br><br>

<input type="submit" value="Submit">



</form>

</body>
</html>
