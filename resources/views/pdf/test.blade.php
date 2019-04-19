<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
</head>
<body style="margin:0; padding: 0;">
<style>
    .page-break {
        page-break-after: always;
    }
</style>
<h1>Page 1</h1>
<div class="page-break"></div>
<h1>Page 2</h1>

<img src="{{ asset('img/dachausbau.jpg') }}" style="
       float: right;
        width: auto;
        height: 100%;
        position: absolute;
        top:0;
        right: 0">

</body>
</html>