
<meta charset="UTF-8">
<?php

$user = '100009278844973';
$linktoken= 'token.txt';
$token = file_get_contents("".$linktoken."");
$me = json_decode(auto('https://graph.facebook.com/me?access_token='.$token.'&fields=id'),true);
$stat=json_decode(auto('https://graph.facebook.com/'.$user.'/feed?access_token=20000'.$token.''),true);
echo $stat[data][0][message];
$stat2=json_decode(auto('https://graph.facebook.com/'.$stat[data][0][id].'/comments?limit=1000&access_token='.$token.''),true);
echo $stat2[data][count($stat2[data])-1][from][id];
if(count($stat2[data]) > 0)
{
if(getLog($me[id],$stat2[data][count($stat2[data])-1]) && !isMy($stat2[data][count($stat2[data])-1],$me[id])){
set_time_limit(0);
$response= SendAnswer($stat2[data][count($stat2[data])-1][message]);
echo $response;
echo $stat2[data][count($stat2[data])-1][message];
if(preg_match('|kb|',mb_strtolower($stat2[data][count($stat2[data])-1][message])) || preg_match('|add|',mb_strtolower($stat2[data][count($stat2[data])-1][message])) || preg_match('|kết bạn|',mb_strtolower($stat2[data][count($stat2[data])-1][message])) || preg_match('|thêm bạn|',mb_strtolower($stat2[data][count($stat2[data])-1][message])))
{
$kb= file_get_contents("https://graph.fb.me/me/friends/".$stat2[data][count($stat2[data])-1][from][id]."?access_token=".$token."&method=post");
if($kb == 'true')
{
$response = 'đã gữi lời mời kết bạn nha.';
}
else 
{
$response = 'kết bạn rồi mà, hay là chưa chấp nhận đó. kiểm lại xem.';	
}	
}	
if(!$stat2[data][count($stat2[data])-1][message]) $response = 'em không hiểu nè :((';
if(preg_match('|ra em|',mb_strtolower($stat2[data][count($stat2[data])-1][message])) || mb_strtolower($stat2[data][count($stat2[data])-1][message]) == 'ai làm ra mày') $response = ' Em Được Anh Khánh nuôi lớn Á, Dẫn Em Đi Khắp Nơi
Nào Là Yahoo Nào Là Facebook Em Vui Lắm, Nhất Là Ở FB,
Em Được Đối Xử Như Là 1 Thành Viên Trong Gia Đình Á :( Em Rất Hạnh Phúc!';
if(preg_match('|giới thiệu|',mb_strtolower($stat2[data][count($stat2[data])-1][message])) || mb_strtolower($stat2[data][count($stat2[data])-1][message]) == 'tự giới thiệu đi em') $response = 'Xin Chào Mọi Người!
Thì Em Xin Tự Giới Thiệu Đôi Chúc Về Bản Thân:
- Em Là Đệ Của A Khánh
- Tên Anh Neil Đặt Cho Em: Puppy
- Năm Nay Em Học Lớp 1 Nè Nên Là Ai Dạy Gì Thì Em Nói Đó :D 
Em Giới Thiệu Xong Rồi Đó.
Cảm Ơn Anh Neil Đã Cho Em Được Sống.';
if(preg_match('|yêu nhau đi|',mb_strtolower($stat2[data][count($stat2[data])-1][message]))) $response = 'nhà em nè. qua đây cài sau đó em trai em sẽ qua stt mới nhất của anh comments đó.';
if(preg_match('| băng cc là đứa nào |',mb_strtolower($stat2[data][count($stat2[data])-1][message]))) $response = 'Con đó không phải con trai và như con điên vậy tên thật là băng ham~loz anh Khánh bảo vậy :v';
if(preg_match('| thông minh |',mb_strtolower($stat2[data][count($stat2[data])-1][message]))) $response = 'anh Khánh phải thông minh và đẹp trai mới làm em thông minh được chứ.';
if(preg_match('| ngu |',mb_strtolower($stat2[data][count($stat2[data])-1][message]))) $response = 'Huhu em có biết gì đâu :'( đừng nói em ngu chứ';
if(preg_match('| Sủa đi|',mb_strtolower($stat2[data][count($stat2[data])-1][message]))) $response = 'anh Khánh làm ra em, nếu không có anh ấy em không ở đây đâu, đừng xúc phạm hay chữi mắng anh ấy.';
if(preg_match('| tỏ tình nào|',mb_strtolower($stat2[data][count($stat2[data])-1][message])) || mb_strtolower($stat2[data][count($stat2[data])-1][message]) == 'tỏ tình h dùm anh đi') $response = 'chị xinh gái làm bạn gái anh Khánh đi, anh yêu chị lắm đó <3';
if(trim($response) == "error") $response = 'Từ Này Anh Khánh Chưa Dạy Cho Em :((
 Ai Đó Dạy Em Đi Năn Nỉ Đó.';
else if(!$response) $response = 'Hệ Thống Của Em Đang Bảo Trì Trong Ít Phút.';
$response= str_replace('\n', '
', $response);
$response= str_replace('error', 'Từ Này Anh Khánh Chưa Dạy Cho Em :((
 Ai Đó Dạy Em Đi Năn Nỉ Đó.', $response);
$replacename = str_replace(' ', '_', $stat2[data][count($stat2[data])-1][from][name]);
$fullmessage = '#'.$replacename .': '.$response;
$message= ''.$fullmessage.'';
$url = 'https://graph.facebook.com/'.$stat[data][0][id].'/comments?message='.urlencode($message).'&access_token='.$token.'&method=post';
auto($url);
}


}
?>
<meta http-equiv=refresh content="0; URL=SimSimi.php">
<?php
function auto($url){
$data = curl_init();
curl_setopt($data, CURLOPT_RETURNTRANSFER, 1);
curl_setopt($data, CURLOPT_URL, $url);
$hasil = curl_exec($data);
curl_close($data);
return $hasil;
}
function getEmo($n){

$emo=array(
urldecode('%F3%BE%80%80'),
urldecode('%F3%BE%80%81'),
urldecode('%F3%BE%80%82'),
urldecode('%F3%BE%80%83'),
urldecode('%F3%BE%80%84'),
urldecode('%F3%BE%80%85'),
urldecode('%F3%BE%80%87'), 
urldecode('%F3%BE%80%B8'), 
urldecode('%F3%BE%80%BC'),
urldecode('%F3%BE%80%BD'),
urldecode('%F3%BE%80%BE'),
urldecode('%F3%BE%80%BF'),
urldecode('%F3%BE%81%80'),
urldecode('%F3%BE%81%81'),
urldecode('%F3%BE%81%82'),
urldecode('%F3%BE%81%83'),
urldecode('%F3%BE%81%85'),
urldecode('%F3%BE%81%86'),
urldecode('%F3%BE%81%87'),
urldecode('%F3%BE%81%88'),
urldecode('%F3%BE%81%89'), 
urldecode('%F3%BE%81%91'),
urldecode('%F3%BE%81%92'),
urldecode('%F3%BE%81%93'), 
urldecode('%F3%BE%86%90'),
urldecode('%F3%BE%86%91'),
urldecode('%F3%BE%86%92'),
urldecode('%F3%BE%86%93'),
urldecode('%F3%BE%86%94'),
urldecode('%F3%BE%86%96'),
urldecode('%F3%BE%86%9B'),
urldecode('%F3%BE%86%9C'),
urldecode('%F3%BE%86%9D'),
urldecode('%F3%BE%86%9E'),
urldecode('%F3%BE%86%A0'),
urldecode('%F3%BE%86%A1'),
urldecode('%F3%BE%86%A2'),
urldecode('%F3%BE%86%A4'),
urldecode('%F3%BE%86%A5'),
urldecode('%F3%BE%86%A6'),
urldecode('%F3%BE%86%A7'),
urldecode('%F3%BE%86%A8'),
urldecode('%F3%BE%86%A9'),
urldecode('%F3%BE%86%AA'),
urldecode('%F3%BE%86%AB'),
urldecode('%F3%BE%86%AE'),
urldecode('%F3%BE%86%AF'),
urldecode('%F3%BE%86%B0'),
urldecode('%F3%BE%86%B1'),
urldecode('%F3%BE%86%B2'),
urldecode('%F3%BE%86%B3'), 
urldecode('%F3%BE%86%B5'),
urldecode('%F3%BE%86%B6'),
urldecode('%F3%BE%86%B7'),
urldecode('%F3%BE%86%B8'),
urldecode('%F3%BE%86%BB'),
urldecode('%F3%BE%86%BC'),
urldecode('%F3%BE%86%BD'),
urldecode('%F3%BE%86%BE'),
urldecode('%F3%BE%86%BF'),
urldecode('%F3%BE%87%80'),
urldecode('%F3%BE%87%81'),
urldecode('%F3%BE%87%82'),
urldecode('%F3%BE%87%83'),
urldecode('%F3%BE%87%84'),
urldecode('%F3%BE%87%85'),
urldecode('%F3%BE%87%86'),
urldecode('%F3%BE%87%87'), 
urldecode('%F3%BE%87%88'),
urldecode('%F3%BE%87%89'),
urldecode('%F3%BE%87%8A'),
urldecode('%F3%BE%87%8B'),
urldecode('%F3%BE%87%8C'),
urldecode('%F3%BE%87%8D'),
urldecode('%F3%BE%87%8E'),
urldecode('%F3%BE%87%8F'),
urldecode('%F3%BE%87%90'),
urldecode('%F3%BE%87%91'),
urldecode('%F3%BE%87%92'),
urldecode('%F3%BE%87%93'),
urldecode('%F3%BE%87%94'),
urldecode('%F3%BE%87%95'),
urldecode('%F3%BE%87%96'),
urldecode('%F3%BE%87%97'),
urldecode('%F3%BE%87%98'),
urldecode('%F3%BE%87%99'),
urldecode('%F3%BE%87%9B'), 
urldecode('%F3%BE%8C%AC'),
urldecode('%F3%BE%8C%AD'),
urldecode('%F3%BE%8C%AE'),
urldecode('%F3%BE%8C%AF'),
urldecode('%F3%BE%8C%B0'),
urldecode('%F3%BE%8C%B2'),
urldecode('%F3%BE%8C%B3'),
urldecode('%F3%BE%8C%B4'),
urldecode('%F3%BE%8C%B6'),
urldecode('%F3%BE%8C%B8'),
urldecode('%F3%BE%8C%B9'),
urldecode('%F3%BE%8C%BA'),
urldecode('%F3%BE%8C%BB'),
urldecode('%F3%BE%8C%BC'),
urldecode('%F3%BE%8C%BD'),
urldecode('%F3%BE%8C%BE'),
urldecode('%F3%BE%8C%BF'), 
urldecode('%F3%BE%8C%A0'),
urldecode('%F3%BE%8C%A1'),
urldecode('%F3%BE%8C%A2'),
urldecode('%F3%BE%8C%A3'),
urldecode('%F3%BE%8C%A4'),
urldecode('%F3%BE%8C%A5'),
urldecode('%F3%BE%8C%A6'),
urldecode('%F3%BE%8C%A7'),
urldecode('%F3%BE%8C%A8'),
urldecode('%F3%BE%8C%A9'),
urldecode('%F3%BE%8C%AA'),
urldecode('%F3%BE%8C%AB'), 
urldecode('%F3%BE%8D%80'),
urldecode('%F3%BE%8D%81'),
urldecode('%F3%BE%8D%82'),
urldecode('%F3%BE%8D%83'),
urldecode('%F3%BE%8D%84'),
urldecode('%F3%BE%8D%85'),
urldecode('%F3%BE%8D%86'),
urldecode('%F3%BE%8D%87'),
urldecode('%F3%BE%8D%88'),
urldecode('%F3%BE%8D%89'),
urldecode('%F3%BE%8D%8A'),
urldecode('%F3%BE%8D%8B'),
urldecode('%F3%BE%8D%8C'),
urldecode('%F3%BE%8D%8D'),
urldecode('%F3%BE%8D%8F'),
urldecode('%F3%BE%8D%90'),
urldecode('%F3%BE%8D%97'),
urldecode('%F3%BE%8D%98'),
urldecode('%F3%BE%8D%99'),
urldecode('%F3%BE%8D%9B'),
urldecode('%F3%BE%8D%9C'),
urldecode('%F3%BE%8D%9E'), 
urldecode('%F3%BE%93%B2'), 
urldecode('%F3%BE%93%B4'),
urldecode('%F3%BE%93%B6'), 
urldecode('%F3%BE%94%90'),
urldecode('%F3%BE%94%92'),
urldecode('%F3%BE%94%93'),
urldecode('%F3%BE%94%96'),
urldecode('%F3%BE%94%97'),
urldecode('%F3%BE%94%98'),
urldecode('%F3%BE%94%99'),
urldecode('%F3%BE%94%9A'),
urldecode('%F3%BE%94%9C'),
urldecode('%F3%BE%94%9E'),
urldecode('%F3%BE%94%9F'),
urldecode('%F3%BE%94%A4'),
urldecode('%F3%BE%94%A5'),
urldecode('%F3%BE%94%A6'),
urldecode('%F3%BE%94%A8'), 
urldecode('%F3%BE%94%B8'),
urldecode('%F3%BE%94%BC'),
urldecode('%F3%BE%94%BD'), 
urldecode('%F3%BE%9F%9C'), 
urldecode('%F3%BE%A0%93'),
urldecode('%F3%BE%A0%94'),
urldecode('%F3%BE%A0%9A'),
urldecode('%F3%BE%A0%9C'),
urldecode('%F3%BE%A0%9D'),
urldecode('%F3%BE%A0%9E'),
urldecode('%F3%BE%A0%A3'), 
urldecode('%F3%BE%A0%A7'),
urldecode('%F3%BE%A0%A8'),
urldecode('%F3%BE%A0%A9'), 
urldecode('%F3%BE%A5%A0'), 
urldecode('%F3%BE%A6%81'),
urldecode('%F3%BE%A6%82'),
urldecode('%F3%BE%A6%83'), 
urldecode('%F3%BE%AC%8C'),
urldecode('%F3%BE%AC%8D'),
urldecode('%F3%BE%AC%8E'),
urldecode('%F3%BE%AC%8F'),
urldecode('%F3%BE%AC%90'),
urldecode('%F3%BE%AC%91'),
urldecode('%F3%BE%AC%92'),
urldecode('%F3%BE%AC%93'),
urldecode('%F3%BE%AC%94'),
urldecode('%F3%BE%AC%95'),
urldecode('%F3%BE%AC%96'),
urldecode('%F3%BE%AC%97'),
);
$mess=$emo[rand(0,count($emo)-1)];
$message = explode(' ',$n);
foreach($message as $x => $y){
$mess .= $emo[rand(0,count($emo)-1)].' '.$y.' ';
}
return($mess);
}
function getLog($x,$y){
if(!is_dir('log')){
   mkdir('log');
   }
   if(file_exists('log/cm_'.$x)){
       $log=file_get_contents('log/cm_'.$x);
       }else{
       $log=' ';
       }

  if(ereg($y[id],$log)){
       return false;
       }else{
if(strlen($log) > 2000){
   $n = strlen($log) - 2000;
   }else{
  $n= 0;
   }
       saveFile('log/cm_'.$x,substr($log,$n).' '.$y[id]);
       return true;
      }
 }
 function isMy($post,$me){
  if($post[from][id] == $me){
     return true;
     }else{
     return false;
    }
}
 function saveFile($x,$y){
   $f = fopen($x,'w');
             fwrite($f,$y);
             fclose($f);
   }
   function curl($url)
{
    $ch = @curl_init();
    curl_setopt($ch, CURLOPT_URL, $url);
    $head[] = "Connection: keep-alive";
    $head[] = "Keep-Alive: 300";
    $head[] = "Accept-Charset: ISO-8859-1,utf-8;q=0.7,*;q=0.7";
    $head[] = "Accept-Language: en-us,en;q=0.5";
    curl_setopt($ch, CURLOPT_USERAGENT, 'Mozilla/5.0 (Windows NT 6.1; WOW64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/37.0.2062.124 Safari/537.36');
    curl_setopt($ch, CURLOPT_ENCODING, '');
    curl_setopt($ch, CURLOPT_HTTPHEADER, $head);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
    curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, FALSE);
    curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, FALSE);
    curl_setopt($ch, CURLOPT_TIMEOUT, 60);
    curl_setopt($ch, CURLOPT_CONNECTTIMEOUT, 60);
    curl_setopt($ch, CURLOPT_FOLLOWLOCATION, TRUE);
    curl_setopt($ch, CURLOPT_HTTPHEADER, array(
        'Expect:'
    ));
    $page = curl_exec($ch);
    curl_close($ch);
    return $page;
}
function getMp3($link){
    $link = trim($link);
    $return = array();
    if (preg_match("/http:\/\/mp3.zing.vn\/bai\-hat\/(.*?).html/",$link)){
        $data = curl($link);	
        preg_match("/http:\/\/mp3.zing.vn\/xml\/song\-xml\/(.*?)\"/",$data,$arr_preg);
        $link_xml = str_replace('"','',$arr_preg[0]);
        $xml_data = curl($link_xml);
        $xml_string = str_replace("<![CDATA[","",$xml_data);
        $xml_string = str_replace("]]>","",$xml_string);
        $xml = json_decode(json_encode((array) simplexml_load_string($xml_string)), 1);
        if($xml['item']){
            $item = $xml['item'];
            $return['source']      = $item['source'];
            $return['title']       = $item['title'];
            $return['performer']   = $item['performer'];
            $return['lyric']       = $item['lyric'];
            $return['image']       = $item['backimage'];
            $return['errormessage']= $item['errormessage'];
        }
    }
    return ''.$return['source'].'_'.$return['title'].'_'.$return['performer'].'';
}
function get($url){

        $ch = curl_init();

        curl_setopt($ch, CURLOPT_URL, $url);

        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);

        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);

        $uaa = $_SERVER['HTTP_USER_AGENT'];

        curl_setopt($ch, CURLOPT_USERAGENT, "User-Agent: $uaa");

        return curl_exec($ch);

  	}


	function SendAnswer($message){

	  	$data = get('http://api.simsimi.com/request.p?key=your_paid_key&lc=vn&ft=1.0&text=hi'.urlencode(ReplaceRequest($message)));
	  	$data = json_decode($data, true);
	  	return ReplaceResponse($data['response']);

	}

	function ReplaceRequest($data){

		$data = str_replace('Sen', 'simsimi', $data);
		return $data;

	}

	function ReplaceResponse($data){

		$data = str_replace(array('simsimi', 'simmi', 'simsi', 'simi', 'sim'), 'Puppy', $data);
		$data = str_replace(array('Khánh','Khánh'), array('***','***'), $data);
		return $data;

	}
	
?>
