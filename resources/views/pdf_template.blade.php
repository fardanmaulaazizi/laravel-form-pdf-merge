<!DOCTYPE html>
<html>

<head>
    <title>PDF Template</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            text-align: center;
            padding: 20px;
        }

        img {
            max-width: 100%;
            height: auto;
            margin-bottom: 20px;
        }
    </style>
</head>

<body>
    <h1>{{ $name }}</h1>
    <img src="{{ $photoUrl }}" alt="Photo" width="200px">
</body>

</html>
