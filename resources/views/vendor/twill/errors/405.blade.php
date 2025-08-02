<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <title>405 Method Not Allowed</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background: #f8f9fa;
            color: #212529;
            text-align: center;
            padding: 100px;
        }
        h1 {
            font-size: 48px;
            margin-bottom: 10px;
        }
        p {
            font-size: 18px;
            color: #6c757d;
        }
        a {
            color: #007bff;
            text-decoration: none;
        }
        a:hover {
            text-decoration: underline;
        }
    </style>
</head>
<body>
    <h1>405 Method Not Allowed</h1>
    <p>The HTTP method used for this request is not allowed.</p>
    <p><a href="{{ url()->previous() }}">Go Back</a></p>
</body>
</html>
