<?php
error_reporting(0);
include("includes/check_session.php");
include("includes/connection.php");
include("../includes/language.php");


$commondb="commondb";

$count=0;


//country fetch karva

$sql_country="select * from ".$commondb.".country_tbl";
$res_country=$conn->query($sql_country);

$sql_operator="select distinct operator from ".$commondb.".ip_operator_tbl";
$res_operator=$conn->query($sql_operator);

if(isset($_POST['submit']))
{
	$operator=strtolower($_POST['operator']); 
	$product="glamour";
	
	
	foreach($_POST['operator'] as $operator)
	{
		 	
		
		if(strtolower($operator) == 'vodafone')
		{
			$logdb="voda_".$product."db";	
		}
		
		else
		{
			$logdb=$operator."_".$product."db_2017";	
		}
		$logdb=strtolower($logdb); 
			
		
		//Create Database
		$create_db="CREATE DATABASE IF NOT EXISTS ".strtolower($logdb) ;
		$res_db=$conn->query($create_db);
	
	
	
	
	//Create Tables
	
	
	$advertiser_blocking_tbl="CREATE TABLE IF NOT EXISTS ".$logdb.".`advertiser_blocking_tbl` (
	  `ad_block_id` int(11) NOT NULL AUTO_INCREMENT,
	  `campaign_id` int(11) NOT NULL,
	  `advertiser_id` int(11) NOT NULL,
	  PRIMARY KEY (`ad_block_id`,`campaign_id`,`advertiser_id`)
	) ENGINE=InnoDB AUTO_INCREMENT=1 DEFAULT CHARSET=latin1;";
	$res_advertiser_blocking_tbl=$conn->query($advertiser_blocking_tbl);
		
	$advertiser_callback_counter_tbl="CREATE TABLE IF NOT EXISTS ".$logdb.".`advertiser_callback_counter_tbl` (
	  `ad_callback_counter_id` bigint(15) NOT NULL AUTO_INCREMENT,
	  `advertiser_id` bigint(15) DEFAULT NULL,
	  `spo_callback_counter` int(11) DEFAULT NULL,
	  `act_callback_counter` int(11) DEFAULT NULL,
	  PRIMARY KEY (`ad_callback_counter_id`)
	) ENGINE=InnoDB AUTO_INCREMENT=1 DEFAULT CHARSET=latin1;";
	$res_advertiser_callback_counter_tbl=$conn->query($advertiser_callback_counter_tbl);
	
	$advertiser_response_tbl="CREATE TABLE IF NOT EXISTS ".$logdb.".`advertiser_response_tbl` (
		  `ad_resp_id` bigint(20) NOT NULL AUTO_INCREMENT,
		  `advertiser_callbackurl` varchar(1000) DEFAULT NULL,
		  `clickid` bigint(20) DEFAULT NULL,
		  `advertiser_clickid` varchar(100) DEFAULT NULL,
		  `pubid` varchar(100) DEFAULT NULL,
		  `ad_resp_datetime` datetime DEFAULT NULL,
		  `action` varchar(45) DEFAULT NULL,
		  `campaign_id` bigint(20) DEFAULT NULL,
		  `advertiser_id` bigint(20) DEFAULT NULL,
		  `advertiser_response` varchar(500) DEFAULT NULL,
		  PRIMARY KEY (`ad_resp_id`),
		  KEY `ind_clickid` (`clickid`),
		  KEY `ind_pubid` (`pubid`),
		  KEY `ind_ad_resp_datetime` (`ad_resp_datetime`),
		  KEY `ind_advertiser_id` (`advertiser_id`),
		  KEY `ind_campaign_id` (`campaign_id`)
		) ENGINE=InnoDB AUTO_INCREMENT=1 DEFAULT CHARSET=latin1;";
	$res_advertiser_response_tbl=$conn->query($advertiser_response_tbl);



	$campaign_request_tbl="CREATE TABLE IF NOT EXISTS ".$logdb.".`campaign_request_tbl` (
	  `camp_req_id` bigint(20) NOT NULL AUTO_INCREMENT,
	  `camp_req_url` varchar(1000) DEFAULT NULL,
	  `clickid` bigint(20) DEFAULT NULL,
	  `pubid` varchar(100) DEFAULT NULL,
	  `camp_req_datetime` datetime DEFAULT NULL,
	  `campaign_id` bigint(20) DEFAULT NULL,
	  `advertiser_id` bigint(20) DEFAULT NULL,
	  PRIMARY KEY (`camp_req_id`),
	  KEY `ind_clickid` (`clickid`),
	  KEY `ind_pubid` (`pubid`),
	  KEY `ind_camp_req_datetime` (`camp_req_datetime`),
	  KEY `ind_campaign_id` (`campaign_id`),
	  KEY `ind_advertiser_id` (`advertiser_id`)
	) ENGINE=InnoDB AUTO_INCREMENT=1 DEFAULT CHARSET=latin1;";
	$res_campaign_request_tbl=$conn->query($campaign_request_tbl);

	$campaign_response_tbl="CREATE TABLE IF NOT EXISTS ".$logdb.".`campaign_response_tbl` (
		  `camp_resp_id` int(2) NOT NULL AUTO_INCREMENT,
		  `clickid` bigint(20) DEFAULT NULL,
		  `pubid` varchar(100) DEFAULT NULL,
		  `camp_resp_datetime` datetime DEFAULT NULL,
		  `camp_action` varchar(45) DEFAULT NULL,
		  `campaign_id` int(2) DEFAULT NULL,
		  `advertiser_id` bigint(20) DEFAULT NULL,
		  PRIMARY KEY (`camp_resp_id`),
		  KEY `ind_clickid` (`clickid`),
		  KEY `ind_pubid` (`pubid`),
		  KEY `ind_camp_resp_datetime` (`camp_resp_datetime`),
		  KEY `ind_campaign_id` (`campaign_id`),
		  KEY `ind_advertiser_id` (`advertiser_id`)
		) ENGINE=InnoDB AUTO_INCREMENT=1 DEFAULT CHARSET=latin1;
		";
	$res_campaign_response_tbl=$conn->query($campaign_response_tbl);

	$campaign_tbl="CREATE TABLE IF NOT EXISTS ".$logdb.".`campaign_tbl` (
		  `campaign_id` bigint(20) NOT NULL AUTO_INCREMENT,
		  `campaign_partner` varchar(50) DEFAULT NULL,
		  `campaign_title` varchar(45) DEFAULT NULL,
		  `campaign_url` varchar(500) DEFAULT NULL,
		  `campaign_price` bigint(5) DEFAULT NULL,
		  `campaign_operator` varchar(30) DEFAULT NULL,
		  `campaign_live` int(2) DEFAULT NULL,
		  `campaign_startdatetime` datetime DEFAULT NULL,
		  `campaign_enddatetime` datetime DEFAULT NULL,
		  `campaign_weight` int(2) DEFAULT NULL,
		  `campaign_weight_track` int(2) DEFAULT NULL,
		  `campaign_country` int(3) DEFAULT NULL,
		  `campaign_category` varchar(45) DEFAULT NULL,
		  `campaign_browser` varchar(45) DEFAULT NULL,
		  `campaign_os` varchar(45) DEFAULT NULL,
		  PRIMARY KEY (`campaign_id`),
		  KEY `ind_camp_browser` (`campaign_browser`),
		  KEY `ind_camp_os` (`campaign_os`)
		) ENGINE=InnoDB AUTO_INCREMENT=1 DEFAULT CHARSET=latin1;";
	$res_campaign_tbl=$conn->query($campaign_tbl);

	$campaign_tracking_tbl="CREATE TABLE IF NOT EXISTS ".$logdb.".`campaign_tracking_tbl` (
	`camp_track_id` int(2) NOT NULL AUTO_INCREMENT,
	`campaign_id` int(2) DEFAULT NULL,
	PRIMARY KEY (`camp_track_id`)
	) ENGINE=InnoDB AUTO_INCREMENT=1 DEFAULT CHARSET=latin1;";
	$res_campaign_tracking_tbl=$conn->query($campaign_tracking_tbl);

	$campaign_type_tbl="CREATE TABLE IF NOT EXISTS ".$logdb.".`campaign_type_tbl` (
	  `camp_type_id` int(11) NOT NULL AUTO_INCREMENT,
	  `camp_type` int(11) DEFAULT NULL,
	  `camp_operator` varchar(45) DEFAULT NULL,
	  PRIMARY KEY (`camp_type_id`)
	) ENGINE=InnoDB AUTO_INCREMENT=1 DEFAULT CHARSET=latin1;";
	$res_campaign_type_tbl=$conn->query($campaign_type_tbl);

	$campaign_weightage_tbl="CREATE TABLE IF NOT EXISTS ".$logdb.".`campaign_weightage_tbl` (
	  `camp_weightage_id` int(1) NOT NULL AUTO_INCREMENT,
	  `camp_weightage_type` int(1) DEFAULT NULL,
	  `camp_weightage_perc` varchar(10) DEFAULT NULL,
	  `camp_weightage_operator` varchar(45) DEFAULT NULL,
	  PRIMARY KEY (`camp_weightage_id`)
	) ENGINE=InnoDB AUTO_INCREMENT=1 DEFAULT CHARSET=latin1;";
	$res_campaign_weightage_tbl=$conn->query($campaign_weightage_tbl);

	$capping_tbl="CREATE TABLE IF NOT EXISTS ".$logdb.".`capping_tbl` (
	  `capping_id` int(11) NOT NULL AUTO_INCREMENT,
	  `campaign_id` bigint(10) DEFAULT NULL,
	  `capping_count` bigint(10) DEFAULT NULL,
	  PRIMARY KEY (`capping_id`)
	) ENGINE=InnoDB DEFAULT CHARSET=latin1;";
	$res_capping_tbl=$conn->query($capping_tbl);

	$counter_tbl="CREATE TABLE  IF NOT EXISTS ".$logdb.".`counter_tbl` (
	  `counter_id` int(11) NOT NULL AUTO_INCREMENT,
	  `counter_no` int(2) DEFAULT NULL,
	  PRIMARY KEY (`counter_id`)
	) ENGINE=InnoDB AUTO_INCREMENT=1 DEFAULT CHARSET=latin1;";
	$res_counter_tbl=$conn->query($counter_tbl);
	
	$payout_tbl="CREATE TABLE IF NOT EXISTS ".$logdb.".`payout_tbl` (
	  `payout_id` int(11) NOT NULL AUTO_INCREMENT,
	  `clickid` bigint(20) DEFAULT NULL,
	  `advertiser_id` bigint(20) DEFAULT NULL,
	  `payout` varchar(10) DEFAULT NULL,
	  `campaign_id` int(11) DEFAULT NULL,
	  `camp_payout` varchar(10) DEFAULT NULL,
	  PRIMARY KEY (`payout_id`),
	  KEY `clickid` (`clickid`),
	  KEY `advertiserid` (`advertiser_id`),
	  KEY `campaign_id` (`campaign_id`)
	) ENGINE=InnoDB AUTO_INCREMENT=1 DEFAULT CHARSET=latin1;";
	$res_payout_tbl=$conn->query($payout_tbl);
	
	$pub_blocking_tbl="CREATE TABLE IF NOT EXISTS ".$logdb.".`pub_blocking_tbl` (
	  `pub_blocking_id` int(11) NOT NULL AUTO_INCREMENT,
	  `pubid` varchar(100) NOT NULL,
	  `advertiser_id` int(2) NOT NULL,
	  `pubid_isactive` int(2) DEFAULT NULL,
	  PRIMARY KEY (`pub_blocking_id`,`pubid`,`advertiser_id`),
	  KEY `index_pubid` (`pubid`)
	) ENGINE=InnoDB DEFAULT CHARSET=latin1;
	";
	$res_blocking_tbl = $conn->query($pub_blocking_tbl);

	
	$report="CREATE TABLE IF NOT EXISTS ".$logdb.".`report` (
	  `reportid` bigint(20) NOT NULL AUTO_INCREMENT,
	  `dt` datetime DEFAULT NULL,
	  `title` varchar(45) DEFAULT NULL,
	  `camp_id` int(11) DEFAULT NULL,
	  `clicks` bigint(20) DEFAULT NULL,
	  `act` bigint(20) DEFAULT NULL,
	  `dct` bigint(20) DEFAULT NULL,
	  `cbr` bigint(20) DEFAULT NULL,
	  `pubad` int(4) DEFAULT NULL,
	  PRIMARY KEY (`reportid`)
	) ENGINE=InnoDB DEFAULT CHARSET=latin1;";
	$res_report=$conn->query($report);

	$running_campaign_tbl="CREATE TABLE IF NOT EXISTS ".$logdb.".`running_campaign_tbl` (
	  `run_camp_id` int(2) NOT NULL AUTO_INCREMENT,
	  `campaign_id` int(2) DEFAULT NULL,
	  `run_camp_operator` varchar(20) DEFAULT NULL,
	  `run_camp_track` int(2) DEFAULT NULL,
	  PRIMARY KEY (`run_camp_id`)
	) ENGINE=InnoDB AUTO_INCREMENT=1 DEFAULT CHARSET=latin1;";
	$res_running_campaign_tbl=$conn->query($running_campaign_tbl);

	$userlog_tbl="CREATE TABLE IF NOT EXISTS ".$logdb.".`userlog_tbl` (
		  `userlog_id` bigint(10) NOT NULL AUTO_INCREMENT,
		  `userlog_datetime` datetime DEFAULT NULL,
		  `country` int(2) DEFAULT NULL,
		  `operator` varchar(45) DEFAULT NULL,
		  `ip` varchar(45) DEFAULT NULL,
		  `xforward` varchar(100) DEFAULT NULL,
		  `browser` varchar(45) DEFAULT NULL,
		  `os` varchar(45) DEFAULT NULL,
		  `clickid` bigint(20) DEFAULT NULL,
		  `pubid` varchar(100) DEFAULT NULL,
		  `advertiser_id` int(2) DEFAULT NULL,
		  `referrer_url` varchar(1000) DEFAULT NULL,
		  `pageurl` varchar(1000) DEFAULT NULL,
		  PRIMARY KEY (`userlog_id`),
		  KEY `ind_userlog_datetime` (`userlog_datetime`),
		  KEY `ind_clickid` (`clickid`),
		  KEY `ind_pubid` (`pubid`),
		  KEY `ind_browser` (`browser`),
		  KEY `ind_os` (`os`),
		  KEY `ind_advertiserid` (`advertiser_id`)
		) ENGINE=InnoDB AUTO_INCREMENT=1 DEFAULT CHARSET=latin1;";
		$res_userlog_tbl=$conn->query($userlog_tbl);
	
	
	
		$sp="CREATE  PROCEDURE ".$logdb.".`update_campaign_and_insert_request`(
			poperator varchar(20),
			set_id VARCHAR(100),
			where_id VARCHAR(100),
			ppubid varchar(50),
			pdate datetime,
			purl varchar(500),
			pclick_id varchar(50),
			pcamp_id VARCHAR(100),
			padvertiser_id VARCHAR(100)
			)
			BEGIN

			update campaign_tracking_tbl set campaign_id=set_id where camp_track_id=1;

			insert into campaign_request_tbl (camp_req_url,clickid,pubid,camp_req_datetime,campaign_id,advertiser_id)
			values (purl,pclick_id,ppubid,pdate,pcamp_id,padvertiser_id);


			END
		";
		$res_sp=$conn->query($sp);
	
		//insert tables
	
	
		$insert_counter_tbl="insert into  ".$logdb.".`counter_tbl` (counter_id,counter_no) values ('1','1')";
		$res_counter_tbl=$conn->query($insert_counter_tbl);
		
		$insert_campaign_type_tbl="insert into ".$logdb.".campaign_type_tbl (camp_type_id,camp_type,camp_operator) values ('1','1','".$operator."')";
		$res_campaign_type_tbl=$conn->query($insert_campaign_type_tbl);
		
		$insert_campaign_weightage_tbl="insert into ".$logdb.".campaign_weightage_tbl (camp_weightage_id,camp_weightage_type,camp_weightage_perc,camp_weightage_operator) values ('1','1','50,50','".$operator."')";
		$res_campaign_weightage_tbl=$conn->query($insert_campaign_weightage_tbl);
		
		$insert_campaign_tracking_tbl="insert into ".$logdb.".campaign_tracking_tbl (camp_track_id,campaign_id) values ('1','0') ";
		$res_campaign_tracking_tbl=$conn->query($insert_campaign_tracking_tbl);
	
	}
	
	echo "<script>window.location='new_config.php';</script>";


}


	


?>

		<?php include("includes/header.php"); ?>
		<?php include("includes/sidebar.php"); ?>
		<?php include("includes/top_navigation.php"); ?>
            
			

        <!-- page content -->
        <div class="right_col" role="main" >
          <div class="footer_down">

            
            

            <div class="row">
              <div class="col-md-12 col-xs-12">
                <div class="x_panel">
                  <div class="x_title">
                    <h2>New Configuration</h2>
                    <ul class="nav navbar-right panel_toolbox">
                      <li><a class="collapse-link"><i class="fa fa-chevron-up"></i></a>
                      </li>
                      <li class="dropdown">
                        <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-expanded="false"><i class="fa fa-wrench"></i></a>
                        <ul class="dropdown-menu" role="menu">
                          <li><a href="#">Settings 1</a>
                          </li>
                          <li><a href="#">Settings 2</a>
                          </li>
                        </ul>
                      </li>
                      <li><a class="close-link"><i class="fa fa-close"></i></a>
                      </li>
                    </ul>
                    <div class="clearfix"></div>
                  </div>
                 
                    <br />
                    <form class="form-horizontal form-label-left input_mask" method="post">
					
						
						
						<div class="x_content">
								<div class="col-md-3 col-sm-2 col-xs-12 form-group has-feedback"> <strong> Country</strong>
									<select required name="country"  class="form-control select2_single" id="country" >
										<option value="Select">Select Country</option>
										<?php 
										while($row_country=$res_country->fetch())
										{
										?>
										<option value="<?php echo $row_country['country_id'] ?>" ><?php echo $row_country['country_name'] ?></option>
										<?php
										}
										?>
										
									</select>
								</div>
							</div>
							
							<div class="x_content">
								<div class="col-md-12 col-sm-12 col-xs-12 form-group has-feedback"> <strong> Operator </strong>
									<span class="response">
									</span>
								</div>
							</div>
							
						
						<div class="col-md-12 col-sm-12 col-xs-12">
						 
						  <button type="submit" name="submit" class="btn btn-success">Submit</button>
						</div>
                      
					
                    </form>
                  </div>
                </div>
				
              
              </div>
            </div>
			
			<!-- /page content -->

       <?php
	   include("includes/footer.php");
		?>

<script type="text/javascript">

$(document).ready(function(){

    $("#country").change(function(){
		
		
        var country = $("#country").val();	
		
        $.ajax({
            type: "GET",
            url: "ajax/find_operator.php?country="+country       
			
        }).done(function(data){
            $(".response").html(data);
			 
        });
    });
});
</script>
