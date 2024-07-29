
<footer>
    <script src="https://code.jquery.com/jquery-3.2.1.slim.min.js" integrity="sha384-KJ3o2DKtIkvYIK3UENzmM7KCkRr/rE9/Qpg6aAZGJwFDMVNA/GpGFF93hXpG5KkN" crossorigin="anonymous"></script>
    <script src="./includes/assets/js/apexcharts.js"></script>
    <script src="./includes/assets/js/lodash.min.js"></script>
    <script src="./includes/assets/js/axios.min.js"></script>
    
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
        if(isset($parentFileName) && $parentFileName == 'admin'){
            echo ('<script src="./includes/assets/js/adminapp.js?v=' . time() . '"></script>');
        } else {
            echo ('<script src="./includes/assets/js/app.js?v=' . time() . '"></script>');
        }

    ?>

</footer>
</body>
</html>