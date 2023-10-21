<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>SGA</title>

    <link rel="stylesheet" type="text/css" href="styles/css/bootstrap.min.css" />
    <link rel="stylesheet" type="text/css" href="styles/css/sidebar.css" />
    <link rel="stylesheet" type="text/css" href="https://cdn.jsdelivr.net/npm/boxicons@latest/css/boxicons.min.css" />
    <link rel="stylesheet" type="text/css" href="styles/css/style.css" />
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.1/dist/css/bootstrap.min.css" rel="stylesheet">
</head>

<body id="body-pd">
    <header class="header" id="header">
        <div class="header_toggle">
            <i class='bx bx-menu' id="header-toggle"></i>
        </div>
        <div class="">
            <h3 class="text-gray-600 small"><?= $_SESSION['nombre'] ?></h3>
            <span class="text-gray-600 small"><?= $_SESSION['cargo'] ?></span>
        </div>

    </header>

    <script src="/styles/js/jquery.min.js"></script>
    <script src="/styles/js/bootstrap.bundle.js"></script>
    <script src="/styles/js/sidebar.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.1/dist/js/bootstrap.bundle.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jspdf/1.3.4/jspdf.debug.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jspdf/1.3.4/jspdf.min.js"></script>




</body>