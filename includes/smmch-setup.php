<?php

if ( ! defined( 'ABSPATH' ) ) exit;

// html to show popup and ask to create coin-hive account and copy the public key and private key.
// 

?>
<div class="smmch-popup">
	<div class="smmch-popup-inner">
		<div class="smmch-popup-row">
			<h2>Quick Setup to Mine Monero</h2>
			<form method="post" action="options.php">
				<?php settings_fields('smmch_skip'); ?>
				<input type="hidden" name="smmch_setup" value="1">
				<input class="skip-primary" type="submit" name="Skip" value="SKIP" />
			</form>
		</div>
		<div class="smmch-popup-row">Create Coin Hive Account - Click <a href="https://coinhive.com/account/signup" target="_blank">Here</a></div>
		<div class="smmch-popup-row">After Login > Copy Public Key - Click <a href="https://coinhive.com/settings/sites" target="_blank">Here</a></div>
		<div class="smmch-popup-row">Paste it on <b>'Coin Hive Public Key'</b> Settings & Save</div>
		<div class="smmch-popup-row">Navigate to <b>Visual Control Settings</b>, Update & Save</div>
		<div class="smmch-popup-row">
			<span style="float: left;">Hooray, We are Done!, Enjoy Mining!</span>
			<form method="post" action="options.php">
				<?php settings_fields('smmch_skip'); ?>
				<input type="hidden" name="smmch_setup" value="1">
				<input class="skip-primary" type="submit" name="Skip" value="DONE" />
			</form>
		</div>
	</div>
</div>