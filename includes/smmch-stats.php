<?php

if ( ! defined( 'ABSPATH' ) ) exit;

$secret = get_option('smmch_private_sitekey');
if($secret != ''){
	$siteurl = 'https://api.coinhive.com/stats/site?secret=' . $secret;
	$siteresponse = json_decode(file_get_contents($siteurl));
	$site = null;
	if ($siteresponse && $siteresponse->success) {
		$site = $siteresponse;
	}
}
?>
<h2>Statistics</h2>
<?php
if($secret != ''){
?>
<div class="smmch-statistics">
	<div class="smmch-col-6"><h3>Site Name:</h3><span><?php echo $site->name; ?></span></div>
	<div class="smmch-col-6"><h3>Hashes Per Second:</h3><span><?php echo $site->hashesPerSecond; ?></span></div>
	<div class="smmch-col-6"><h3>Total Hashes:</h3><span><?php echo $site->hashesTotal; ?></span></div>
	<div class="smmch-col-6"><h3>Total Pending Monero(XMR):</h3><span><?php echo '0.' . number_format($site->xmrPending,8,'',''); ?></span></div>
</div>
<?php
}
?>