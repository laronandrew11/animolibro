<?php
require_once('animolibroerrorhandler.php');

function inflate_sell_ad($myprofile, $ad) {

if ($ad['negotiable'] == 1) {
	$negotiable = " (negotiable)";
}
else {
	$negotiable = " (non-negotiable)";
}

echo '
<div class="panel panel-default">
	<div class="panel-heading">
		<h3 class="panel-title">' . $ad['book']['title'] . '</h3>
	</div>
';
echo '
	<div class="panel-body">
		<div class="col-sm-6 col-md-4">
			<img src="uploads/' . $ad['book']['cover_pic_filepath'] . '" alt="" class="img-rounded img-responsive" />
		</div>
		<p>Author: ' . $ad['book']['authors'] . '
		<p>Condition: ' . $ad['copy_condition'] . '
		<p>Price: Php ' . $ad['cost'] . $negotiable;

echo '
		<p>Meetup: ' . $ad['meetup'] . '
		<p>Copy Description: '.$ad['description'];

if ($myprofile) {
	if ($ad['status'] == -1) {
		echo '<button type="button" class="btn btn-primary disabled pull-right">No Buyer Yet</button>';
	}
	else if ($ad['status'] == 1) {
		echo '<p>Buyer: ' . $ad['buyer_name'] . '
		
		<div class="btn-group pull-right">
			<button class="btn btn-primary" data-toggle="modal" data-target="#requestad'.$ad['id'].'">
				Request Pending
			</button>
		</div>

		<!-- MODAL -->
		<div class="modal fade" id="requestad'.$ad['id'].'" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
			<div class="modal-dialog">
				<div class="modal-content">
					<div class="modal-header">
						<button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
						<h4 class="modal-title" id="myModalLabel">'. $ad['book']['title'] .'</h4>
					</div>
					<div class="modal-body">
						<div class="col-md-3">
							<img src="uploads/' . $ad['book']['cover_pic_filepath'] . '" alt="" class="img-rounded img-responsive" />
						</div>
						<p>Author: ' . $ad['book']['authors'] . '</p>
						<p>Condition: ' . $ad['copy_condition'] . '</p>
						<p>Price: Php ' . $ad['cost'] . $negotiable . '</p>
						<p>Meetup: ' . $ad['meetup'] . '</p>
						<p>Copy Description: '.$ad['description'] . '</p>
						<p>Buyer: ' . $ad['buyer_name'] . '</p>
					</div>
					<div class="modal-footer">
						<form class="form-inline" action="php/confirmstat.php" method="POST">
							<label class="sr-only" for="password">Please enter password</label>
							<input type="password" class="form-control" style="width: 15em;" name="password" placeholder="Please enter password" required />
							<input type="hidden" name="ad_id" value="' . $ad['id'] . '" />
							<input type="hidden" name="myprofile" value="' . $myprofile . '" />
							<input class="btn btn-danger" name="confirmation" type="submit" value="Reject"></input>
							<input class="btn btn-success" name="confirmation" type="submit" value="Accept"></input>
						</form>
					</div>
				</div>
			</div>
		</div>';
	}
	else if ($ad['status'] == 2) {
		echo '<p>Buyer: ' . $ad['buyer_name'] . '
		<button type="button" class="btn btn-success disabled pull-right">Request Accepted</button>';
	}
	else if ($ad['status'] == 3) {
		echo '<p>Buyer: ' . $ad['buyer_name'] . '
		<button type="button" class="btn btn-danger disabled pull-right">Request Rejected</button>';
	}
}
else {
	echo'<input type="hidden" name="url" value="'.$_SERVER['REQUEST_URI'].'">';
	if ($ad['status'] == 0 || $ad['status'] == 3)
		echo '
		<div class="btn-group pull-right">
			<button class="btn btn-primary pull-right buy-btn" data-toggle="modal" data-target="#buyad'.$ad['id'].'">
				Buy
			</button>
		</div>

		<!-- MODAL -->
		<div class="modal fade" id="buyad'.$ad['id'].'" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
			<div class="modal-dialog">
				<div class="modal-content">
					<div class="modal-header">
						<button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
						<h4 class="modal-title" id="myModalLabel">'. $ad['book']['title'] .'</h4>
					</div>
					<div class="modal-body">
						<div class="col-md-3">
							<img src="uploads/' . $ad['book']['cover_pic_filepath'] . '" alt="" class="img-rounded img-responsive" />
						</div>
						<p>Author: ' . $ad['book']['authors'] . '</p>
						<p>Condition: ' . $ad['copy_condition'] . '</p>
						<p>Price: Php ' . $ad['cost'] . $negotiable . '</p>
						<p>Meetup: ' . $ad['meetup'] . '</p>
						<p>Copy Description: '.$ad['description'] . '</p>
					</div>
					<div class="modal-footer">
						<form class="form-inline" action="php/buybook.php" method="POST">
							<input type="hidden" name="adid" value="' . $ad['id'] . '">
							<input type="hidden" name="myprofile" value="' . $myprofile . '">
							<button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
							<input type="submit" name="submit" class="btn btn-primary pull-right buy-btn" value="Buy">
						</form>
					</div>
				</div>
			</div>
		</div>';
		
	else if ($ad['status'] == 1) {
		echo '
		<form onsubmit="return confirm(\'Request to buy this book?\');" action="php/buybook.php" method="POST">
			<input type="hidden" name="adid" value="' . $ad['id'] . '">
			<input type="hidden" name="myprofile" value="' . $myprofile . '">
			<input type="submit" name="submit" class="btn btn-primary disabled pull-right buy-btn" value="Bought">
		</form>';
	}
}

echo '
	</div>
</div>
';

}

?>