<body class="animsition site-menubar-fold site-menubar-keep">
    <!--[if lt IE 8]>
        <p class="browserupgrade">You are using an <strong>outdated</strong> browser. Please <a href="http://browsehappy.com/">upgrade your browser</a> to improve your experience.</p>
    <![endif]-->

    <nav class="site-navbar navbar navbar-default navbar-fixed-top navbar-mega" role="navigation">

      <div class="navbar-header">
        <button type="button" class="navbar-toggler hamburger hamburger-close navbar-toggler-left hided"
          data-toggle="menubar">
          <span class="sr-only">Toggle navigation</span>
          <span class="hamburger-bar"></span>
        </button>
        <button type="button" class="navbar-toggler collapsed" data-target="#site-navbar-collapse"
          data-toggle="collapse">
          <i class="icon md-more" aria-hidden="true"></i>
        </button>
        <div class="navbar-brand navbar-brand-center site-gridmenu-toggle" style="padding-left: 0px;" data-toggle="gridmenu">
		<a href="<?php echo 'https://drones-pov.com'; ?>">
		  <img class="navbar-brand-logo" src="<?php echo DRONESPOV_IMAGE . 'logo-menu.png'; ?>" width="100" height="auto" title="Remark">
	  	</a>
        </div>
        <button type="button" class="navbar-toggler collapsed" data-target="#site-navbar-search"
          data-toggle="collapse">
          <span class="sr-only">Toggle Search</span>
          <i class="icon md-search" aria-hidden="true"></i>
        </button>
      </div>

      <div class="navbar-container container-fluid">
        <!-- Navbar Collapse -->
        <div class="collapse navbar-collapse navbar-collapse-toolbar" id="site-navbar-collapse">
          <!-- Navbar Toolbar -->
          <ul class="nav navbar-toolbar">
			<li class="nav-item hidden-sm-down" id="toggleFullscreen">
              <a class="nav-link icon icon-fullscreen" data-toggle="fullscreen" href="#" role="button">
                <span class="sr-only">Toggle fullscreen</span>
              </a>
            </li>
          </ul>
          <!-- End Navbar Toolbar -->

          <!-- Navbar Toolbar Right -->
          <ul class="nav navbar-toolbar navbar-right navbar-toolbar-right">
            <li class="nav-item dropdown">
              <a class="nav-link navbar-avatar" data-toggle="dropdown" href="#" aria-expanded="false"
                data-animation="scale-up" role="button">
				<div class="avatar avatar-online" style="width: auto;">
                  <?php echo $name; ?>
			  	</div>
              </a>
              <div class="dropdown-menu" role="menu">
				<?php if(!current_user_can('administrator')) : ?>
			  	<a class="dropdown-item" href="<?php echo site_url() . '/client/account/'; ?>" role="menuitem"><i class="icon md-account-o" aria-hidden="true"></i> Account</a>
				<?php endif; ?>
				<a class="dropdown-item" href="<?php echo site_url() . '/logout/'; ?>" role="menuitem"><i class="icon md-power" aria-hidden="true"></i> Logout</a>
              </div>
            </li>
          </ul>
          <!-- End Navbar Toolbar Right -->
        </div>
        <!-- End Navbar Collapse -->

      </div>
    </nav>
	<div class="site-menubar">
      <div class="site-menubar-body">
        <div>
          <div>
            <ul class="site-menu" data-plugin="menu">
			  <?php if(current_user_can('administrator')) : ?>
              <li class="site-menu-item">
                <a class="animsition-link" href="<?php echo site_url() . '/admin/create_invoice/'; ?>">
                    <i class="site-menu-icon md-file-plus" aria-hidden="true"></i>
                    <span class="site-menu-title">Create</span>
                </a>
              </li>
              <li class="site-menu-item has-sub">
                <a href="<?php echo site_url() . '/admin/list_invoice/?type=invoices'; ?>">
                    <i class="site-menu-icon md-file" aria-hidden="true"></i>
                    <span class="site-menu-title">Sales</span>
                </a>
              </li>
              <li class="site-menu-item has-sub">
                <a href="<?php echo site_url() . '/admin/price_calculator/'; ?>">
                    <i class="site-menu-icon fa-calculator" style="font-size: 20px;" aria-hidden="true"></i>
                    <span class="site-menu-title">Calculator</span>
                </a>
              </li>
              <li class="site-menu-item has-sub">
                <a href="<?php echo site_url() . '/admin/deleted_invoice/'; ?>">
                    <i class="site-menu-icon md-delete" aria-hidden="true"></i>
                    <span class="site-menu-title">Trash</span>
                </a>
              </li>
				<?php endif; ?>
				<?php
				$user_id = get_current_user_id();
				$roles = get_userdata($user_id)->roles;
				if (in_array('dronespov_client', $roles)) : ?>
                <li class="site-menu-item has-sub">
                  <a href="<?php echo site_url() . '/client/list_invoice/?type=invoices'; ?>">
                      <i class="site-menu-icon md-file" aria-hidden="true"></i>
                      <span class="site-menu-title">Statements</span>
                  </a>
                </li>
  				<?php endif; ?>
                </ul>
              </li>
            </ul>
		  </div>
        </div>
      </div>
    </div>
