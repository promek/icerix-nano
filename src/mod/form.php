<?php

$to      = 'yourname@yourmail.xxx'; 
$from    = 'admin@yourserver.xxx';
$subject = 'the subject';


function getIP () {
  if ($_SERVER['REMOTE_ADDR']<>'127.0.0.1') {
    return $_SERVER['REMOTE_ADDR'];
  }else {
    return $_SERVER['HTTP_X_FORWARDED_FOR'];
  }
}

if (empty($_POST)) {
  $token=md5(date("Y-m-d H:i:s")); //token generate, csrf protection

  $_SESSION["token"] = $token;
  $hidden_token = sprintf('<input type="hidden" name="token" value="%s"/>', $token); 
  $submit=False;
  
}else{
  $aForm=$_POST;
  $error='';
  $form=array();
  $cMsg="";
  $submit=True;
  if ((isset($_POST['token'])) and ($_POST['token']== $_SESSION["token"])) {
      if (count($aForm)-1>0){
	  $cKey=array_keys($aForm);
	  echo $cKey;
	  for ($i=0;$i<=count($cKey)-1;$i++){
	      echo $aForm[$cKey[$i]];
	      if (substr($cKey[$i],0,1)=='_') {
		  if ($aForm[$cKey[$i]]=='') {
		      $submit=False;
		      $error=FORMERR;
		      $hidden_token = sprintf('<input type="hidden" name="token" value="%s"/>', $_POST['token']);
		  }
		  $cMsg.=substr($cKey[$i],1,strlen($cKey[$i])).' : '.$aForm[$cKey[$i]].'<br>';
	      }else{
		  $cMsg.=$cKey[$i].' : '.$aForm[$cKey[$i]].'<br>';
	      }
	  }
      }
  }
  
  if ($submit==True) {
    unset($aForm['token']); //unset token
    unset($_SESSION["token"]);
    
    $cMsg.='<br>'.date("d-m-Y H:i:s")." / ".getIP().'<br>';
    $message = $cMsg;
    
    $headers  = "MIME-Version: 1.0\n";
    $headers .= "Content-type: text/html; charset=\"iso-8859-9\"\n";
    $headers .= "X-Priority: 3\n";
    $headers .= "X-MSMail-Priority: Normal\n";
    $headers .= "From: $from \n";
    $headers .= "Reply-To: $from \n";
    $headers .= "X-Mailer: PHP/".phpversion();

    echo $message; // print mail message to display
//    mail($to, $subject, $message, $headers); // to send mail remove remark
  }

}

if (file_exists($html_dir.$url.".".$html_ext)) {
    $sHtml = new RainTPL;
} else {
    cxlog($html_dir.$url.".".$html_ext." not found...");
}

if ($url != 'index') {
    $sHtml->assign( "icerix", $url);
    $sHtml->assign( "error", $error);
    $sHtml->assign( "token", $hidden_token);        
    $sHtml->assign( "submit", $submit);
    echo $sHtml -> draw("index", $return_string = true );
}else{
    cxlog(HTMLCALLERR);
}

?>