<!DOCTYPE html>
<html>
<head>
    <title>Project Updated</title>
</head>
<body>
    <h1>Project Updated: {{ $project->name }}</h1>
    <p>Changes:</p>
    <ul>
        @foreach ($changes as $key => $value)
            <li><strong>{{ $key }}:</strong> {{ $value }}</li>
        @endforeach
    </ul>
</body>
</html>
