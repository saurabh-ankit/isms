<style>
.sidebar a.nav-link.active {
    color: #fff !important;
}

.bg-primus {
    background: #075963 !important;
}

.text-while {
    color: #ffffff !important;
}

/* Dropdown menu styling */
.submenu {
    background-color: var(--chakra-colors-teal-700);
    overflow: hidden;
    transition: max-height 0.3s ease;
}

.submenu a {
    padding: 0.75rem 0 !important;
    text-align: center !important;
    display: block !important;
}

.menu-header {
    cursor: pointer;
    text-align: center;
}

.menu-header .fa-angle-down {
    transition: transform 0.3s ease;
    margin-left: 5px !important;
}

.menu-header.active .fa-angle-down {
    transform: rotate(180deg);
}

/* Brand section */
.brand-section {
    padding: 1.25rem 1.5rem;
    display: flex;
    align-items: center;
    justify-content: center;
    border-bottom: 1px solid rgba(255,255,255,0.1);
}

.brand-logo {
    width: 2.5rem;
    height: 2.5rem;
    border-radius: 50%;
    margin-right: 0.75rem;
    display: flex;
    align-items: center;
    justify-content: center;
    background-color: white;
    color: var(--chakra-colors-teal-600);
    font-weight: bold;
    font-size: 1.25rem;
}

.brand-name {
    color: white;
    font-weight: 600;
    font-size: 1.125rem;
}

/* Section divider */
.section-divider {
    padding: 0.5rem 0;
    font-size: 0.75rem;
    text-transform: uppercase;
    color: rgba(255,255,255,0.7);
    font-weight: 500;
    letter-spacing: 0.5px;
    text-align: center;
}

/* Category active state */
.active-category, .active-menu-item {
    background-color: #154954 !important;
}

/* Font sizes */
.nav-icon {
    font-size: 18px;
    width: 100%;
    margin: 0 auto 5px;
    text-align: center;
    display: block;
}

.nav-text {
    font-size: 12px;
    text-align: center;
    display: block;
}

/* Mobile responsiveness */
@media (max-width: 768px) {
    .chakra-sidebar {
        width: auto;
        max-width: auto;
        min-width: auto;
    }
    
    nav.sidebar-nav {
        width: auto !important;
        max-width: auto !important;
        min-width: auto !important;
    }
    
    .submenu a span {
        display: block;
        text-align: center;
        width: 100%;
    }
}

.chakra-sidebar a.active-menu-item {
    background-color: var(--chakra-colors-teal-700) !important;
    color: var(--chakra-colors-orange-500) !important;
    font-weight: 600;
}


</style>
<!-- Main Sidebar Container with Chakra UI styling -->
<aside class="chakra-sidebar" id="sidebar">
    <!-- Brand Logo -->
    <!-- <div class="brand-section">
        <div class="brand-logo">
            P
        </div>
        <div class="brand-name">
            Primus - FnB
        </div>
    </div> -->

    <!-- Sidebar Menu -->
    <nav class="sidebar-nav" style="padding: 0.5rem 0; width: 78px; max-width: 250px; min-width: auto; position: relative; display: flex; flex-direction: column;">
        <div class="chakra-stack chakra-stack--vertical">
            <a href="./" class="nav-link nav-home" style="display: block; text-align: center; padding: 0.75rem 0.5rem; color: white; text-decoration: none; transition: background-color 0.2s;">
                <i class="nav-icon fas fa-th"></i>
                <span class="nav-text">Dashboard</span>
            </a>
            
            <a href="./?page=department" class="nav-link nav-department" style="display: block; text-align: center; padding: 0.75rem 0.5rem; color: white; text-decoration: none; transition: background-color 0.2s;">
                <i class="nav-icon fas fa-code-branch"></i>
                <span class="nav-text">Department List</span>
            </a>
            
            <a href="./?page=categories" class="nav-link nav-categories" style="display: block; text-align: center; padding: 0.75rem 0.5rem; color: white; text-decoration: none; transition: background-color 0.2s;">
                <i class="nav-icon fas fa-th-list"></i>
                <span class="nav-text">Category List</span>
            </a>
            
            <a href="./?page=items" class="nav-link nav-items" style="display: block; text-align: center; padding: 0.75rem 0.5rem; color: white; text-decoration: none; transition: background-color 0.2s;">
                <i class="nav-icon fas fa-cubes"></i>
                <span class="nav-text">Item List</span>
            </a>
            
            <a href="./?page=stocks" class="nav-link nav-stocks" style="display: block; text-align: center; padding: 0.75rem 0.5rem; color: white; text-decoration: none; transition: background-color 0.2s;">
                <i class="nav-icon fas fa-boxes"></i>
                <span class="nav-text">Stock Manager</span>
            </a>
            
            <?php if($_settings->userdata('type') == 1): ?>
            <!-- Reports Dropdown Menu -->
            <div class="reports-menu-container">
                <div class="menu-header nav-link nav-reports" style="display: block; text-align: center; padding: 0.75rem 0.5rem; color: white; cursor: pointer; transition: background-color 0.2s;" onclick="toggleReportsMenu()">
                    <i class="nav-icon fas fa-table"></i>
                    <span class="nav-text">Reports <i class="fas fa-angle-down" style="transition: transform 0.2s;"></i></span>
                </div>
                <div id="reports-submenu" class="submenu" style="max-height: 0; transition: max-height 0.3s ease; overflow: hidden; background-color: #1d5963; list-style-type: none; padding: 0;">
                    <a href="./?page=reports/stockin" class="nav-link nav-reports_stockin" style="color: white; text-decoration: none; transition: background-color 0.2s;">
                        <span class="nav-text">Stock-In</span>
                    </a>
                    <a href="./?page=reports/stockout" class="nav-link nav-reports_stockout" style="color: white; text-decoration: none; transition: background-color 0.2s;">
                        <span class="nav-text">Stock-Out</span>
                    </a>
                    <a href="./?page=reports/waste" class="nav-link nav-reports_waste" style="color: white; text-decoration: none; transition: background-color 0.2s;">
                        <span class="nav-text">Stock-Waste</span>
                    </a>
                </div>
            </div>
            
            <div class="section-divider" style="font-size: 9px; !im
            ">MAINTENANCE</div>
            
            <a href="<?php echo base_url ?>admin/?page=vendor/list" class="nav-link nav-vendor_list" style="display: block; text-align: center; padding: 0.75rem 0.5rem; color: white; text-decoration: none; transition: background-color 0.2s;">
                <i class="nav-icon fas fa-users"></i>
                <span class="nav-text">Vendor List</span>
            </a>
            <?php endif; ?>
        </div>
    </nav>
</aside>

<script>
function toggleSubmenu(id) {
    const submenu = document.getElementById(id);
    const menuHeader = submenu.previousElementSibling;
    
    if (submenu.style.maxHeight === '0px' || submenu.style.maxHeight === '') {
        submenu.style.maxHeight = submenu.scrollHeight + 'px';
        menuHeader.classList.add('active');
    } else {
        submenu.style.maxHeight = '0px';
        menuHeader.classList.remove('active');
    }
}

function toggleReportsMenu() {
    const reportsSubmenu = document.getElementById('reports-submenu');
    const menuHeader = reportsSubmenu.previousElementSibling;
    
    // Toggle the submenu
    if (reportsSubmenu.style.maxHeight === '0px' || reportsSubmenu.style.maxHeight === '') {
        reportsSubmenu.style.maxHeight = reportsSubmenu.scrollHeight + 'px';
        menuHeader.classList.add('active-menu-item');
    } else {
        reportsSubmenu.style.maxHeight = '0px';
        if (!isReportPageActive()) {
            menuHeader.classList.remove('active-menu-item');
        }
    }
    
    // Deactivate other menu items
    $('.nav-link').not(menuHeader).not('.submenu .nav-link').removeClass('active-menu-item');
}

function isReportPageActive() {
    var page = '<?php echo isset($_GET['page']) ? $_GET['page'] : 'home' ?>';
    return page.startsWith('reports/');
}

$(document).ready(function() {
    // Highlight active menu item
    var page = '<?php echo isset($_GET['page']) ? $_GET['page'] : 'home' ?>';
    page = page.replace(/\//g, '_');
    
    // Clear all active states first
    $('.nav-link').removeClass('active-menu-item');
    
    // If this is a reports page, highlight the reports header
    if (page.startsWith('reports_')) {
        $('.nav-link.nav-reports').addClass('active-menu-item');
        
        // Open the submenu
        const submenu = document.getElementById('reports-submenu');
        if (submenu) {
            submenu.style.maxHeight = submenu.scrollHeight + 'px';
        }
        
        // Highlight the specific report item
        $('.nav-link.nav-' + page).addClass('active-menu-item');
    } else {
        // For non-report pages, highlight the regular menu item
        $('.nav-link.nav-' + page).addClass('active-menu-item');
    }
    
    // Handle responsive sidebar toggle
    $('#sidebarToggle').click(function() {
        $('#sidebar').toggleClass('show');
        $('body').toggleClass('sidebar-open');
    });
    
    // Adjust submenu height when window is resized
    $(window).resize(function() {
        const submenu = document.getElementById('reports-submenu');
        if (submenu && submenu.style.maxHeight !== '0px') {
            submenu.style.maxHeight = submenu.scrollHeight + 'px';
        }
    });
});
</script>