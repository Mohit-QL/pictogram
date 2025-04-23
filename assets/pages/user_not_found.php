<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>User Not Found</title>
    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        body {
            background-color: #f4f6f9;
            font-family: Arial, sans-serif;
        }

        .container {
            max-width: 600px;
            margin-top: 150px;
            padding: 40px;
            border-radius: 10px;
            background-color: #fff;
            box-shadow: 0 4px 10px rgba(0, 0, 0, 0.1);
            text-align: center;
        }

        .container h1 {
            font-size: 2.5rem;
            font-weight: 600;
            margin-bottom: 20px;
        }

        .container p {
            font-size: 1.1rem;
            color: #6c757d;
            margin-bottom: 30px;
        }

        .btn-custom {
            background-color: #A3BE4C;
            color: white;
            border-radius: 30px;
            padding: 10px 30px;
            font-size: 1.2rem;
            text-transform: uppercase;
        }

        .btn-custom:hover {
            background-color: #7a9e3d;
        }

        .icon {
            font-size: 5rem;
            color: #ff5c5c;
            margin-bottom: 20px;
        }

        .footer {
            margin-top: 50px;
            font-size: 0.9rem;
            color: #6c757d;
        }
    </style>
</head>
<body>

<div class="container">
    <div class="icon">
        <i class="bi bi-person-x"></i>
    </div>

    <h1>User Not Found</h1>
    <p>We couldn't find the user you're looking for. Please check the details and try again.</p>

    <a href="index.php" class="btn btn-custom">Go Back to Homepage</a>

    <div class="footer">
        <p>If you think this is a mistake, please contact support.</p>
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap-icons/font/bootstrap-icons.js"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js"></script>

</body>
</html>
