<?php
$myini = file_get_contents('..\binaries\dbserver\my.ini');
$mysqlerrorlog = file_get_contents('..\binaries\dbserver\data\mysql_error.log');

exec("service-info.exe query ews-dbserver",$service_status);

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
				<td><strong>Security</strong></td>
				<td>
					<p class="alert alert-danger" style="padding:10px;margin:0px 120px 0px 0px;"><i class="fa fa-bomb fa-lg"></i> Don't forget to change the default name of administrator's account (root) and to choose a long, complex alphanumeric password (which is empty by default). <a href="http://www.easyphp.org/support/easyphp-webserver/" target="_blank"><strong><small>READ MORE</small></strong></a></p>
				</td>
			</tr>			
			<tr>
				<td><strong>Parameters</strong></td>
				<td>
					<?php
					preg_match('/^port(\s|\t|)(.*)=(.*)/m', $myini, $port);
					?>
					<em>Host: </em><kbd><?php echo getHostByName(trim(getHostName())) ?></kbd>
					&nbsp;<em>Port: </em><kbd><?php echo trim($port[3]); ?></kbd>
				</td>
			</tr>
			<tr>
				<td><strong>Server Root</strong></td>
				<td>
					<span class="label label-default"><small class="glyphicon glyphicon-link"></small></span>
					<?php
					preg_match('/^basedir(\s|\t|)(.*)=(.*)"(.*)"/m', $myini, $basedir);
					echo '<samp>' . str_replace('/', '\\', trim($basedir[4])) . '</samp>';
					?>
				</td>
			</tr>
			<tr>
				<td><strong>Databases Folder</strong></td>
				<td>
					<span class="label label-default"><small class="glyphicon glyphicon-link"></small></span>
					<?php
					preg_match('/^datadir(\s|\t|)(.*)=(.*)"(.*)"/m', $myini, $datadir);
					echo '<samp>' . str_replace('/', '\\', trim($datadir[4])) . '</samp>';
					?>		
				</td>
			</tr>
			<tr>					
				<td><strong>Files</strong></td>
				<td>
					<a href="index.php?zone=settings&page=dbserver&display=mysqlconffile"><button type="button" class="btn btn-info btn-xs">Configuration File</button></a>
					<a href="index.php?zone=settings&page=dbserver&display=mysqlerrorlog"><button type="button" class="btn btn-info btn-xs">Error Log</button></a>
				</td>
			</tr>
		</tbody>
	</table>
</div>

<?php
if ($_GET['display'] == 'mysqlconffile') {
	?>
	<a href="index.php?zone=settings&page=dbserver"><button type="button" class="close"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button></a>
	<h2>Configuration File</h2>
	<pre><?php echo $myini; ?></pre>
	<?php
}

if ($_GET['display'] == 'mysqlerrorlog') {
	?>
	<a href="index.php?zone=settings&page=dbserver"><button type="button" class="close"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button></a>
	<h2>Error Log</h2>	
	<pre><?php echo $mysqlerrorlog; ?></pre>
	<?php
}
?>