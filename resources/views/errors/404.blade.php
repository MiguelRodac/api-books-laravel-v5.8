<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="{{ asset('css/error.css') }}">
    <title>{{ $message }}</title>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;600;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
</head>

<body>
    <div class="bg-elements">
        <div class="circle-1"></div>
        <div class="circle-2"></div>
        <div class="circle-3"></div>
    </div>

    <div class="container">
        <div class="error-icon">
            <i class="fas fa-exclamation-triangle"></i>
        </div>

        <h1>{{ $message }}</h1> <br>

        <div class="status">
            Status: {{ $status }}
        </div>

        <p class="message">
            Sorry, we couldn't find the page you're looking for. The URL may be incorrect or the page may have been moved.
        </p>

        <div class="warning">
            <i class="fas fa-exclamation-circle"></i>
            <div class="warning-text">{{ $error }}</div>
        </div>
    </div>
</body>

</html>
