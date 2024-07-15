
<footer>
    <script src="https://code.jquery.com/jquery-3.2.1.slim.min.js" integrity="sha384-KJ3o2DKtIkvYIK3UENzmM7KCkRr/rE9/Qpg6aAZGJwFDMVNA/GpGFF93hXpG5KkN" crossorigin="anonymous"></script>
    <script src="./includes/assets/js/apexcharts.js"></script>
    <script src="./includes/assets/js/lodash.min.js"></script>
    <script src="./includes/assets/js/axios.min.js"></script>
    
    <?php     
        
        if(isset($DevelopeMode) && $DevelopeMode == 'on'){
            $environ = 'dev'; 
        } else {
            $environ = 'prod'; 
        }
        
        if (empty($templatelang)) {
            $templatelang = 'English';
        }

        if($environ == 'dev'){
            echo ('<script src="./includes/assets/js/vue.global.js"></script>');
            echo ('<script src="./includes/assets/js/lang/' . $templatelang . '.js?v=' . time() . '"></script>');
            if(isset($parentFileName) && $parentFileName == 'admin'){
                echo ('<script src="./includes/assets/js/adminapp.js?v=' . time() . '"></script>');
            } else {
                echo ('<script src="./includes/assets/js/app.js?v=' . time() . '"></script>');
            }
        }

        if($environ == 'prod'){
            echo ('<script src="./includes/assets/js/vue.global.prod.js"></script>');
            echo ('<script src="./includes/assets/js/lang/' . $templatelang. '.js"></script>');
            if(isset($parentFileName) && $parentFileName == 'admin'){
                echo ('<script src="./includes/assets/js/adminapp.js"></script>');
            } else {
                echo ('<script src="./includes/assets/js/app.js"></script>');
            }
        }
        
    ?>

</footer>
</body>
</html>