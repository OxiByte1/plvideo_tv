<?php
set_time_limit(600);
$q = 2016;

if(isset ($_GET['q'])){
	$q = strip_tags($_GET['q']);
}
$p = 0;
if(isset ($_GET['p'])){
	$p = strip_tags($_GET['p']);
}
$page = null;
echo '
<!DOCTYPE html>
<html>
    <head>
        <meta charset="utf-8">
		<meta name="viewport" content="width=device-width">
        <title>Поиск фильмов</title>
    </head>
	<style>
	*{
		font-size: 25px;
	}
	a{text-decoration: none;}
	.app{
		text-align: center;
		width: 70%;
		margin: 0 auto;
	}
	.link{
		text-align: left;
	}
	</style>
    <body>
        <div class="app">
			<form style="padding-bottom: 2%;"method="get" action="index.php">
				<input style="width:50%" type="text" name="q" placeholder="Введите название фильма..."/>
				<input style="width:auto" type="submit" value="Найти" />
			</form>';
if(isset ($q)){
	$videos = json_decode(file_get_contents('http://api.g1.plvideo.ru/v1/videos?Query='.urlencode($q).'&CategoryId=5zhdKEYvMg00&From='.$p.'&Size=50&Aud=18&DurFrom=3600'),true);
	$i = 1;
	foreach($videos['items'] as $video_id){
		$page .= '<div class="link"><hr>'.$i++.'. <a href="./video.php?video_id='.$video_id['id'].'&title='.urlencode($video_id['title'].' - '.$q).'"><b>'.$video_id['title'].' - '.$q.'</b></a></div>';
	}
	if(isset($page)){
		echo $page;
	}
	echo '<hr>';
	$page = 0;
	while($page <= 99){
		echo '<a href="./index.php?q='.$q.'&p='.$page.'"><b>'.$page.'</b></a> ';
		$page++;
	}
	//var_dump($videos['pagination']['total']);
}
echo '<hr></div>';		
echo '</body></html>';