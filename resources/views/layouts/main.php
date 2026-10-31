<!DOCTYPE html>
<html lang="en">

<head>

    <meta charset="UTF-8">

    <meta name="viewport"
          content="width=device-width, initial-scale=1.0">

    <title>
        <?= htmlspecialchars($title ?? 'Car Rental Management System') ?>
    </title>

    <!-- Bootstrap 5 -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css"
          rel="stylesheet">

    <!-- Bootstrap Icons -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css"
          rel="stylesheet">

    <!-- Application Stylesheet -->
    <link rel="stylesheet"
          href="/assets/css/style.css">

</head>

<body>

    <!-- Navigation -->
    <?php require BASE_PATH . '/resources/views/components/navbar.php'; ?>

    <!-- Main Page Content -->
    <main>
        <?= $content ?>
    </main>

    <!-- Footer -->
    <?php require BASE_PATH . '/resources/views/components/footer.php'; ?>

    <!-- Bootstrap JavaScript -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js">
    </script>

    <!-- Application JavaScript -->
    <script src="/assets/js/app.js"></script>

</body>

</html>