<?php
include("connection.php");
$sql_admin="select * from commondb.admin_tbl where admin_id ='".$_SESSION['aid']."'"; 
$res_admin=$conn->query($sql_admin);
$row_admin=$res_admin->fetch();
$res_admin=null; 	 
?>
<body class="nav-md font1">
    <div class="container body">
      <div class="main_container">
        <div class="col-md-3 left_col">
          <div class="left_col scroll-view">
            <div class="navbar nav_title" style="border: 0;">
            <!--  <a href="dashboard.php" class="site_title"><img src="images/logo.png" class="img-responsive" style="max-height:85% !important"></a> -->
            </div>

            <div class="clearfix"></div>

		<!-- menu profile quick info
            <div class="profile">
              <div class="profile_pic">
                <img src="images/dp.jpg" alt="..." class="img-circle profile_img">
              </div>
              <div class="profile_info">
                
                <h2>Durgesh Panchal</h2>
              </div>
            </div>
            <!-- /menu profile quick info -->


		<!-- sidebar menu -->
            <div id="sidebar-menu" class="main_menu_side hidden-print main_menu ">
              <div class="menu_section">
                
                <ul class="nav side-menu">
					<li><a href="main_report.php"><i class="fa fa-home"></i> All in one Report</a></li>
					
					<li><a href="report.php"><i class="fa fa-home"></i> Main Report</a></li>
					<li><a href="perform.php"><i class="fa fa-home"></i> Perform Report</a></li>
					<li><a href="advertiser_publisher.php"><i class="fa fa-home"></i> Adv & Pub Report</a></li>
					<li><a href="trend_report.php"><i class="fa fa-home"></i> Trend Report</a></li>
					
					<li><a href="pub.php"><i class="fa fa-home"></i> Pub wise Act & Dct</a></li>
					<li><a><i class="fa fa-cogs"></i> Campaign Settings <span class="fa fa-chevron-down"></span></a>
					<ul class="nav child_menu">
						<li><a href="add_campaign.php"><i class="fa  fa-file-text-o"></i> Add Campaign</a></li>
						
						<li><a href="blocking.php"><i class="fa  fa-file-text-o"></i> Campaign Blocking</a></li>
						
						<li><a href="campaign_auto.php"><i class="fa  fa-file-text-o"></i> Campaign Automation</a></li>
					<!--	<li><a href="capping.php"><i class="fa  fa-file-text-o"></i> Campaign Capping</a></li> -->
				
					</ul>
					</li>
					
					<li><a><i class="fa fa-cogs"></i> Publisher Settings <span class="fa fa-chevron-down"></span></a>
					<ul class="nav child_menu">
						
						<li><a href="add_advertiser.php"><i class="fa  fa-file-text-o"></i> Add Publisher</a></li>
						
						<li><a href="advertiser_blocking.php"><i class="fa  fa-file-text-o"></i> Publisher Blocking</a></li>
						<!-- <li><a href="advertiser_campaign_blocking.php"><i class="fa  fa-file-text-o"></i> Publisher Campaign wise Blocking</a></li> -->
					
						
					</ul>
					</li>
					
					<li><a><i class="fa fa-cogs"></i> Settings <span class="fa fa-chevron-down"></span></a>
					<ul class="nav child_menu">
						
						<li><a href="new_config.php"><i class="fa  fa-file-text-o"></i> New Configuration</a></li>
						<li><a href="add_operator.php"><i class="fa  fa-file-text-o"></i> Add Operator</a></li>
					<!--	<li><a href="pubid_blocking.php"><i class="fa  fa-file-text-o"></i> PubID wise Blocking</a></li> -->
					<!--	<li><a href="operator_setting.php"><i class="fa  fa-file-text-o"></i> Operator Blocking</a></li> -->
					</ul>
					</li>
				<!--	<li><a href="counter_reset.php"><i class="fa fa-home"></i> Counter Reset </a></li> -->
				<!--	<li><a href="pending_cbs.php"><i class="fa fa-home"></i> Pending Callbacks </a></li> -->
				<!--	<li><a href="pending_cbs.php"><i class="fa fa-home"></i> Pending Callbacks </a></li> -->
				<!--	<li><a href="https://gamebar.mobi/api/report/"><i class="fa fa-home"></i> API Report</a></li> -->
				
			<!--	
.			<li><a href="pnl.php"><i class="fa fa-home"></i> Profit & Loss Report </a></li>
					<li><a href="payout.php"><i class="fa fa-dollar"></i> Payout</a></li>
				
		<li><a href="register.php"><i class="fa fa-file-text-o"></i> Advertiser Registration</a></li> -->
                </ul>
              </div>

            </div>
            <!-- /sidebar menu -->
			
			<!-- /menu footer buttons -->
            <div class="sidebar-footer hidden-small">
              <a data-toggle="tooltip" data-placement="top" title="Settings">
                <span class="glyphicon glyphicon-cog" aria-hidden="true"></span>
              </a>
              <a data-toggle="tooltip" data-placement="top" title="FullScreen">
                <span class="glyphicon glyphicon-fullscreen" aria-hidden="true"></span>
              </a>
              <a data-toggle="tooltip" data-placement="top" title="Lock">
                <span class="glyphicon glyphicon-eye-close" aria-hidden="true"></span>
              </a>
              <a data-toggle="tooltip" data-placement="top" title="Logout">
                <span class="glyphicon glyphicon-off" aria-hidden="true"></span>
              </a>
            </div>
            <!-- /menu footer buttons -->
		</div>
        </div>