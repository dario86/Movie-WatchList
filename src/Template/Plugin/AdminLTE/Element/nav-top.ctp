<nav class="navbar navbar-static-top">
    <!-- Sidebar toggle button-->
    <a href="#" class="sidebar-toggle" data-toggle="offcanvas" role="button">
        <span class="sr-only">Toggle navigation</span>
    </a>

    <div class="navbar-custom-menu">
        <ul class="nav navbar-nav">
            <!-- User Account: style can be found in dropdown.less -->
            <li class="dropdown user user-menu">
                <?php if ($authUser): ?>
                <li>
                    <a href="/logout">
                        <span class="hidden-xs">Logout</span>
                    </a>
                </li>
            <?php endif; ?>
        </ul>
    </div>
</nav>