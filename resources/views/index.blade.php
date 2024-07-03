<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Index</title>


    <link rel="stylesheet" href="{{ asset('css/botones.css') }}">

    
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous"> 
</head>
<body>
<div class="container">
        
        
        @if ($connected)
                Authorized. <a href='?disconnect' class="social-button youtube-button">Disconnect</a>
        @else
                
                <a href='{{ $authUrl }}' class="social-button youtube-button">Iniciar con YouTube</a>
         @endif
        
         <a href="{{$authorizationUrl}}" class="social-button instagram-button">Instagram</a>
        
        <a href="" class="social-button tiktok-button">TikTok</a>
        </div>
   
</body>
</html>