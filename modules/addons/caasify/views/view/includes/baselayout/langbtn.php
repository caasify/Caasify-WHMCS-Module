<div class="dropdown m-0 p-0">
<span class="" type="button" data-bs-toggle="dropdown" aria-expanded="false" >
    <?php 
        $langArrayList = array(
            'Farsi' => 'فارسی',
            'English' => 'English',
            'Turkish' => 'Türkçe',
            'French' => 'Français',
            'Deutsch' => 'Deutsch',
            'Russian' => 'Pусский',
            'Brizilian' => 'Brizilian',
            'Italian' => 'Italian'
        );
        
        foreach ($langArrayList as $key => $value) {
            if ($templatelang === $key) {
                echo '<img src="' . $systemUrl . '/modules/addons/caasify/views/view/includes/assets/img/flags/' . strtolower($key) . '.png" alt="'. $key .'" style="width:34px;">';
            }
        }
    ?>
    </span>
    <div class="dropdown-menu border-1 shadow-lg p-4" style="min-width: 300px !important;">
        <p class="fs-6">{{ lang('chooselanguage') }}</p>    
        <div>
            <select name="language" class="form-select" v-model="PanelLanguage">
                <?php 
                    foreach ($langArrayList as $key => $value) {
                        $selected = $templatelang == $key ? 'selected' : '';
                        echo "<option value='$key' $selected> $value </option>";
                    }
                ?>
            </select>
            <input type="hidden" name="thisid" value="<?php echo $_GET['id'] ?? ''; ?>">
            <button class="btn btn-primary mt-3 float-end" @click="changeLanguage()">{{ lang('setlanguage') }}</button>
        </div>
    </div>
</div>
