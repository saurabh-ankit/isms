<style>
  .user-img{
        position: absolute;
        height: 27px;
        width: 27px;
        object-fit: cover;
        left: -7%;
        top: -12%;
  }
  .btn-rounded{
        border-radius: 50px;
  }
</style>
<!-- Top Navigation Bar with Chakra UI styling -->
<header class="chakra-header">
    <div class="chakra-stack chakra-stack--horizontal" style="width: 100%; justify-content: space-between;">
        <!-- Left side - Menu toggle and brand -->
        <div class="chakra-stack chakra-stack--horizontal" style="align-items: center;">
            <button id="sidebarToggle" style="background: none; border: none; cursor: pointer; margin-right: 1rem; display: none; align-items: center; justify-content: center; padding: 0.5rem; border-radius: 0.375rem; color: var(--chakra-colors-gray-700);">
                <i class="fas fa-bars" style="font-size: 1.25rem;"></i>
            </button>
            
            <a href="<?php echo base_url ?>" style="text-decoration: none; color: var(--chakra-colors-gray-800); font-weight: 600; font-size: 1.125rem;">
                <?php echo (!isMobileDevice()) ? $_settings->info('name') : $_settings->info('short_name'); ?> - Admin
            </a>
        </div>
        
        <!-- Right side - Location selector and user info -->
        <div class="chakra-stack chakra-stack--horizontal" style="align-items: center;">
            <!-- Location selector -->
            <div class="location-selector" style="margin-right: 1.5rem;">
                <select onchange="changeLocation()" id="location-select" style="padding: 0.5rem 1rem; border-radius: 0.375rem; border: 1px solid var(--chakra-colors-gray-300); background-color: var(--chakra-colors-teal-500); color: white; font-size: 0.875rem;">
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
            
            <!-- User profile -->
            <div class="user-profile chakra-stack chakra-stack--horizontal" style="align-items: center;">
                <div class="user-avatar" style="position: relative; margin-right: 0.75rem;">
                    <img src="<?php echo validate_image($_settings->userdata('avatar1')) ?>" alt="User Avatar" style="width: 2.5rem; height: 2.5rem; border-radius: 50%; object-fit: cover; border: 2px solid var(--chakra-colors-gray-200);">
                </div>
                <div class="user-info">
                    <span style="font-weight: 600; color: var(--chakra-colors-gray-800);">
                        <?php echo ucwords($_settings->userdata('username').' '.$_settings->userdata('lastname')) ?>
                    </span>
                </div>
            </div>
        </div>
    </div>
</header>

<script>
function changeLocation() {
    $loc_id = document.getElementById('location-select').value
    start_loader();
    $.ajax({
        url: _base_url_ + "classes/Master.php?f=change_location",
        method: "POST",
        data: {
            loc_id: $loc_id
        },
        dataType: "json",
        error: err => {
            console.log("Error", err)
            alert_toast("An error occured.", 'error');
            end_loader();
        },
        success: function(resp) {
            if (typeof resp == 'object' && resp.status == 'success') {
                location.reload();
            } else {
                alert_toast("An error occured.", 'error');
                end_loader();
            }
        }
    })
}

// Apply responsive design for hamburger button visibility
document.addEventListener('DOMContentLoaded', function() {
    const sidebarToggle = document.getElementById('sidebarToggle');
    
    function adjustMenuVisibility() {
        if (window.innerWidth <= 768) {
            sidebarToggle.style.display = 'flex';
        } else {
            sidebarToggle.style.display = 'none';
        }
    }
    
    // Run on load
    adjustMenuVisibility();
    
    // Run on window resize
    window.addEventListener('resize', adjustMenuVisibility);
});
</script>