<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Project</title>
    <style>
        .center-button {
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
        }
        .center-button button {
            padding: 10px 20px;
            font-size: 16px;
            cursor: pointer;
        }
    </style>
</head>
<body>
    <div class="center-button">
        <form action="/getProjects" method="GET">
            <button type="submit">Retrieve Projects</button>
        </form>
    </div>
</body>
</html>