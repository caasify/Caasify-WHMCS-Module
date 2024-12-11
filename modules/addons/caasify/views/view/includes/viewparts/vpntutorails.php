<!-- tutorial -->
<div class="d-flex flex-row justify-content-between align-items-center mb-5">
    <div class="">
        <p class="text-secondary fs-5 m-0 p-0">
            <i class="bi bi-bookmark-plus h4"></i>
            <span class="text-secondary m-0 p-0 ps-4">
                {{ lang('Tutorials') }}
            </span>
        </p>
    </div>
</div>
<div class="accordion" id="accordionExample">
    <!-- Windows -->
    <div class="accordion-item">
        <h2 class="accordion-header">
            <button class="accordion-button" type="button" data-bs-toggle="collapse" data-bs-target="#collapseOne" aria-expanded="true" aria-controls="collapseOne">
                Windows
            </button>
        </h2>
        <div id="collapseOne" class="accordion-collapse collapse show" data-bs-parent="#accordionExample">
            <div class="accordion-body">
                <p>
                    <strong>App:</strong> 
                    <a href="https://github.com/hiddify/hiddify-app/releases/latest/download/Hiddify-Windows-Setup-x64.Msi" target="_blank" class="btn btn-primary btn-sm px-4 ms-3">Hiddify</a>
                </p>
                <?php  include('./includes/viewparts/turor.php') ?>
            </div>
        </div>
    </div>

    <!-- Android -->
    <div class="accordion-item">
        <h2 class="accordion-header">
            <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#collapseTwo" aria-expanded="false" aria-controls="collapseTwo">
                Android
            </button>
        </h2>
        <div id="collapseTwo" class="accordion-collapse collapse" data-bs-parent="#accordionExample">
            <div class="accordion-body">
                <p>
                    <strong>App:</strong> 
                    <a href="https://play.google.com/store/apps/details?id=app.hiddify.com" target="_blank" class="btn btn-primary btn-sm px-4 mx-2">Hiddify</a>
                </p>
                <?php  include('./includes/viewparts/turor.php') ?>
            </div>
        </div>
    </div>
    <!-- iPhone IOS -->
    <div class="accordion-item">
        <h2 class="accordion-header">
            <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#collapseThree" aria-expanded="false" aria-controls="collapseThree">
                iPhone IOS
            </button>
        </h2>
        <div id="collapseThree" class="accordion-collapse collapse" data-bs-parent="#accordionExample">
            <div class="accordion-body">
                <p>
                    <strong>App:</strong> 
                    <a href="https://apps.apple.com/us/app/hiddify-proxy-vpn/id6596777532?platform=iphone" target="_blank" class="btn btn-primary btn-sm px-4 ms-3">Hiddify</a>
                </p>
                <?php  include('./includes/viewparts/turor.php') ?>
            </div>
        </div>
    </div>
    <!-- Mac OS -->
    <div class="accordion-item">
        <h2 class="accordion-header">
            <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#collapseFour" aria-expanded="false" aria-controls="collapseFour">
                Mac OS
            </button>
        </h2>
        <div id="collapseFour" class="accordion-collapse collapse" data-bs-parent="#accordionExample">
            <div class="accordion-body">
                <p>
                    <strong>App:</strong> 
                    <a href="https://github.com/hiddify/hiddify-app/releases/latest/download/Hiddify-MacOS.dmg" target="_blank" class="btn btn-primary btn-sm px-4 ms-3">Hiddify</a>
                </p>
                <?php  include('./includes/viewparts/turor.php') ?>
            </div>
        </div>
    </div>
    <!-- Linux -->
    <div class="accordion-item">
        <h2 class="accordion-header">
            <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#collapseFive" aria-expanded="false" aria-controls="collapseFive">
                Linux
            </button>
        </h2>
        <div id="collapseFive" class="accordion-collapse collapse" data-bs-parent="#accordionExample">
            <div class="accordion-body">
                <p>
                    <strong>App:</strong> 
                    <a href="https://github.com/hiddify/hiddify-app/releases/latest/download/Hiddify-Linux-x64.AppImage" target="_blank" class="btn btn-primary btn-sm px-4 ms-3">Hiddify</a>
                </p>
                <?php  include('./includes/viewparts/turor.php') ?>
            </div>
        </div>
    </div>
</div>

