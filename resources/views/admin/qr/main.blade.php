<!DOCTYPE html>
<html>
	<head>
		<meta charset="utf-8">
		<meta http-equiv="X-UA-Compatible" content="IE=edge">
		<title>Infinit Solutions | QR</title>
		<meta name="viewport" content="width=device-width, initial-scale=1">
		<link rel="stylesheet" href="{{ asset('assets/plugins/fontawesome-free/css/all.min.css') }}">
		<link rel="stylesheet" href="https://code.ionicframework.com/ionicons/2.0.1/css/ionicons.min.css">
		<link rel="stylesheet" href="{{ asset('assets/dist/css/adminlte.min.css') }}">
		<link href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700" rel="stylesheet">
	</head>
	<body>
		<div class="wrapper">
			<section class="invoice">
				{{ $qrdata }}
			</section>
		</div>

		<script type="text/javascript"> 
			//window.addEventListener("load", window.print());
		</script>
	</body>
</html>
