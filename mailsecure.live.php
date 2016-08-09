<?php
//include "../3rdparty/bootstrap/optimized/css/bootstrap.min.css";
//include "../3rdparty/bootstrap-rtl/optimized/dist/css/bootstrap-rtl.min.css";
//include "/usr/local/cpanel/base/frontend/paper_lantern/_assets/master.html.tt";
//include "../3rdparty/bootstrap/optimized/js/bootstrap.js";


include("/usr/local/cpanel/php/cpanel.php");  // Instantiate the CPANEL object.
$cpanel = new CPANEL();                       // Connect to cPanel
print $cpanel->header( "Liquid Web - MailSecure" );      // Add the header.
?>
<link rel="stylesheet" href="../css/cpanel_base.min.css" type="text/css">

<div class="alert alert-warning alert-dismissable">
    <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
    <span class="glyphicon glyphicon-ok-sign"></span>
    <div class="alert-message">
        <strong>Warning:</strong>
        This plugin is experimental. Use with caution! Contact MBenedict with questions or comments.
    </div>
</div>

<?php
//List domains in array
$get_domain_list = $cpanel->uapi(
'DomainInfo', 'list_domains'
);
		//Main Domain
		$main_domain = $get_domain_list['cpanelresult']['result']['data']['main_domain'];
		$cpanel_domains=array ("$main_domain");
		//Addon Domains
		foreach($get_domain_list['cpanelresult']['result']['data']['addon_domains'] as $key => $value)
		{
		  $user_addondomains = $value;
		  array_push($cpanel_domains,"$user_addondomains");
		  }
		//Sub Domains
		foreach($get_domain_list['cpanelresult']['result']['data']['sub_domains'] as $key => $value)
		{
		  $user_subdomains = $value;
		  array_push($cpanel_domains,"$user_subdomains");
		}
		//Parked Domains
		foreach($get_domain_list['cpanelresult']['result']['data']['parked_domains'] as $key => $value)
		{
		  $user_parkeddomains = $value;
		  array_push($cpanel_domains,"$user_parkeddomains");

		}
//End List domains in array

//Manipulate list of domains.
sort($cpanel_domains, SORT_NATURAL | SORT_FLAG_CASE);
foreach ($cpanel_domains as $key => $value) {
    echo $value;
    // Check if domain has MailSecure MX
    $checkmx = array();
    getmxrr($value, $checkmx);
	if (in_array("bmx01.sourcedns.com", $checkmx) || in_array("bmx01.sourcedns.com", $checkmx)) {
  	#echo '<toggle-switch id="unique_id" ng-model="toggle_model" on-toggle="toggle_status()" ng-disabled="!toggle_enabled" aria-label="Enabled" enabled-label="Enabled" disabled-label="Disabled" no-spinner="1" no-label="1"></toggle-switch>';
	echo '<button style="display:inline; float:right" type="button" class="btn btn-primary">Enable/Setup</button>';
	} else {
	echo '<button style="display:inline; float:right"  type="button" class="btn btn-primary" disabled>MX Not Setup</button>';
	}

    echo "<br><hr>";
}


// End Manipulate list of domains.

?>

<?php
print $cpanel->footer();                      // Add the footer.
$cpanel->end();                               // Disconnect from cPanel
?>
