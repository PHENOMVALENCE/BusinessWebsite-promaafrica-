<div class="top-header">
    <div class="header-left">
        <button class="sidebar-toggle" id="sidebarToggle">
            <i class="fas fa-bars"></i>
        </button>
    </div>
    
    <div class="header-right">
        <div class="header-actions">
            <a href="../sales.php" target="_blank" class="btn-view-site">
                <i class="fas fa-external-link-alt"></i>
                View Site
            </a>
            
            <div class="user-menu">
                <button class="user-menu-toggle" id="userMenuToggle">
                    <i class="fas fa-user-circle"></i>
                    <span><?php echo htmlspecialchars($user['username']); ?></span>
                    <i class="fas fa-chevron-down"></i>
                </button>
                
                <div class="user-dropdown" id="userDropdown">
                    <a href="profile.php">
                        <i class="fas fa-user"></i>
                        Profile
                    </a>
                    <a href="logout.php">
                        <i class="fas fa-sign-out-alt"></i>
                        Logout
                    </a>
                </div>
            </div>
        </div>
    </div>
</div>
