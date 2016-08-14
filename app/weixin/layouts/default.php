<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title><?php echo $title?></title>
    <?php if(!empty($styles)) {?>
        <?php foreach ($styles as $css) {?>
        <link rel="stylesheet" href="<?php echo $css?>"/>
        <?php }?>
    <?php }?>
</head>
<body>
    <?php echo $content?>
    <?php if(!empty($scripts)) {?>
        <?php foreach ($scripts as $script) {?>
            <script src="<?php echo $script?>"></script>
        <?php }?>
    <?php }?>
</body>
</html>