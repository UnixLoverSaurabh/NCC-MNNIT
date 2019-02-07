<?php
    session_start();
    if (!isset($_SESSION['username'])) {
        $_SESSION['msg'] = "You must log in first";
        header('location: login.php');
    }

    if (isset($_GET['logout'])) {
        $_SESSION['msg'] = "Logged out";
        session_destroy();
        unset($_SESSION['username']);
        header("location: login.php");
    }
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Welcome to NCC@MNNIT</title>
    <link rel="icon" href="img/nccFlag.png">
    <link type="text/css" rel="stylesheet" href="css/carousel.css">
    <link type="text/css" rel="stylesheet" href="css/global.css">
    <script src="js/jquery.min.js"></script>
    <script type="text/javascript" src="js/carousel.js"></script>

    <link href="css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css" rel="stylesheet">
    <link href="css/nprogress.css" rel="stylesheet">
    <link href="css/custom.min.css" rel="stylesheet">
    <link rel="stylesheet" type="text/css" href="css/notification.css">
    <style>
		body {
		    background-image: url("img/fam.jpg");
		 	background-size: cover;
		}
        #div1 {
                color: red; 
                max-width: 30%; 
                margin: 0px auto; 
                background:linear-gradient(#1308f8,#3db2f9,#398fe1,#08f8ed,#080cf8);
                text-align: left;
                border: 1px solid #B0C4DE;
                border-radius: 10px 10px 0px 0px;  
                padding: 10px;
            }
    </style>
    <script>
        $(document).ready(function(){
                $("#div1").fadeOut(5000);
        });
    </script>

</head>

<body class="nav-md">
<div class="container body">
    <div class="main_container">
        <div class="col-md-3 left_col">
            <div class="left_col scroll-view">
                <div class="navbar nav_title" style="border: 0;">
                    <a href="#" class="site_title"><i class="fa fa-book"></i> <span>NCC@MNNIT</span></a>
                </div>

                <!-- menu profile quick info -->
                <div class="profile clearfix">
                    <div class="profile_pic">
                        <img src="img/face.jpg" alt="..." class="img-circle profile_img">
                    </div>
                    <div class="profile_info">
                        <span>Welcome,</span>
                        <!-- logged in user information -->
						<?php  if (isset($_SESSION['username'])) : ?>
							<h2><?php echo $_SESSION['username']; ?></h2>
						<?php endif ?>
                    </div>
                </div>
                <!-- /menu profile quick info -->

                <br/>

                <!-- sidebar menu -->
                <div id="sidebar-menu" class="main_menu_side hidden-print main_menu">
                    <div class="menu_section">
                        <ul class="nav side-menu">
                            <li><a href="index.php"><i class="fa fa-home"></i> Home <span class="fa fa-chevron-down"></span></a></li>
                            <li data-toggle="modal" data-target="#add_blog_modal"><a>
                                <i class="fa fa-edit"></i><span class="fa fa-chevron-down"></span>Create a new event</a></li> 
                            <li><a href="calender.php"><i class="fa fa-calendar"></i> Event Calender <span class="fa fa-chevron-down"></span></a></li> 
                            <li><a href="broadcast.php"><i class="fa fa-table"></i> Broadcast <span class="fa fa-chevron-down"></span></a></li>
                            <li><a href="joined.php"><i class="fa fa-user-circle-o"></i> Joined <span class="fa fa-chevron-down"></span></a></li>
                        <?php
                        if ($_SESSION["username"] === 'Admin')
                        {
                            ?>
                            <li><a href="admin.php"><i class="fa fa-calendar-plus-o"></i> Approve the events <span class="fa fa-chevron-down"></span></a></li>
                            <?php
                        }
                        ?>
                        </ul>
                    </div>
                </div>

            </div>
        </div>

        <!-- top navigation -->
        <div class="top_nav">
            <div class="nav_menu">
                <nav>
                    <div class="nav toggle">
                        <a id="menu_toggle"><i class="fa fa-bars"></i></a>
                    </div>

                    <ul class="nav navbar-nav navbar-right">
                        <li class="">
                            <a href="javascript:;" class="user-profile dropdown-toggle" data-toggle="dropdown" aria-expanded="false">
                                <img src="img/face.jpg" alt="">
                                	<!-- logged in user information -->
									<?php  if (isset($_SESSION['username'])) : ?>
										<?php echo $_SESSION['username']; ?>
									<?php endif ?>
                                <span class=" fa fa-angle-down"></span>
                            </a>
                            <ul class="dropdown-menu dropdown-usermenu pull-right">
                                <li><a href="index.php?logout='1'"><i class="fa fa-sign-out pull-right"></i> Log Out</a></li>
                            </ul>
                        </li>


                        <li>
                            <div id="noti_Button" class="fa fa-bell-o" style="font-size:26px">
                                <span class="badge bg-green" id="noti_Counter">6</span>
                            </div>    
                            <div id="notifications">
                                <h3 id="notificationsShade">Notifications</h3>
                                <div style="height:300px;"></div>
                                <div class="seeAll"><a href="#">See All</a></div>
                            </div>
                        </li>

                    </ul>
                </nav>
            </div>
        </div>
        <!-- /top navigation -->


        <!-- page content area main -->
        <div class="right_col" role="main">
                



                <!-- notification message -->
                <?php if (isset($_SESSION['success'])) : ?>
                    <div id="div1">
                        <h2>
                            <?php 
                                echo $_SESSION['success']; 
                                unset($_SESSION['success']);
                            ?>
                        </h2>
                    </div>
                <?php endif ?>  
        </div>
	</div>
</div>

<!-- Modal -->
    <div id="add_blog_modal" class="modal fade" role="dialog">
      <div class="modal-dialog">

        <!-- Modal content-->
        <div class="modal-content">
          <div class="modal-header">
            <button type="button" class="close" data-dismiss="modal">&times;</button>
            <h4 class="modal-title">Add a new Event</h4>
          </div>
          <div class="modal-body">

            <form method="post" action="server.php">
                  <div class="form-group">
                    <label>Title</label>
                    <input type="text" name="title" class="form-control" id="title">
                  </div>
                  <div class="form-group">
                    <label>Content Of The Blog</label>
                    <textarea type="text" rows="6" name="comments" class="form-control" id="content"></textarea>
                  </div>
                  <div class="form-group">
                    <label>Venue of the event</label>
                    <input type="text" name="venue" class="form-control"></input>
                  </div>
                  <div class="form-group">
                    <label>Date for the event</label>
                    <input type="date" name="date1" class="form-control"></input>
                  </div>
                  <div class="form-group">
                    <label>Time of the event</label>
                    <input type="time" name="time1" class="form-control"></input>
                  </div>

                  <button type="submit" name="commented" class="btn btn-default">Submit</button>
            </form>

          </div>
          <div class="modal-footer">
            <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
          </div>
        </div>

      </div>
    </div>
    <!-- END MODAL -->

<script>
    $(function(){
        Carousel.init($(".pictureSlider"));
    });
</script>


<!-- Notification section-->
<script>
    $(document).ready(function () {

        $('#noti_Button').click(function () {
            $('#notifications').fadeToggle('fast', 'linear');
            $('#noti_Counter').fadeOut('slow'); return false;
        });
            
        $('#notifications').click(function () { return false; });
    });
</script>

<!-- jQuery -->
<script src="js/jquery.min.js"></script>
<!-- Bootstrap -->
<script src="js/bootstrap.min.js"></script>
<!-- FastClick -->
<script src="js/fastclick.js"></script>
<!-- NProgress -->
<script src="js/nprogress.js"></script>
<!-- Custom Theme Scripts -->
<script src="js/custom.min.js"></script>
</body>
</html>
