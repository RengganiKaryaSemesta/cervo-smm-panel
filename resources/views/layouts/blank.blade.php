<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <title>{{ $title }}</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta content="coderthemes" name="author">

    <!-- App favicon -->
    <link rel="shortcut icon" href="{{asset('vendor')}}/assets/images/favicon.ico">

    <!-- App css -->
    <link href="{{asset('vendor')}}/assets/css/app.min.css" rel="stylesheet" type="text/css">

    <!-- Icons css -->
    <link href="{{asset('vendor')}}/assets/css/icons.min.css" rel="stylesheet" type="text/css">

    <!-- Theme Config Js -->
    <script src="{{asset('vendor')}}/assets/js/config.js"></script>
    @vite('resources/js/app.js')
</head>

<body>
  {{$slot}}
</body>

</html>