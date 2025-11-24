<!DOCTYPE html>
<html>

<head>
    <title>{{ $message }}</title>
    <link rel="stylesheet" href="{{ asset('css/error.css') }}">
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

        <h1>{{ $error }}</h1> <br>

        <div class="status">
            Status: {{ $status }}
        </div>

        <p class="message">
            {{ $message }}
        </p>

        <div class="warning">
            <i class="fas fa-exclamation-circle"></i>
            <div class="warning-text">{{ $error }}</div>
        </div>
    </div>
</body>

</html>
