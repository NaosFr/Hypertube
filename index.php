<!DOCTYPE html>
<html lang="fr">
<head>
	<?php include 'meta.php'; ?>

<!-- ******* CSS ***************** -->
	<link rel="stylesheet" type="text/css" href="css/main.css">
	<link rel="stylesheet" type="text/css" href="css/form.css">
	<link rel="stylesheet" type="text/css" href="css/responsive.css">
<!-- ******* SLIDER ***************** -->
	<link rel="stylesheet" href="//code.jquery.com/ui/1.12.1/themes/base/jquery-ui.css">
  	<script src="https://code.jquery.com/jquery-1.12.4.js"></script>
  	<script src="https://code.jquery.com/ui/1.12.1/jquery-ui.js"></script>

</head>

<body>

<?php include 'header.php'; ?>

<!-- ******* NAVBAR FILTER ***************** -->

<section class="navbar_filter">
	<div class="theme">
		<div><p>ACTION</p></div>
		<div><p>DRAMA</p></div>
		<div><p>FICTION</p></div>
		<div><p>POLICE</p></div>
	</div>

	<form action="#" onsubmit="return false" accept-charset="utf-8" id="form_filter">
		
	
	
			<input type="text" id="years" name="years" readonly/>
	
		<div id="slider-years" class="slider"></div>

			<input type="text" id="score" name="score" readonly/>
		
		<div id="slider-score" class="slider"></div>



	    <input type="submit" value="FILTER" class="submit_filter transition" onclick="login()" />
	</form>

</section>

<!-- ******* JAVASCRIPT ***************** -->
<script type="text/javascript" src="js/main.js"></script>
<script type="text/javascript">
	// SLIDER YEARS
	    $("#slider-years").slider({
	      range: true,
	      min: 1990,
	      max: 2018,
	      values: [ 1990, 2018 ],
	      slide: function( event, ui ) {
	        $( "#years" ).val(ui.values[ 0 ] + " - " + ui.values[ 1 ] );
	      }
	    });
	    $( "#years" ).val($("#slider-years").slider("values", 0) +
	      " - " + $( "#slider-years" ).slider("values", 1));
		
	// SLIDER SCORE
		$("#slider-score").slider({
	      range: true,
	      min: 0,
	      max: 10,
	      values: [0, 10],
	      slide: function( event, ui ) {
	        $( "#score" ).val(ui.values[ 0 ] + " - " + ui.values[ 1 ] );
	      }
	    });
	    $( "#score" ).val($("#slider-score").slider("values", 0) +
	      " - " + $( "#slider-score" ).slider("values", 1));
</script>
<!-- <script type="text/javascript" src="js/jquery.js"></script> -->
</body>
</html>