<?php
/**
 * EasyPHP: a complete WAMP environement for PHP development & personal
 * web hosting including PHP, Apache, MySQL, PhpMyAdmin, Xdebug...
 * DEVSERVER for PHP development and WEBSERVER for personal web hosting
 * @author   Laurent Abbal <laurent@abbal.com>
 * @link     http://www.easyphp.org
 */

include("functions.inc.php");
$lang = 'en';

// Conf files
$httpdconf = file_get_contents('..\binaries\httpserver\conf\httpd.conf');

// HTTP IP-Port
preg_match('/^ServerName(\s|\t|)(.*):(.*)/m', $httpdconf, $servername);
$http_port = $servername[3];

// Setup local IP
$http_ip_array = array();
$network_ip = getHostByName(trim(getHostName()));
preg_match('/^ServerName(\s|\t|)(.*):(.*)/m', $httpdconf, $http_ip_array);
$http_ip = $http_ip_array[2];
$alert_ipmismatch = 0;
if (strstr($httpdconf, '0.0.0.0')) {
	$httpdconf = str_replace ('0.0.0.0', $network_ip, $httpdconf);
	file_put_contents('..\binaries\httpserver\conf\httpd.conf', $httpdconf);
}
if ($http_ip != $network_ip AND $http_ip != "0.0.0.0") {
	$httpdconf = str_replace ($http_ip, $network_ip, $httpdconf);
	file_put_contents('..\binaries\httpserver\conf\httpd.conf', $httpdconf);
	$alert_ipmismatch = 1;
}

// SERVICE CONTROL
if (isset($_POST['app_service_control'])) {
	exec(urldecode($_POST['app_service_control']));
	sleep(5);
	$redirect = "http://" . $_SERVER['HTTP_HOST'] . $_SERVER['REQUEST_URI'];
	header("Location: " . $redirect);
	exit;
}

// ews.ini
$ewsini = file_get_contents('ews.ini');
if ($_GET['msg'] == "disclaimerok") {
	$ewsini = str_replace('Disclaimer=0', 'Disclaimer=1', $ewsini);
	file_put_contents('ews.ini', $ewsini);
}


// Russell, 2012-11-10: nonce functionality relies on sessions
// Also added a hidden input called nonce in rendered html below
session_start();


// Notifications
include("notification.php"); 
if (@date('Ymd') != $notification['check_date']) {
	$context = stream_context_create(array('http' => array('timeout' => 1)));
	$content = @file_get_contents('http://www.easyphp.org/notifications/notification-webserver.txt', 0, $context);
	if (!empty($content)) {
		$content_array = explode('#', $content);	
		if ($content_array[0] != $notification['date']) {
			$new_content = '<?php $notification = array(\'check_date\'=>\'' . @date('Ymd') . '\',\'date\'=>\'' . $content_array[0] . '\',\'status\'=>\'1\',\'link\'=>\'' . $content_array[1] . '\',\'message\'=>\'' . $content_array[2] . '\'); ?>';
			file_put_contents('notification.php', $new_content);
			$redirect = "http://" . $_SERVER['HTTP_HOST'] . "/home/index.php";
			header("Location: " . $redirect); 
			exit;	
		}
	}
	$new_content = '<?php $notification = array(\'check_date\'=>\'' . @date('Ymd') . '\',\'date\'=>\'' . $notification['date'] . '\',\'status\'=>\'' . $notification['status'] . '\',\'link\'=>\'' . $notification['link'] . '\',\'message\'=>\'' . $notification['message'] . '\'); ?>';
	file_put_contents('notification.php', $new_content);
};
?>
<!DOCTYPE html>
<html lang="en">
	<head>
		<meta charset="utf-8">
		<meta http-equiv="X-UA-Compatible" content="IE=edge">
		<meta name="viewport" content="width=device-width, initial-scale=1">
		<meta name="description" content="">
		<meta name="author" content="">
		<link rel="icon" href="images_easyphp/easyphp_favicon.ico" />

		<title>EasyPHP Webserver</title>

		<!-- Font Awesome CSS -->
		<link rel="stylesheet" href="library/font-awesome/css/font-awesome.min.css">
		
		<!-- Bootstrap core CSS -->
		<link href="library/bootstrap/css/bootstrap.css" rel="stylesheet">

		<!-- Just for debugging purposes. Don't actually copy these 2 lines! -->
		<!--[if lt IE 9]><script src="bootstrap/js/ie8-responsive-file-warning.js"></script><![endif]-->
		<script src="library/bootstrap/js/ie-emulation-modes-warning.js"></script>

		<!-- IE10 viewport hack for Surface/desktop Windows 8 bug -->
		<script src="library/bootstrap/js/ie10-viewport-bug-workaround.js"></script>

		<!-- HTML5 shim and Respond.js IE8 support of HTML5 elements and media queries -->
		<!--[if lt IE 9]>
		<script src="https://oss.maxcdn.com/html5shiv/3.7.2/html5shiv.min.js"></script>
		<script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
		<![endif]-->

		<script>
		function delay() {
		document.getElementById('delay').style.display = "block";
		}
		</script>

		<link rel="stylesheet" href="custom.css" type="text/css" />

	</head>

	<body>

		<!-- Fixed navbar -->
		<div class="navbar navbar-default navbar-fixed-top" role="navigation">
			<div class="container">
				<div class='row'>
					<div class="col-sm-8">
						<a href="index.php"><img src="images/easyphp_webserver.png" width="160" height="30" alt="EasyPHP" border="0" /></a>
					</div>
					<div class="col-sm-4 text-right">
						<a href='index.php?display=quickstart'><button type="button" class="btn btn-xs btn_quickstart">Quick Start</button></a>
						<a href='index.php?zone=settings'><button type="button" class="btn btn-xs btn_settings">Settings</button></a>
						<a href='http://www.easyphp.org/support/easyphp-webserver/' target="_blank"><button type="button" class="btn btn-xs btn_help">Help</button></a>
						<?php
						// Notification
						if ($notification['status'] == 1) {
							?>
							<div class="infobulle_notification_on"><a class="info" href="notification_redirect.php" target="_blank" onclick="setTimeout('history.go(0);',1500)">!<span><?php echo $notification['message']; ?><div>go</div></span></a></div>
							<?php
						} else {
							?>
							<div class="infobulle_notification_off"><a class="info" href="notification_redirect.php" target="_blank">!<span><?php echo $notification['message']; ?><div>go</div></span></a></div>
							<?php
						}
						?>
					</div>
				</div>
			</div>
		</div>
		
		<div class="container">
			<div class="alert alert-danger small" style="width:132px;text-align:center;margin:0px 0px 20px 0px;padding:3px 0px 0px 0px;float:left;">
				<a href="index.php?msg=disclaimer" style="color:white;">disclaimer</a>
			</div>
			
			<br style="clear:both;" />
			<div class="row">
				<div class="col-sm-8 col-sm-offset-2">
				<p class="text-muted"><strong>This is a beta version. You can help us to improve the system by sending feedbacks (bug, code improvement, features, typo, syntax...) by <a href="mailto:easyphpdotorg@gmail.com?Subject=EasyPHP%20Webserver%20Feedback" target="_blank">email</a>.</strong></p>
				</div>
			</div>			
			
		</div>

		<div id="delay">&nbsp;</div>
		
		<?php
		$ewsini_array = array();
		$ewsini_array = explode('Disclaimer=', $ewsini);
		if (($_GET['msg'] == "disclaimer") OR ($ewsini_array[1] != 1)) {
			?>
			<div class="container">
				<div class="row">
					<div class="col-sm-10 col-sm-offset-1">
						<p class="alert alert-danger">
							<?php
							if ($_GET['msg'] == "disclaimer") {
								?>
								<a href="index.php"><button type="button" class="close"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button></a>
								<?php
							} else {
								?>
								<a href="index.php?msg=disclaimerok"><button type="button" class="close"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button></a>
								<?php
							}
							?>
							<strong>DISCLAIMER</strong><br /><br />
							EasyPHP Webserver will never be as secured as a professional hosting service. <strong>Use it at your own risk</strong>.<br />
							<strong>EasyPHP Webserver will not be responsible for any loss or damage of any sort</strong>. Any computer connected to the internet is at risk.<br />
							Use a dedicated computer, remove any personal, sensitive or important data and isolate it from your personal network.<br />
							EasyPHP Webserver must be used occasionally for special occasions (demo, test, presentation...). As soon as you don't need it, stop the servers and tune your firewall and router.<br />
							<strong>If you want to permanently host a website or an application, you have to use a professional hosting service.</strong>
						</p>
					</div>
				</div>
			</div>
			<?php
		}
		

		// Mismatch IP alert 
		if ($alert_ipmismatch == 1) {
			?>
			<div class="container">
				<div class="row">
					<div class="col-sm-6 col-sm-offset-3">
						<p class="alert alert-danger">
						<button type="button" class="close" data-dismiss="alert"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
						<strong>LOCAL NETWORK IP ADDRESS UPDATE</strong><br /><br />
						Your local network IP address changed, you need to <strong>restart your <samp>HTTP SERVER</samp></strong>.
						</p>
					</div>
				</div>
			</div>
			<?php
		}


		if ($_GET['zone'] == 'settings')
		{
			include('inc.settings.php');	
		}
		else
		{
		?>
			<div class="container">

				<?php
				if ($_GET['display'] == 'quickstart') {
					?>
					<div class="row">
						<div class="col-sm-8 col-sm-offset-2">
							<div class="alert alert-warning" role="alert" style="margin-top:0px;color:black;border-color: #fcf8e3;">
							
							<h3 style="margin-top:0px;">QUICK START<a href="index.php"><button type="button" class="close"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button></a></h3>
				
								<dl class="dl-horizontal">
								  <dt style="width:40px"><span class="badge">1</span></dt>
								  <dd style="margin-left: 50px;">
									<strong>Start the servers</strong>
									<ul>
										<li>Got to <a href="index.php?zone=settings" class="btn btn-success btn-xs btn_settings" style="padding:0px 5px 0px 5px;">settings</a></li>
										<li>Install/start <samp>HTTP SERVER</samp></li>
										<li>Install/start <samp>DB SERVER</samp> (optional)</li>
									</ul>
								  </dd>
								  <dt style="width:40px"><span class="badge">2</span></dt>
								  <dd style="margin-left: 50px;">
									<strong>Setup your router</strong>
									<ul>
										<li>Find your router IP address (check the manual or search on internet)</li>
										<li>Open your router IP address (ex.: 192.168.2.1.)</li>
										<li>Setup an external access to your local network</li>
									</ul>
								  </dd>
								  <dt style="width:40px"><span class="badge">3</span></dt>
								  <dd style="margin-left: 50px;">
									<strong>Setup your firewall</strong>
									<ul>
										<li>Open <samp>Windows Firewall</samp></li>
										<li>Add exceptions for your servers</samp></li>
									</ul>
								  </dd>
								  <dt style="width:40px"><span class="badge">4</span></dt>
								  <dd style="margin-left: 50px;">
									<strong>Create a fancy address</strong>
									<ul>
										<li>Go to <a href="http://www.dotip.net" target="_blank" class="btn btn-primary btn-xs" style="padding:0px 5px 0px 5px;">www.dotip.net</a></li>
										<li>
											Create a redirection<br />
											Example : you can redirect <samp>www.dotip.net/whatever</samp> to your IP
										</li>
									</ul>
								  </dd>
								  <dt style="width:40px"><span class="badge">5</span></dt>
								  <dd style="margin-left: 50px;">
									<strong>Configure MySQL</strong>
								  </dd>
								</dl>

								<div class="text-right"><strong>Read more on</strong> <a href="http://www.easyphp.org/support/easyphp-webserver/" target="_blank"><button type="button" class="btn btn-danger btn-xs btn_help">Help</button></a></div>
							</div>
						</div>
					</div>
					<?php
				}?>	
			
				<div class="row">
					<div class="col-sm-8">
						<h3>ENVIRONMENT</h3>
						<div class="table-responsive">
							<table class="table table-hover">
								<tbody>
									<tr>
										<td><strong>Dashboard</strong></td>
										<td><em>IP: </em><kbd>127.0.0.1</kbd> <em>Port: </em><kbd>10000</kbd></td>
										<td><a href="http://127.0.0.1:10000" title="open" target="_blank"><button type="button" class="btn btn-primary btn-xxs"><small class="glyphicon glyphicon-bookmark"></small></button></a> <samp>http://127.0.0.1:10000</samp></td>
									</tr>
									<tr>
										<td><strong>Local network</strong></td>
										<td><em>IP: </em><kbd><?php echo $network_ip ?></kbd> <em>Port: </em><kbd><?php echo $http_port ?></kbd></td>
										<td><a href="http://<?php echo $network_ip . ':' . $http_port ?>" title="open" target="_blank"><button type="button" class="btn btn-primary btn-xxs"><small class="glyphicon glyphicon-bookmark"></small></button></a> <samp>http://<?php echo $network_ip . ':' . $http_port; ?></samp></td>
									</tr>
									<tr>
										<td><strong>Internet</strong></td>
										<td><em>IP: </em><kbd><?php echo file_get_contents('http://www.easyphp.org/myipaddress.php'); ?></kbd>  <em>Port: </em><kbd><?php echo $http_port ?></kbd></td>
										<td><a href="http://<?php echo file_get_contents('http://www.easyphp.org/myipaddress.php') . ':' . $http_port; ?>" title="open" target="_blank"><button type="button" class="btn btn-primary btn-xxs"><small class="glyphicon glyphicon-bookmark"></small></button></a> <samp>http://<?php echo file_get_contents('http://www.easyphp.org/myipaddress.php') . ':' . $http_port; ?></samp></td>
									</tr>
									<tr>
										<td><strong>Document root</strong></td>
										<td colspan="2">
											<span class="label label-default"><small class="glyphicon glyphicon-link"></small></span> <samp><?php echo dirname(getcwd()) . '\www'; ?></samp>
										</td>
									</tr>
								</tbody>
							</table>
						</div>
					</div>
					  
					<!-- CONTROL PANEL -->
			
					<div class="col-sm-4">
						
						<br />
						<br />

						<div class="well" style="padding:0px 10px 10px 10px;margin-bottom:4px;">
							<h4 class="text-center">Control Panel</h4>
							<?php
							$binaries = @opendir('../binaries');
							while ($binaries_dir = @readdir($binaries)){
								if (@file_exists('../binaries/'.$binaries_dir.'/ews_app.php')){
									include('../binaries/'.$binaries_dir.'/ews_app.php');
									$service_status = array();
									$httpserver_status = 0;
									
									exec("service-info.exe query " . $server['app_service_name'],$service_status);
									
									$control = '<div class="row">';
									$control .= '<div class="col-sm-10">';
									$control .= '<p>';
										if (count($service_status) == 1)
										{
											// service not installed
											$control .= '<small><span class="label label-default">&nbsp;&nbsp;&nbsp;</span></small>';
										}
										else
										{
											// service installed
											if (strstr(serialize($service_status), 'RUNNING') !== FALSE) {
												// service running
												$control .= '<small><span class="label label-success">&nbsp;&nbsp;&nbsp;</span></small>';
												if ($server['app_service_name'] == ews-httpserver) $httpserver_status = 1;
												
											} else {
												// service stopped
												$control .= '<small><span class="label label-danger">&nbsp;&nbsp;&nbsp;</span></small>';
											}
										}	
									$control .= ' <small><strong>' . strtoupper($server['app_type_name']) . '</strong></small>';
									$control .= ' <small><i class="text-muted">' . $server['app_name'] . ' ' . $server['app_version'] . '</i></small>';
									$control .= '</p>';
									$control .= '</div>';
									$control .= '<div class="col-sm-2 text-right">';
									$control .= '<a href="index.php?zone=settings&page=' . $server['app_folder'] . '" style="color:gray;"><span class="glyphicon glyphicon-cog"></span></a>';	
									$control .= '</div>';	
									$control .= '</div>';	

									echo $control;
								}
							}
							@closedir($binaries);	
							?>			
						</div>
						<p class="text-right"><a href="http://www.easyphp.org/easyphp-webserver.php" target="_blank"><button type="button" class="btn btn-default btn-xs"><small class="glyphicon glyphicon-plus"></small> add plugins</button></a></p>

					</div>
				</div>
				
				<div class="row">
					<div class="col-sm-12">
						<?php
						//= MODULES ======================================================================================== 
						$modules = opendir("../modules");
						$modules_files = array();
						while ($modules_file = @readdir($modules)){
							if (($modules_file != '..') && ($modules_file != '.') && ($modules_file != '') && (@is_dir("../modules/".$modules_file)) && @file_exists("../modules/".$modules_file."/ews_module.php")){ 
								$modules_files[] = $modules_file;
							}
							sort($modules_files);
						}
						@closedir($modules);
						clearstatcache();
						?>	
						
						<h3>MODULES</h3>
						
						<?php

						if (count($modules_files) == 0) {
							echo "<div class='modules_none'>" . $module_none . "<a href='http://www.easyphp.org' target='_blank' class='add_link'>". $menu_module_add ."</a></div>";
						} else {
						
							if ($httpserver_status == 0) {
								echo '<p class="text-danger"><span class="label label-danger">!</span> You need to start <samp>HTTP SERVER</samp> first if you want to use modules</span> <a href="index.php?zone=settings&page=httpserver" class="label label-danger">start service</a></p>';
							} else {
								foreach ($modules_files as $file) {
									include('../modules/' . $file . '/ews_module.php');
								}
							}
						}
						?>
						<p class="text-right"><a href="http://www.easyphp.org/easyphp-webserver.php" target="_blank"><button type="button" class="btn btn-default btn-xs"><small class="glyphicon glyphicon-plus"></small> add modules</button></a></p>
						<?php
						//==================================================================================================
						?>
					</div>
				</div>
			
			</div> <!-- /container -->
				
			<?php
		}
		?>

		<div class="container footer">
			<div class="row">
				<div class="col-sm-4">
					<p><strong>EASYPHP WEBSERVER</strong></p>
					<ul class="list-unstyled">
						<li>version : <a href='http://www.easyphp.org/easyphp-webserver' target='_blank'>14.1 beta 1</a></li>
						<li>website : <a href='http://www.easyphp.org' target='_blank'>EasyPHP</a></li>
						<li>support : <a href='http://www.easyphp.org/support/easyphp-webserver/' target='_blank'>Webserver Support</a></li>
						<li>feedback : <a href="mailto:easyphpdotorg@gmail.com?Subject=EasyPHP%20Webserver%20Feedback" target="_blank">Email</a></li>
					</ul>
				</div>
				<div class="col-sm-3">
					<p><strong>SOCIAL</strong></p>
					<p>
						<a href="http://www.facebook.com/easywamp" target="_blank" class="facebook" title="facebook">f</a>
						<a href="http://www.twitter.com/easyphp" target="_blank" class="twitter" title="twitter">t</a>
						<a href="http://www.google.com/+easyphp" target="_blank" class="googleplus" title="google+">g</a>
					</p>
				</div>
				<div class="col-sm-3">
					<p><strong>NEWSLETTER</strong></p>
					<p>
					<a href="http://www.easyphp.org/subscribe.php" target="_blank" class="newsletter" title="newsletter">subscribe</a>
					</p>
				</div>
				<div class="col-sm-2">
					<p><strong>LINKS</strong></p>
					<ul class="list-unstyled">
						<li><a href='http://www.dotip.net' target='_blank'>dotip.net</a></li>
						<li><a href='http://www.phpdistiller.net' target='_blank'>phpdistiller.net</a></li>
						<li><a href='http://www.webcodesniffer.net' target='_blank'>webcodesniffer.net</a></li>
					</ul>			
				</div>
			</div>
		</div>
		<div class="container text-center text-muted">
			<small><em>EasyPHP 2000 - 2014 | www.easyphp.org</em></small>
			<br />
			<a href="http://www.easyphp.org" target="_blank" class="EasyPHP" title="EasyPHP"><img src="images/logo_easyphp.png" alt="EasyPHP Webserver" border="0" /></a>
		</div>

		<!-- Bootstrap core JavaScript
		================================================== -->
		<!-- Placed at the end of the document so the pages load faster -->
		<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.1/jquery.min.js"></script>
		<script src="library/bootstrap/js/bootstrap.min.js"></script>
	</body>
</html>