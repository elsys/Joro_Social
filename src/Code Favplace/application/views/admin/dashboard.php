<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
	<title>Favplace.BG</title>
	<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
	<meta name="viewport" content="initial-scale=1.0, user-scalable=no" />
	<base href="<?=site_url();?>"></base>
	<link rel="shortcut icon" href="favicon.ico" type="image/x-icon" />
	<link rel="stylesheet" href="sources/css/admin.css" type="text/css" media="screen" /> 
	<link rel="stylesheet" href="sources/css/flick/jquery-ui-187custom.css" type="text/css" media="screen" />
	<script type="text/javascript" src="sources/js/jquery142.js"></script>
	<script type="text/javascript" src="sources/js/jquery-ui-187custom.js"></script>
	<script type="text/javascript" src="sources/js/formValidation.js"></script>
	<script type="text/javascript" src="http://maps.google.com/maps/api/js?sensor=false"></script>
	<script type="text/javascript" src="sources/js/gmaps.js"></script>
	<script type="text/javascript" src="sources/js/combined.js"></script>
</head>
<body>
	<div id="fade"></div> 

	<div class="topline"></div>

	<div class="header">
		<div class="wrap">
			<ul id="nav">
				<li><a href="/admin" id="logo" title="Начало">Favplace - Админ панел</a></li> 
				<li><a href="catalogue">Места</a></li>
				<li><a href="events">Събития</a></li>
				<li><a href="help">Потребители</a></li>
			</ul>	 
            <div class="profile-nav">
				<a class="minimized">
					<img class="avatar" src="<?=profile_avatar($this->profile_id);?>" alt="" />
					<span class="username"><?=$this->username;?></span>
					<img class="icon" src="sources/images/facebook.png" alt="" />
					<span class="arrClose" id="dd-arrow"></span>
				</a>
				<ul id="dropdown">
					<li><a href="profile">??????</a></li>
					<li><a href="friends/<?=$this->username;?>">????????</a></li>
					<li><a href="settings">?????????</a></li>
					<li><a href="signout">?????</a></li>
				</ul>
			</div>	
		 </div>
	</div><!-- end header -->
	
	<div class="moderation">
		<div class="wrap">
			<ul class="modnav" style="float: left">
				<!-- icons will be added -->
				<li><a href="#">Статистика</a></li>
				<li><a href="#">Коментари <span class="notification">24</span></a></li>
				<li><a href="#">Визия</a></li>
				<li><a href="#">Меню</a></li>
			</ul>
			
			<ul class="modnav">
				<li><a href="#">Редактирай:</a></li>
				<li><a href="#">Информация</a></li>
				<li><a href="#">Визия</a></li>
				<li><a href="#">Меню</a></li>
			</ul>
			
			<div class="clear"></div>
		</div>
	</div>

	<!--<iframe src="http://localhost/favplace" width="100%" height="100%"></iframe>-->
	
	<div class="wrap">
		qwewqe
	</div><!-- end of wrap -->