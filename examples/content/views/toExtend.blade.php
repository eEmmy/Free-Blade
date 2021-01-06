<!DOCTYPE html>
<html>
<head>
	<title>@yield('title')</title>
	<meta charset="utf-8">
	<!-- CSS -->
	{ css('style') }
	<!-- Favicon -->
	<link rel="icon" href="{ favicon() }" type="image/x-icon"/>
</head>
<body>
	<!-- Section -->
	Section start: 
	<br>
	@yield('content')
	<br>
	Section end <br><br>

	<!-- Media -->
	Audio: <br>
	@yield('audio') <br><br>

	Video: <br>
	@yield('video') <br><br>

	Image: <br>
	@yield('image') <br><br>

	<!-- JS -->
	{ js('alert') }
</body>
</html>