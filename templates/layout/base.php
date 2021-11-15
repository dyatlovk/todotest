<!DOCTYPE html>
<html lang='ru'>
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width">
    <title><?php echo $this->block('title'); ?></title>
    <link rel="stylesheet" href="/css/bootstrap.min.css">
    <link rel="stylesheet" href="/css/main.css">
</head>
<body <?php echo $this->block('body_attr'); ?>>
        <main>
             <div class="container">
                <div class="py-5">
                    <?php echo $this->block('content'); ?>
                </div>
            </div>
    </main>
    <?php echo $this->block('js'); ?>
</body>
</html>
