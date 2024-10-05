<?php
  if(isset($_SESSION['email'])){
  include('../includes/connection.php');
  $query = "delete from users where sno = $_GET[id]";
  $query_run = mysqli_query($connection,$query);
  if($query_run){
    echo "<script type='text/javascript'>
      alert('User Deleted successfully...');
      window.location.href = 'admin_dashboard.php';
    </script>";
  }
  else{
    echo "<script type='text/javascript'>
      alert('Failed...Plz try again.');
      window.location.href = 'admin_dashboard.php';
    </script>";
  }
?>
<?php }
else{
  header('location:../index.php');
}
