<?php
$httpdconf = file_get_contents('..\binaries\httpserver\conf\httpd.conf');
$apacheerrorlog = file_get_contents('..\binaries\httpserver\logs\error.log');
$apacheaccesslog = file_get_contents('..\binaries\httpserver\logs\access.log');
$service_status = array();
exec("service-info.exe query ews-httpserver",$service_status);

if (count($service_status) == 1)
{
	// service not installed -> install service
	$control = '<form method="post" action="http://' . $_SERVER['HTTP_HOST'] . $_SERVER['REQUEST_URI'] . '" class="form-inline" role="form">';
	$control .= '<input type="hidden" name="app_service_control" value="' . $server['app_service_install'] . '" />';
	$control .= '<button type="submit" class="btn btn-primary btn-sm" onclick="delay()"><strong>install service</strong></button>';
	$control .= '</form>';
}
else
{
	// service installed
	if (strstr(serialize($service_status), 'RUNNING') !== FALSE) {
		// service running -> stop service
		$control = '<form method="post" action="http://' . $_SERVER['HTTP_HOST'] . $_SERVER['REQUEST_URI'] . '" class="form-inline" role="form">';
		$control .= '<input type="hidden" name="app_service_control" value="' . $server['app_service_stop'] . '" />';
		$control .= '<button type="submit" class="btn btn-primary btn-sm" onclick="delay()"><strong>stop service</strong></button>';
		$control .= '&nbsp;<small><span class="label label-warning">!</span><em><span class="text-muted"> If you want to remove the service, stop it first.</span></em></small>';
		$control .= '</form>';
	} else {
		// service stopped -> remove or start service
		$control = '<form method="post" action="http://' . $_SERVER['HTTP_HOST'] . $_SERVER['REQUEST_URI'] . '" class="form-inline" style="display:inline;" role="form">';
		$control .= '<input type="hidden" name="app_service_control" value="' . $server['app_service_start'] . '" />';
		$control .= '<button type="submit" class="btn btn-primary btn-sm" onclick="delay()"><strong>start service</strong></button>';
		$control .= '</form>';
		$control .= '<form method="post" action="http://' . $_SERVER['HTTP_HOST'] . $_SERVER['REQUEST_URI'] . '" class="form-inline" style="display:inline;" role="form">';
		$control .= '<input type="hidden" name="app_service_control" value="' . $server['app_service_remove'] . '" />';
		$control .= '&nbsp;&nbsp;<button type="submit" class="btn btn-default btn-sm" onclick="delay()"><strong>remove service</strong></button>';
		$control .= '</form>';
	}
}
?>

<div class="table-responsive">
	<table class="table table-hover">
		<tbody>
			<tr>
				<td><strong>Service</strong></td>
				<td><?php echo $control; ?></td>
			</tr>
			<tr>
				<td><strong>Parameters</strong></td>
				<td>
					<?php
					preg_match('/^ServerName(\s|\t|)(.*):(.*)/m', $httpdconf, $servername);
					?>
					<em>Host: </em><kbd><?php echo $servername[2]; ?></kbd>
					&nbsp;<em>Port: </em><kbd><?php echo $servername[3]; ?></kbd>
				</td>
			</tr>
				<td><strong>URL</strong></td>
				<td>
					<a href="http://<?php echo $servername[2] . ':' . $servername[3]; ?>" title="open" target="_blank"><button type="button" class="btn btn-primary btn-xxs"><small class="glyphicon glyphicon-bookmark"></small></button></a> <samp>http://<?php echo $servername[2] . ':' . $servername[3]; ?></samp>
				</td>
			</tr>
			<tr>
				<td><strong>Server Root</strong></td>
				<td>
					<span class="label label-default"><small class="glyphicon glyphicon-link"></small></span>
					<?php
					preg_match('/^ServerRoot(\s|\t|)"(.*)"/m', $httpdconf, $serverroot);
					echo '<samp>' . str_replace('/', '\\', $serverroot[2]) . '</samp>';
					?>
				</td>
			</tr>
			<tr>
				<td><strong>Document Root</strong></td>
				<td>
					<span class="label label-default"><small class="glyphicon glyphicon-link"></small></span>
					<?php
					preg_match('/^DocumentRoot(\s|\t|)"(.*)"/m', $httpdconf, $documentroot);
					echo '<samp>' . str_replace('/', '\\', $documentroot[2]) . '</samp>';
					?>		
				</td>
			</tr>
			<tr>					
				<td><strong>Files</strong></td>
				<td>
					<a href="index.php?zone=settings&page=httpserver&display=apacheconffile"><button type="button" class="btn btn-info btn-xs">Configuration File</button></a>
					<a href="index.php?zone=settings&page=httpserver&display=apacheerrorlog"><button type="button" class="btn btn-info btn-xs">Error Log</button></a>
					<a href="index.php?zone=settings&page=httpserver&display=apacheaccesslog"><button type="button" class="btn btn-info btn-xs">Access Log</button></a>
				</td>
			</tr>
		</tbody>
	</table>
</div>


<?php
if ($_GET['display'] == 'apacheconffile') {
	?>
	<a href="index.php?zone=settings&page=httpserver"><button type="button" class="close"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button></a>
	<h2>Configuration File</h2>
	<pre><?php echo htmlspecialchars($httpdconf); ?></pre>
	<?php
}

if ($_GET['display'] == 'apacheerrorlog') {
	?>
	<a href="index.php?zone=settings&page=httpserver"><button type="button" class="close"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button></a>
	<h2>Error Log</h2>
	<pre><?php echo htmlspecialchars($apacheerrorlog); ?></pre>
	<?php
}

if ($_GET['display'] == 'apacheaccesslog') {
	?>
	<a href="index.php?zone=settings&page=httpserver"><button type="button" class="close"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button></a>
	<h2>Access Log</h2>	
	<pre><?php echo htmlspecialchars($apacheaccesslog); ?></pre>
	<?php
}
?>