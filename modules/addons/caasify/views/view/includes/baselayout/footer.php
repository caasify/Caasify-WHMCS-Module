
<footer>
<!--    <script src="https://code.jquery.com/jquery-3.2.1.slim.min.js" integrity="sha384-KJ3o2DKtIkvYIK3UENzmM7KCkRr/rE9/Qpg6aAZGJwFDMVNA/GpGFF93hXpG5KkN" crossorigin="anonymous"></script>-->
<!--    <script src="./includes/assets/js/bootstrap.bundle.min.js"></script>-->
    <script src="./includes/assets/js/apexcharts.js"></script>
    <script src="./includes/assets/js/lodash.min.js"></script>
    <script src="./includes/assets/js/axios.min.js"></script>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js" integrity="sha256-/xUj+3OJU5yExlq6GSYGSHk7tPXikynS7ogEvDej/m4=" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.1/dist/js/bootstrap.bundle.min.js" integrity="sha384-gtEjrD/SeCtmISkJkNUaaKMoLD0//ElJ19smozuHV6z3Iehds+3Ulb9Bn9Plx0x4" crossorigin="anonymous"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-select/1.14.0-beta2/js/bootstrap-select.min.js" integrity="sha512-FHZVRMUW9FsXobt+ONiix6Z0tIkxvQfxtCSirkKc5Sb4TKHmqq1dZa8DphF0XqKb3ldLu/wgMa8mT6uXiLlRlw==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>

    <script src="https://cdnjs.cloudflare.com/ajax/libs/qrcodejs/1.0.0/qrcode.min.js"></script>

    <?php     
        // Language
        if (empty($templatelang)) {
            $templatelang = 'English';
        }

        echo ('<script src="./includes/assets/js/lang/' . $templatelang . '.js?v=' . time() . '"></script>');

        
        // Dev or Build version of Vue
        if(isset($DevelopeMode) && $DevelopeMode == 'on'){
            $environ = 'dev'; 
            echo ('<script src="./includes/assets/js/vue.global.js"></script>');
        } else {
            $environ = 'prod'; 
            echo ('<script src="./includes/assets/js/vue.global.prod.js"></script>');
        }
        
        // app or admin version of vue app
        if(isset($parentFileName) && ($parentFileName == 'admin')){
            echo ('<script src="./includes/assets/js/adminapp.js?v=' . time() . '"></script>');
        }else if(isset($parentFileName) && ($parentFileName == 'adminoutput')){
            echo ('<script src="./includes/assets/js/adminoutputapp.js?v=' . time() . '"></script>');
        } else {
            echo ('<script src="./includes/assets/js/app.js?v=' . time() . '"></script>');
        }

    ?>

</footer>
</body>
</html>