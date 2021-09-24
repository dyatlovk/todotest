<!DOCTYPE html>
<html lang='ru'>
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width">
    <title><?php echo $this->block('title'); ?></title>
    <link rel="stylesheet" href="/css/bootstrap.min.css">
    <link rel="stylesheet" href="/css/main.css">
</head>
<body>
    <div class="container">
        <header class="d-flex justify-content-center py-3">
        </header>
    </div>

    <main>
        <?php echo $this->block('content'); ?>
    </main>

    <footer>
        <?php echo $this->render('layout/footer.php'); ?>
    </footer>
</body>
</html>
