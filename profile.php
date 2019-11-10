<?php
  include('db/db_con.php');
  if(!isset($_SESSION['type']))
  {
    header("location:login.php");
  }

  $query = "SELECT * FROM user_details WHERE user_id = '".$_SESSION["user_id"]."'";
  $statement = $connect->prepare($query);
  $statement->execute();
  $result = $statement->fetchAll();
  $name = '';
  $email = '';
  $user_id = '';
  foreach ($result as $row)
  {
    $name = $row['user_name'];
    $email = $row['user_email'];
  }
  include('includes/header.php');
?>
<br>
<div class="container" style="width:50%">
  <div class="panel panel-default">
    <div class="panel-heading"><h2>Edit Profile</h2></div>
    <div class="panel-body">
      <form class="" id="edit_profile_form">
        <div id="message"></div>
        <div class="form-group">
          <label for="">Name</label>
          <input type="text" name="user_name" id="user_name" class="form-control" value="<?=$name;?>" required>
        </div>

        <div class="form-group">
          <label for="">Email</label>
          <input type="email" name="user_email" id="user_email" class="form-control" value="<?=$email;?>" required>
        </div>

        <div class="form-group">
          <label for="">New Password</label>
          <input type="password" name="user_new_password" id="user_new_password" class="form-control" value="" placeholder="Enter New Password">
        </div>

        <div class="form-group">
          <label for="">Re-enter Password</label>
          <input type="password" name="user_re_new_password" id="user_re_new_password" class="form-control" value="" placeholder="Re-enter New Password">
          <span id="error_password"></span>
        </div>
        <input type="submit" name="edit_profile" id="edit_profile" value="Edit" class="btn btn-info">
      </form>
    </div>
  </div>
</div>
<script type="text/javascript">
$(document).ready(function() {
  $('#edit_profile_form').on('submit', function(event) {
    event.preventDefault();
    if($('#user_new_password').val() != '')
    {
      if($('#user_new_password').val() != $('#user_re_new_password').val())
      {
        $('#error_password').html('<label class="text-danger">Password not match.</label>');
        return false;
      }
      else
      {
        $('#error_password').html('');
      }
    }
      $('#edit_profile').attr('disabled','disabled');
      var form_data = $(this).serialize();
      $.ajax({
        url:"edit_profile.php",
        method:"POST",
        data:form_data,
        success:function(data) {
          if(data == 'SUCCESS') {
            $('#message').addClass('alert alert-success');
            $('#message').html('Profile Edited successfully!');
            $('#message').delay(3000).fadeOut('slow');
            $('#edit_profile').attr('disabled',false);
            $('#user_new_password').val('');
            $('#user_re_new_password').val('');
          } else {
            $('#message').html('Something went wrong! Try Again.');
            $('#message').addClass('alert alert-danger');
            $('#message').delay(3000).fadeOut('slow');
          }
        }
      });
  });
});

</script>
