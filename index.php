<?php
// Made by Tadeo Kondrak (tadeokondrak.com)
// LICENSE: http://tadeo.mit-license.org/
?>
<link rel="stylesheet" href="//netdna.bootstrapcdn.com/bootstrap/3.1.1/css/bootstrap.min.css"> //bootstrap 3.1.1
<script src="//netdna.bootstrapcdn.com/bootstrap/3.1.1/js/bootstrap.min.js"></script> //bootstrap 3.1.1
<style>body{margin: 30px;}</style>
<h1>AltCoin (ALT) Faucet</h1>
<hr />
<?php
require_once("ayah.php"); // Install areyouahuman.com into this folder.
require_once("jsonRPCClient.php"); //get this here: http://jsonrpcphp.org/
$alt = new jsonRPCClient('http://username:password@localhost:port/'); //set to altcoind user/pass/port
$min = 1; //set to minimum payout
$max = 5; //set to max payout
$ayah = new AYAH();
	if (array_key_exists('submit', $_POST)){
		$score = $ayah->scoreResult();
		if ($score){
			$username = $_POST['address'];
			if(!empty($_POST['address'])) {
				if($alt->getbalance() < 1){
					echo '<div class="alert alert-dismissable alert-danger"><button type="button" class="close" data-dismiss="alert">×</button><strong>Error:</strong> <a href="#" class="alert-link"></a>Not enough balance.</div>';
				} else {
					$check = $alt->validateaddress($username);
					if($check["isvalid"] == 1){
						$amount = rand($min,$max);$alt->sendtoaddress($username, $amount);
						echo '<div class="alert alert-dismissable alert-success"><button type="button" class="close" data-dismiss="alert">×</button><strong></strong> <a href="#" class="alert-link"></a>You got ';
						echo $amount;
						echo " ALT!</div>";
					}
				}
			}
	}
	else
	{
		echo '<div class="alert alert-dismissable alert-danger"><button type="button" class="close" data-dismiss="alert">×</button><strong>Error:</strong> <a href="#" class="alert-link"></a>Human Verification Failed.</div>';
	}
	
}
?>

<form role="form" action="index.php" method="POST">
  <div class="form-group">
    <label for="address">ALT address</label>
    <input type="address" name="address" class="form-control" id="address" placeholder="MVVXiPfpBhGoLcWstgQWjrzHWSXX3CM7RR">
  </div>
  <?php
	echo $ayah->getPublisherHTML();
  ?>
  <button type="submit" class="btn btn-default" name="submit">Submit</button>
</form>
<br>
<h5>1-5 ALT payout. | Faucet Balance: <?php print_r($alt->getbalance()); ?> | Donate to the faucet: [address] | Made by: <a href="http://tadeokondrak.com">Tadeo Kondrak</a></h5> | <a href="http://github.com/tadeokondrak/altcoin-faucet">Github Repository</a>
