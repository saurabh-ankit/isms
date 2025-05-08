<?php 
require_once('../config.php'); 

// Direct session check - redirect to login if not logged in
if(!isset($_SESSION['userdata']) || !isset($_SESSION['userdata']['login_type'])) {
    header('Location: '.base_url.'admin/login.php');
    exit;
}
?>
<!DOCTYPE html>
<html lang="en" style="height: 100%;">
<?php require_once('inc/header.php') ?>
<body class="chakra-ui" style="height: 100%; background-color: var(--chakra-colors-gray-100);">
    <div class="chakra-responsive-layout">
        <div class="top-header" style="width: 100%; border-bottom: 1px solid #e2e8f0; background-color: white; padding: 0.75rem 1.5rem; display: flex; justify-content: space-between; align-items: center;">
            <div class="site-logo" style="display: flex; align-items: center;">
                <button id="sidebarToggle" aria-label="Toggle navigation">
                    <i class="fas fa-bars"></i>
                </button>
                <img src="<?php echo validate_image($_settings->info('logo'))?>" alt="Logo" style="height: 2.5rem; width: auto; margin-right: 1rem;">
                <h1 style="font-size: 1.25rem; font-weight: 600; margin: 0;">Rely Inventory And Vendor Management - Admin</h1>
            </div>
            <div class="header-actions" style="display: flex; align-items: center; gap: 1rem;">
                <div class="location-selector" style="margin-right: 1rem;">
                    <select onchange="changeLocation()" id="location-select" style="padding: 0.5rem 2rem 0.5rem 1rem; border-radius: 0.375rem; border: 1px solid #e2e8f0; background-color: var(--chakra-colors-teal-600); color: white; font-size: 0.875rem; appearance: none; position: relative; background-image: url('data:image/svg+xml;charset=US-ASCII,<svg xmlns=\"http://www.w3.org/2000/svg\" width=\"14\" height=\"14\" viewBox=\"0 0 24 24\" fill=\"none\" stroke=\"white\" stroke-width=\"2\" stroke-linecap=\"round\" stroke-linejoin=\"round\"><path d=\"M6 9l6 6 6-6\"/></svg>'); background-repeat: no-repeat; background-position: right 0.5rem center;">
                        <option>Select Location</option>
                        <?php 
                        $locations = $_settings->userdata('locations');
                        if(isset($locations) && is_array($locations)): 
                        ?>
                            <?php foreach ($locations as $values): ?>
                                <option value="<?php echo $values['id'] ?>" <?php if($_settings->userdata('loc_id') == $values['id']) echo 'selected' ?>>
                                    <?php echo $values['name'] ?>
                                </option>
                            <?php endforeach; ?>
                        <?php endif; ?>
                    </select>
                </div>
                <div class="user-info" style="display: flex; align-items: center;">
                    <span style="font-weight: 600; margin-right: 0.5rem;">Admin Admin</span>
                    <img src="<?php echo validate_image($_settings->userdata('avatar1')) ?>" alt="User Avatar" style="width: 2.25rem; height: 2.25rem; border-radius: 50%; object-fit: cover; border: 2px solid var(--chakra-colors-gray-200);">
                </div>
            </div>
        </div>
        
        <div style="display: flex; flex-direction: row; height: calc(100vh - 4.5rem);">
            <!-- Sidebar Navigation -->
            <?php require_once('inc/navigation.php') ?>
            
            <!-- Main Content Area -->
            <div class="chakra-main">
                <?php if($_settings->chk_flashdata('success')): ?>
                <script>
                    alert_toast("<?php echo $_settings->flashdata('success') ?>",'success')
                </script>
                <?php endif;?>
                
                <!-- Main content -->
                <div class="content-area" style="padding: 1.5rem; min-height: calc(100vh - 4.5rem);">
                    <?php $page = isset($_GET['page']) ? $_GET['page'] : 'home'; ?>
                    <div style="background-color: white; border-radius: 0.5rem; box-shadow: 0 1px 3px rgba(0,0,0,0.1); padding: 1.5rem; margin-bottom: 1.5rem;">
                        <?php 
                        if(!file_exists($page.".php") && !is_dir($page)){
                            include '404.html';
                        } else {
                            if(is_dir($page))
                                include $page.'/index.php';
                            else
                                include $page.'.php';
                        }
                        ?>
                    </div>
                </div>
                
                <!-- Footer -->
                <footer style="background-color: white; padding: 1rem; text-align: center; border-top: 1px solid var(--chakra-colors-gray-200);">
                    <p style="margin: 0; color: var(--chakra-colors-gray-600); font-size: 0.875rem;">
                        &copy; 2025 <?php echo $_settings->info('name') ?>
                    </p>
                </footer>
            </div>
        </div>
        
        <!-- Modals -->
        <div class="modal fade" id="uni_modal" role='dialog'>
            <div class="modal-dialog modal-md modal-dialog-centered rounded-0" role="document">
                <div class="modal-content rounded-0">
                    <div class="modal-header">
                        <h5 class="modal-title"></h5>
                    </div>
                    <div class="modal-body">
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-primary rounded-0" id='submit' onclick="$('#uni_modal form').submit()">Save</button>
                        <button type="button" class="btn btn-secondary rounded-0" data-dismiss="modal">Cancel</button>
                    </div>
                </div>
            </div>
        </div>
        
        <div class="modal fade" id="uni_modal_right" role='dialog'>
            <div class="modal-dialog modal-full-height modal-md rounded-0" role="document">
                <div class="modal-content rounded-0">
                    <div class="modal-header">
                        <h5 class="modal-title"></h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span class="fa fa-arrow-right"></span>
                        </button>
                    </div>
                    <div class="modal-body">
                    </div>
                </div>
            </div>
        </div>
        
        <div class="modal fade" id="confirm_modal" role='dialog'>
            <div class="modal-dialog modal-md modal-dialog-centered rounded-0" role="document">
                <div class="modal-content rounded-0">
                    <div class="modal-header">
                        <h5 class="modal-title">Confirmation</h5>
                    </div>
                    <div class="modal-body">
                        <div id="delete_content"></div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-primary rounded-0" id='confirm' onclick="">Continue</button>
                        <button type="button" class="btn btn-secondary rounded-0" data-dismiss="modal">Close</button>
                    </div>
                </div>
            </div>
        </div>
        
        <div class="modal fade" id="viewer_modal" role='dialog'>
            <div class="modal-dialog modal-md" role="document">
                <div class="modal-content">
                    <button type="button" class="btn-close" data-dismiss="modal"><span class="fa fa-times"></span></button>
                    <img src="" alt="">
                </div>
            </div>
        </div>
    </div>
    
    <?php require_once('inc/footer.php') ?>
    
    <script>
        // Mobile responsive handling
        $(document).ready(function() {
            function adjustForMobileView() {
                if ($(window).width() < 768) {
                    $('.chakra-sidebar').css('transform', 'translateX(-100%)');
                    $('.chakra-main').css('margin-left', '0');
                    $('.chakra-main').css('width', '100%');
                } else {
                    $('.chakra-sidebar').css('transform', 'translateX(0)');
                    $('.chakra-main').css('width', '80%');
                }
            }
            
            // Run on load and resize
            adjustForMobileView();
            $(window).resize(adjustForMobileView);
            
            // Toggle sidebar on mobile
            $('#sidebarToggle').click(function() {
                if ($(window).width() < 768) {
                    if ($('.chakra-sidebar').css('transform') === 'matrix(1, 0, 0, 1, 0, 0)') {
                        $('.chakra-sidebar').css('transform', 'translateX(-100%)');
                    } else {
                        $('.chakra-sidebar').css('transform', 'translateX(0)');
                    }
                }
            });
        });
    </script>
</body>
</html>
