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
            <div>
                <div>
                    <img src="assets/usuarioDesc.png" alt="Foto de perfil" width="300" height="200">
                </div>
                <div>
                    <div class = "stats" >
                        <h2>Subscriptores</h2>
                        <p>{{$subs}}</p>
                    </div>
                    <div class = "stats" >
                        <h2>Vistas</h2>
                        <p>{{$views}}</p>
                    </div>
                </div>
            </div>
        @else
                
                
        @endif
        
         
        
    </div>
   
</body>
</html>