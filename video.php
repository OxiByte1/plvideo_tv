<?php
if(isset ($_GET['video_id'])){
	$video_id = $_GET['video_id'];
	$title = $_GET['title'];
}

echo '
<!DOCTYPE html>
<html>
    <head>
        <meta charset="utf-8">
		<meta name="viewport" content="width=device-width">
        <title>'.$title.'</title>
    </head>
	<style>
	*{
		font-size: 25px;
	}
	.app{
		text-align: center;
		width: 70%;
		margin: 0 auto;
	}
	</style>
    <body>
        <div class="app">
			<form style="padding-bottom: 2%;"method="get" action="index.php">
				<input style="width:50%" type="text" name="q" placeholder="Введите название фильма..."/>
				<input style="width:auto" type="submit" value="Найти" />
			</form>';
	$video = json_decode(file_get_contents('http://api.g1.plvideo.ru/v1/videos/'.$video_id.'?Aud=18'),true);
		
	if(array_key_exists('2160p',$video['item']['profiles'])){
		$url = $video['item']['profiles']['2160p']['hls'];
		$q = 2160;
	}else if(array_key_exists('1440p',$video['item']['profiles'])){
		$url = $video['item']['profiles']['1440p']['hls'];
		$q = 1440;
	}else if(array_key_exists('1080p',$video['item']['profiles'])){
		$url = $video['item']['profiles']['1080p']['hls'];
		$q = 1080;
	}else if(array_key_exists('720p',$video['item']['profiles'])){
		$url = $video['item']['profiles']['720p']['hls'];
		$q = 720;
	}else if(array_key_exists('480p',$video['item']['profiles'])){
		$url = $video['item']['profiles']['480p']['hls'];
		$q = 480;
	}else{
		echo '<h1>У этого фильма «'.$title.'» Слишком низкое качество, рекомендуем выбрать другое!</h1>';
		//echo '<h1>'.$title.' - '.$q.'</h1>';
	}
			
			
	if(isset ($url)){
		echo '<h1>'.$title.' - '.$q.'</h1>';
		//echo '<video src="'.str_replace('vod.','vod-dl.',$url).'" poster="'.$video["item"]["cover"]["paths"]["original"]["src"].'" width="100%" controls > </video>';
		echo '<video src="'.$url.'" poster="'.$video["item"]["cover"]["paths"]["original"]["src"].'" width="100%" controls > </video>';
	}
	echo '<a href="javascript:history.back()">Вернуться назад</a>';
	//echo '<h1>'.$videos['items'][0]['title'].'</h1>';
	echo '</div>';		
echo '</body></html>';