<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Checkbox confi</title>
</head>
<body>
    <form action="{{ route('data2') }}" method="POST" >
        @csrf
        <label><input type="checkbox" name="metrica[]" value="annotationClickThroughRate" checked>Tasa de clicks de anotaciones</label><br>
        <label><input type="checkbox" name="metrica[]" value="annotationCloseRate"> Tasa de cierre de anotaciones</label><br>
        <label><input type="checkbox" name="metrica[]" value="averageViewDuration"> Duración promedio de la vista (en seg)</label><br>
        <label><input type="checkbox" name="metrica[]" value="comments"> Comentarios</label><br>
        <label><input type="checkbox" name="metrica[]" value="dislikes"> Me disgusta</label><br>
        <label><input type="checkbox" name="metrica[]" value="estimatedMinutesWatched"> Minutos estimados vistos</label><br>
        <label><input type="checkbox" name="metrica[]" value="estimatedRevenue"> Ingresos estimados</label><br>
        <label><input type="checkbox" name="metrica[]" value="likes"> Me gusta</label><br>
        <label><input type="checkbox" name="metrica[]" value="shares"> Campartidos</label><br>
        <label><input type="checkbox" name="metrica[]" value="subscribersGained"> Subscriptores obtenidos</label><br>
        <label><input type="checkbox" name="metrica[]" value="subscribersLost"> Subscriptores perdidos</label><br>
        <label><input type="checkbox" name="metrica[]" value="viewerPercentage"> Porcentaje de espectadores </label><br>
        <label><input type="checkbox" name="metrica[]" value="views"> Vistas</label><br>
        
        <input type="submit" value="Submit">
    </form>
</body>
</html>