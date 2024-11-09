<?php
$AssetsPath = __DIR__;
$isCreatePage = false;
$checkUrlForCreatePage = $_SERVER['PHP_SELF'];
if (strpos($checkUrlForCreatePage, 'create') !== false) {
    $isCreatePage = true;
}

?>
<!doctype html>    
    <html lang="<?php echo($templatelang) ?>" <?php if($templatelang == 'Farsi'){ echo("dir='rtl'"); } ?> <?php if($isCreatePage == true){ echo("style='font-size:0.9em;'"); } else {echo("style='font-size:0.8em;'");} ?> >

    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <title>Cloud VPS</title>
        <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
        <link href="./includes/assets/css/style.css" rel="stylesheet">
        <!-- RTL Persian BOOTSTRAP -->
        <?php if ($templatelang == 'Farsi'): ?>
            <link href="./includes/assets/css/bootstrap.rtl.min.css" rel="stylesheet">
            <link href="./includes/assets/style.css" rel="stylesheet">
            <style> * {font-family: 'Vazirmatn' !important;}</style>
        
        <?php else: ?> 
            <link href="./includes/assets/css/bootstrap.min.css" rel="stylesheet">    
            <!-- FONT: Plus Jakarta Sans  -->
            <link rel="preconnect" href="https://fonts.googleapis.com">
            <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
            <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:ital,wght@0,200;0,300;0,400;0,500;0,600;0,700;0,800;1,200;1,300&display=swap" rel="stylesheet">
            <style> * {font-family: 'Plus Jakarta Sans', sans-serif !important;}</style>
        <?php endif ?>
        <!-- END RTL  -->



        <style>
            .sidebar {
              position: -webkit-sticky !important;
              position: sticky !important;
              top: 80px !important;
              padding-top: 20px !important; /* Add padding to prevent content from being covered */
            }

            .content {
              /* Add some padding-top to compensate for the sticky sidebar */
              padding-top: 20px !important;
            }

            
            .waiting-cursor
            {
                cursor: wait !important;
            }

        </style>

    </head>
        















