<!-- footer -->
</div>
    </div>
        <script src="https://code.jquery.com/jquery-3.2.1.slim.min.js" integrity="sha384-KJ3o2DKtIkvYIK3UENzmM7KCkRr/rE9/Qpg6aAZGJwFDMVNA/GpGFF93hXpG5KkN" crossorigin="anonymous"></script>
        <script src="./includes/assets/js/bootstrap.bundle.min.js"></script>
        <script src="./includes/assets/js/apexcharts.js"></script>
        <script src="./includes/assets/js/lodash.min.js"></script>
        <script src="./includes/assets/js/axios.min.js"></script>

        <?php 
            if (empty($templatelang)) {
                $templatelang = 'English';
            }
            echo ('<script src="./includes/assets/js/lang/' . $templatelang . '.js?v=' . time() . '"></script>');
        ?>
        
        <?php 
            
            // echo('<script src="./includes/vpspricing/assets/js/vue.global.prod.js"></script>');
            echo('<script src="./includes/vpspricing/assets/js/vue.global.js"></script>');
            echo '<script src="./includes/vpspricing/assets/js/vpsapp.js?v=' . time() . '"></script>';
        ?>
    </div>
</body>
</html>