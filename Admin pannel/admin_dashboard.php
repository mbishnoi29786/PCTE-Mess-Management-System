<?php
  include('header.php');
  if(isset($_SESSION['email'])){
  include('../includes/connection.php');
  if(isset($_POST['submit_attendance'])){
    if($_POST['food_type'] == 'Breakfast'){
      $query = "insert into attendance1(sno,id,attendance) values(null,$_POST[id],'$_POST[attendance]')";
    }
    elseif($_POST['food_type'] == 'Lunch'){
      $query = "insert into attendance2(sno,id,attendance) values(null,$_POST[id],'$_POST[attendance]')";
    }
    elseif($_POST['food_type'] == 'Snacks'){
      $query = "insert into attendance3(sno,id,attendance) values(null,$_POST[id],'$_POST[attendance]')";
    }
    else{
      $query = "insert into attendance4(sno,id,attendance) values(null,$_POST[id],'$_POST[attendance]')";
    }
    $query_run = mysqli_query($connection,$query);
    if($query_run){
      echo "<script type='text/javascript'>
        alert('Attendance submitted successfully...');
        window.location.href = 'admin_dashboard.php';
      </script>";
    }
    else{
      echo "<script type='text/javascript'>
        alert('Failed...Plz try again.');
        window.location.href = 'admin_dashboard.php';
      </script>";
    }
  }
  // Find total no of users
  $query = "select * from users";
  $query_run = mysqli_query($connection,$query);
  $total_users = mysqli_num_rows($query_run);

  // Lunch Attendance percentage
  $date = date('y-m-d');
  $query = "select * from attendance2 where attendance = 'Present' and date = '$date'";
  $query_run = mysqli_query($connection,$query);
  $lunch_present = mysqli_num_rows($query_run);
  $lunch_percentage = round(($lunch_present / $total_users) * 100,2);

  // Dinner Attendance percentage
  $date = date('y-m-d');
  $query = "select * from attendance4 where attendance = 'Present' and date = '$date'";
  $query_run = mysqli_query($connection,$query);
  $dinner_present = mysqli_num_rows($query_run);
  $dinner_percentage = round(($dinner_present / $total_users) * 100,2);

  // Find total feedbacks
  $query = "select * from feedback";
  $query_run = mysqli_query($connection,$query);
  $total_feedback = mysqli_num_rows($query_run);

  // Poor Feedback percentage
  $query = "select * from feedback where rating = 'Poor'";
  $query_run = mysqli_query($connection,$query);
  $poor_feedback = mysqli_num_rows($query_run);
  $poor_feedback_percentage = round(($poor_feedback / $total_feedback) * 100,2);

  // Good Feedback percentage
  $query = "select * from feedback where rating = 'Good'";
  $query_run = mysqli_query($connection,$query);
  $good_feedback = mysqli_num_rows($query_run);
  $good_feedback_percentage = round(($good_feedback / $total_feedback) * 100,2);

  // Excellent Feedback percentage
  $query = "select * from feedback where rating = 'Excellent'";
  $query_run = mysqli_query($connection,$query);
  $Excellent_feedback = mysqli_num_rows($query_run);
  $Excellent_feedback_percentage = round(($Excellent_feedback / $total_feedback) * 100,2);

  // Fee status percentage
  $query = "select * from users where fee_status = 1";
  $query_run = mysqli_query($connection,$query);
  $fee_status = mysqli_num_rows($query_run);
  $fee_status_percentage = round(($fee_status / $total_users) * 100,2);

  if(isset($_POST['pay_fee'])){
    $query = "update users set fee_status = 1 where sno = $_POST[id]";
    $query_run = mysqli_query($connection,$query);
    if($query_run){
      echo "<script type='text/javascript'>
        alert('Fee status updated successfully...');
        window.location.href = 'admin_dashboard.php';
      </script>";
    }
    else{
      echo "<script type='text/javascript'>
        alert('Failed...Plz try again.');
        window.location.href = 'admin_dashboard.php';
      </script>";
    }
  }
?>
<!DOCTYPE html>
<html lang="en" dir="ltr">
  <head>
    <meta charset="utf-8">
    <title>User Dashboard</title>
    <script type="text/javascript">
      $(document).ready(function(){
        $("#view_users").click(function(){
          $("#action_div").load("view_users.php");
        });

        $("#edit_users").click(function(){
          $("#action_div").load("edit_users.php");
        });

        $("#pay_fees").click(function(){
          $("#action_div").load("payFee.php");
        });

        $("#view_fees_status").click(function(){
          $("#action_div").load("view_fee_status.php");
        });

        $("#edit_menu").click(function(){
          $("#action_div").load("edit_menu.php");
        });
      });
    </script>
  </head>
  <body style="background:gray;">
    <br>
    <div class="row" style="margin-left:15px;margin-right:15px;">
      <div class="col-md-3">
        <div class="card">
          <div class="card-header">
            <b>Present Today(Attendance)</b>
          </div>
          <div class="card-body">
            <div class="progress">
              <div class="progress-bar" role="progressbar" style="width: <?php echo $lunch_percentage . '%'; ?>;" aria-valuenow="<?php echo $lunch_percentage; ?>" aria-valuemin="0" aria-valuemax="100"><?php echo $lunch_percentage . '%'; ?></div>
            </div> <br>
            <div class="progress">
              <div class="progress-bar bg-warning" role="progressbar" style="width: <?php echo $dinner_percentage . '%'; ?>;" aria-valuenow="<?php echo $dinner_percentage; ?>" aria-valuemin="0" aria-valuemax="100"><?php echo $dinner_percentage . '%'; ?></div>
            </div>
          </div>
          <div class="card-footer">
            <b>Lunch</b>(Blue), <b>Dinner</b>(Yellow)
          </div>
        </div>
      </div>
      <div class="col-md-3">
        <div class="card">
          <div class="card-header">
            <b>Feedback</b>
          </div>
          <div class="card-body">
            <div class="progress">
              <div class="progress-bar bg-danger" role="progressbar" style="width: <?php echo $poor_feedback_percentage . '%'; ?>;" aria-valuenow="<?php echo $poor_feedback_percentage; ?>" aria-valuemin="0" aria-valuemax="100"><?php echo $poor_feedback_percentage . '%'; ?></div>
            </div> <br>
            <div class="progress">
              <div class="progress-bar bg-primary" role="progressbar" style="width: <?php echo $good_feedback_percentage . '%'; ?>;" aria-valuenow="<?php echo $good_feedback_percentage; ?>" aria-valuemin="0" aria-valuemax="100"><?php echo $good_feedback_percentage . '%'; ?></div>
            </div> <br>
            <div class="progress">
              <div class="progress-bar bg-success" role="progressbar" style="width: <?php echo $Excellent_feedback_percentage . '%'; ?>;" aria-valuenow="<?php echo $Excellent_feedback_percentage; ?>" aria-valuemin="0" aria-valuemax="100"><?php echo $Excellent_feedback_percentage . '%'; ?></div>
            </div>
          </div>
          <div class="card-footer">
            <b>Poor</b>(Red), <b>Good</b>(Blue), <b>Excellent</b>(Green)
          </div>
        </div>
      </div>
      <div class="col-md-3">
        <div class="card">
          <div class="card-header">
            <b>Fees Status (Paid)</b>
          </div>
          <div class="card-body">
            <div class="progress">
              <div class="progress-bar bg-success" role="progressbar" style="width: <?php echo $fee_status_percentage . '%'; ?>;" aria-valuenow="<?php echo $fee_status_percentage; ?>" aria-valuemin="0" aria-valuemax="100"><?php echo $fee_status_percentage . '%'; ?></div>
            </div>
          </div>
          <div class="card-footer">
            <button type="button" class="btn btn-sm btn-danger">View Report</button>
          </div>
        </div>
      </div>
      <div class="col-md-3">
        <div class="card">
          <div class="card-header">
            <b>Summary</b>
          </div>
          <div class="card-body">
            <p>
              <b>Total Users:&nbsp;&nbsp;&nbsp;</b><?php echo $total_users; ?> <br>
              <b>No. of Cooks:&nbsp;&nbsp;&nbsp;</b>5 <br>
              <b>Types of meal:&nbsp;&nbsp;&nbsp;</b>4 <br>
            </p>
          </div>
        </div>
      </div>
    </div> <br><br>
    <div class="row" style="margin-left:15px;margin-right:15px;">
      <div class="col-md-3">
        <h3>Mark Attendance</h3>
        <form action="" method="post">
          <div class="form-group">
            <label>Enter ID No:</label>
            <input type="text" class="form-control" name="id" placeholder="Enter ID No.">
          </div>
          <div class="form-group">
            <label>Select Type:</label>
            <select class="form-control" name="food_type">
              <option>-Select-</option>
              <option>Breakfast</option>
              <option>Lunch</option>
              <option>Snacks</option>
              <option>Dinner</option>
            </select>
          </div>
          <div class="form-group">
            <label>Attendance:</label>
            <select class="form-control" name="attendance">
              <option>-Select-</option>
              <option>Present</option>
              <option>Absent</option>
            </select><br>
            <div class="form-group">
              <input type="submit" class="form-control btn btn-primary" name="submit_attendance" value="Submit">
            </div>
          </div>
        </form>
      </div>
      <div class="col-md-2">
        <h3>Quick Actions</h3> <br>
        <button class="btn btn-block btn-primary" id="view_users">View users</button> <br>
        <button class="btn btn-block btn-danger" id="edit_users">Delete user</button> <br>
        <button class="btn btn-block btn-success" id="edit_menu">Edit menu</button> <br>
        <button class="btn btn-block btn-info" id="pay_fees">Pay fees</button> <br>
        <button class="btn btn-block btn-primary" id="view_fees_status">View fees status</button>
      </div>
      <div class="col-md-7" style="background:whitesmoke;" id="action_div">

      </div>
    </div>
    <!-- Week Meal MODAL -->
    <div class="modal fade" id="meal_modal">
      <div class="modal-dialog">
        <div class="modal-content">
      <!-- Modal Header -->
      <div class="modal-header">
        <h4 class="modal-title">Full Week Menu</h4>
        <button type="button" class="close" data-dismiss="modal">&times;</button>
      </div>
      <!-- Modal body -->
      <div class="modal-body">
        <h4>Monday</h4>
        <p>
          <b>Breakfast: </b> Pohe, Milk, Egg <br>
          <b>Lunch:</b> Daal, Chapati, Mix vegetable and salad. <br>
          <b>Breakfast: </b> Pohe, Milk, Egg <br>
          <b>Lunch:</b> Daal, Chapati, Mix vegetable and salad.
        </p>
        <h4>Tuesday</h4>
        <p>
          <b>Breakfast: </b> Pohe, Milk, Egg <br>
          <b>Lunch:</b> Daal, Chapati, Mix vegetable and salad. <br>
          <b>Breakfast: </b> Pohe, Milk, Egg <br>
          <b>Lunch:</b> Daal, Chapati, Mix vegetable and salad.
        </p>
        <h4>Wednsday</h4>
        <p>
          <b>Breakfast: </b> Pohe, Milk, Egg <br>
          <b>Lunch:</b> Daal, Chapati, Mix vegetable and salad. <br>
          <b>Breakfast: </b> Pohe, Milk, Egg <br>
          <b>Lunch:</b> Daal, Chapati, Mix vegetable and salad.
        </p>
        <h4>Thrusday</h4>
        <p>
          <b>Breakfast: </b> Pohe, Milk, Egg <br>
          <b>Lunch:</b> Daal, Chapati, Mix vegetable and salad. <br>
          <b>Breakfast: </b> Pohe, Milk, Egg <br>
          <b>Lunch:</b> Daal, Chapati, Mix vegetable and salad.
        </p>
        <h4>Friday</h4>
        <p>
          <b>Breakfast: </b> Pohe, Milk, Egg <br>
          <b>Lunch:</b> Daal, Chapati, Mix vegetable and salad. <br>
          <b>Breakfast: </b> Pohe, Milk, Egg <br>
          <b>Lunch:</b> Daal, Chapati, Mix vegetable and salad.
        </p>
      </div>
      <!-- Modal footer -->
      <div class="modal-footer">
        <button type="button" class="btn btn-danger" data-dismiss="modal">Close</button>
      </div>
      </div>
    </div>
  </div>
  </body>
</html>
<?php }
else{
  header('location:../index.php');
}
