<div class="dropdown m-0 p-0">
<span class="" type="button" data-bs-toggle="dropdown" aria-expanded="false" >
    <?php 
        if(!isset($systemUrl)){
            $systemUrl = '';
        }
        
        switch ($templatelang) {
            case "Farsi":
                
            echo '<img src="' . $systemUrl . '/modules/addons/caasify/views/view/includes/assets/img/flags/farsi.png" alt="farsi" style="width:34px;">';
            break;

            case "English":
            echo '<img src="' . $systemUrl . '/modules/addons/caasify/views/view/includes/assets/img/flags/english.png" alt="english" style="width:34px;">';
            break;

            case "Turkish":
            echo '<img src="' . $systemUrl . '/modules/addons/caasify/views/view/includes/assets/img/flags/turkish.png" alt="turkish" style="width:34px;">';
            break;

            case "French":
            echo '<img src="' . $systemUrl . '/modules/addons/caasify/views/view/includes/assets/img/flags/france.png" alt="france" style="width:34px;">';
            break;
            
            case "Deutsch":
            echo '<img src="' . $systemUrl . '/modules/addons/caasify/views/view/includes/assets/img/flags/deutsch.png" alt="deutsch" style="width:34px;">';
            break;
            
            case "Russian":
            echo '<img src="' . $systemUrl . '/modules/addons/caasify/views/view/includes/assets/img/flags/russian.png" alt="russian" style="width:34px;">';
            break;
                
            case "Brizilian":
            echo '<img src="' . $systemUrl . '/modules/addons/caasify/views/view/includes/assets/img/flags/brizilian.png" alt="brizilian" style="width:34px;">';
            break;
            
            case "Italian":
            echo '<img src="' . $systemUrl . '/modules/addons/caasify/views/view/includes/assets/img/flags/italian.png" alt="italian" style="width:34px;">';
            break;

            default:
            echo '<img src="' . $systemUrl . '/modules/addons/caasify/views/view/includes/assets/img/flags/farsi.png" altfarsi style="width:34px;">';
        }
        ?>
    </span>
    <div class="dropdown-menu border-1 shadow-lg p-4" style="min-width: 300px !important;">
        <p class="fs-6">{{ lang('chooselanguage') }}</p>    
        <div>
            <select name="language" class="form-select" aria-label="Default select example" v-model="PanelLanguage">                
                <option value="English" <?php if( $templatelang == 'English'){echo 'selected';} ?>> English </option>
                <option value="Farsi" <?php if( $templatelang == 'Farsi'){echo 'selected';} ?>> فارسی </option>
                <option value="Turkish" <?php if( $templatelang == 'Turkish'){echo 'selected';} ?>> Türkçe </option>
                <option value="French" <?php if( $templatelang == 'French'){echo 'selected';} ?>> Français </option>
                <option value="Deutsch" <?php if( $templatelang == 'Deutsch'){echo 'selected';} ?>> Deutsch </option>
                <option value="Russian" <?php if( $templatelang == 'Russian'){echo 'selected';} ?>> Pусский </option>
                <option value="Brizilian" <?php if( $templatelang == 'Brizilian'){echo 'selected';} ?>> Brizilian </option>
                <option value="Italian" <?php if( $templatelang == 'Italian'){echo 'selected';} ?>> Italian </option>
            </select>
            <input type="hidden" name="thisid" value="<?php echo $_GET['id'] ?? ''; ?>">

            <button class="btn btn-primary mt-3 float-end" @click="changeLanguage()">{{ lang('setlanguage') }}</button>
        </div>
    </div>
</div>
