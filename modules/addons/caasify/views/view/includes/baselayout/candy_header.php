<?php

$isCreatePage = false;

$currentPageUrl = $_SERVER['PHP_SELF'];

$exists = strpos($currentPageUrl, 'create');

if ($exists === true) {
    $isCreatePage = true;
}

$direction = 'ltr';

if ($templatelang == 'Farsi') {
    $direction = 'rtl';
}
?>

<!DOCTYPE html>    
<html lang="<?php echo $templatelang;?>" dir="<?php echo $direction;?>">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <title>Cloud VPS</title>

    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
    <link rel="stylesheet" href="includes/assets/css/style.css">

    <?php if($direction == 'rtl') {?>
        <link href="includes/assets/css/bootstrap.rtl.min.css" rel="stylesheet">
        <link href="includes/assets/style.css" rel="stylesheet">
    <?php } else {?>
        <link rel="stylesheet" href="includes/assets/css/bootstrap.min.css">   
        <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.2/font/bootstrap-icons.min.css">
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-select/1.14.0-beta2/css/bootstrap-select.min.css" integrity="sha512-mR/b5Y7FRsKqrYZou7uysnOdCIJib/7r5QeJMFvLNHNhtye3xJp1TdJVPLtetkukFn227nKpXD9OjUc09lx97Q==" crossorigin="anonymous" referrerpolicy="no-referrer">

        <link rel="preconnect" href="https://fonts.googleapis.com">
        <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
        
        <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:ital,wght@0,200;0,300;0,400;0,500;0,600;0,700;0,800;1,200;1,300&display=swap">
    <?php }?>
</head>
<style>
body{
    background: none;
}

<?php if($direction == 'ltr') {?>
body{
    font-family: 'Plus Jakarta Sans', sans-serif;
}
<?php } else {?>
body{
    font-family: Vazirmatn, sans-serif;
}
<?php }?>

</style>















