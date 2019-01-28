<?php
    session_start();
    if (!isset($_SESSION['username'])) {
        $_SESSION['msg'] = "You must log in first";
        header('location: login.php');
    }

    if (isset($_GET['logout'])) {
        session_destroy();
        unset($_SESSION['username']);
        header("location: login.php");
    }
    include_once('dbConfig.php');
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>NCC@MNNIT</title>
    <link rel="icon" href="img/nccFlag.png">
    <link href="css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css" rel="stylesheet">
    <link href="css/custom.min.css" rel="stylesheet">
    <link rel="stylesheet" type="text/css" href="css/scroll.css">

    <style>
        body {
            background-image: url("img/fam.jpg");
            background-size: cover;
        }
    </style>

    <script src="js/jquery.min.js"></script>
    <script>
        $(document).ready(function(){
                $("#div1").fadeOut(3000);
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
                        <h3>General</h3>
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

                        <li role="presentation" class="dropdown">
                            <a href="javascript:;" class="dropdown-toggle info-number" data-toggle="dropdown"
                               aria-expanded="false">
                                <i class="fa fa-envelope-o"></i>
                                <span class="badge bg-green">6</span>
                            </a>

                        </li>
                    </ul>
                </nav>
            </div>
        </div>
        <!-- /top navigation -->



        



<!-- page content area main -->
<div class="right_col" role="main">
            <div class="title_left">
                <h3>My participations</h3>
            </div>


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




        <div class="clearfix"></div>
        <div class="row">
            <div class="col-md-12 col-sm-12 col-xs-12">
                <div class="x_panel">
                    
                        <div class="output_scroll">
                        <prescroll>
                        <table class="table table-bordered">
                            <th>Event name</th>
                            <th>Event Description</th>
                            <th>Date</th>
                            <th>Time</th>
                            <th>Venue</th>
                            <th>Status</th>
                               <?php
                                
                                $query = "SELECT * FROM eventJoin
											INNER JOIN event
											ON event.event_id = eventJoin.event_id
											WHERE eventJoin.username = '$_SESSION[username]' order by event_date desc";
                                $res=mysqli_query($db,$query);
                                while ($row = mysqli_fetch_array($res)) 
                                {
                                    if ($row["status1"] === 'Approved' && $row['status2'] === 'Joined') 
                                    {
                                        echo "<tr>";
                                        echo "<td>";
                                        echo $row["event_name"];
                                        echo "</td>";
                                        echo "<td class='next_line_word'>";
                                        echo $row["event_desc"];
                                        echo "</td>";
                                        echo "<td>";
                                        echo $row["event_date"];
                                        echo "</td>";
                                        echo "<td>";
                                        echo $row["time"];
                                        echo "</td>";
                                        echo "<td>";
                                        echo $row["venue"];
                                        echo "</td>";
                                        echo "<td>";
	                                    if( $row['status2'] === 'Joined' && $row["event_date"] >= date("Y-m-d"))
	                                    {
	                                    	?>
	                                    <form action="server.php" method="post">
	                                            <input type="hidden" name="leaveId" <?php echo "value='".$row["event_id"]."'" ?> >
	                                            <input type="hidden" name="leaveUser" <?php echo "value='".$_SESSION["username"]."'" ?> >                                            
	                                            <button type="submit" name="leave11" class="btn btn-danger btn-md">Leave</button>
	                                        </form>
	                                     <?php
	                                    }
	                                    else
	                                    {
	                                    	echo $row["status2"];
	                                    	echo "</td>";
	                                	}
                                	}
                                }                             
                                ?>                            
                        </table>
                        </prescroll>
                        </div>
                </div>
            </div>
        </div>
</div>
<!-- /page content -->


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
                    <label>Description of the event</label>
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


    
    </div>
</div>

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
