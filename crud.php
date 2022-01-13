<?php 
      session_start();
      $db = new mysqli('localhost','root','','cruddb',) or  die(mysqli_error($db));
      $result = $db->query("SELECT * FROM donnee_users") or die($db->error);
      $name = '';
      $email = '';
      $update = false;
      $id = 0;
      if (isset($_POST['submit'])){
        $name = $_POST['name'];
        $email = $_POST['email'];

        $db->query("INSERT INTO donnee_users VALUES ('','$name', '$email')") or die($db->error);
      
        $_SESSION['message'] = "SAVED SUCCESSFULLY! ";
        $_SESSION['msg_type'] = "success";
        header("location: crud.php");
        exit();

      }

        
        if (isset($_GET['delete'])){
          $id = $_GET['delete'];
          $db->query("DELETE FROM donnee_users WHERE id = $id") or die($db->error);
          $_SESSION['message'] = "RECORD HAS BEEN DELETED! ";
          $_SESSION['msg_type'] = "danger";
          header("location: Crud.php");
          exit();
        }

        if (isset($_GET['edit'])){
          $id = $_GET['edit'];
          $update = true;
          $results = $db->query("SELECT * FROM donnee_users WHERE id = $id") or die($db->error);
          if(count(array($results)) > 0){
            $row = $results->fetch_array();
            $name = $row['name'];
            $email = $row['email'];
          }
        }

        if(isset($_POST['update'])){
          $id = $_POST['id'];
          $name = $_POST['name'];
          $email = $_POST['email'];
          $db->query("UPDATE donnee_users SET name = '$name', email = '$email' WHERE id = '$id' ") or die($db->error);
          $_SESSION['message'] = "UPDATED SUCCESSFULLY! ";
          $_SESSION['msg_type'] = "warning";
          header("location: Crud.php");
          exit();
        }
      
?> 

<!doctype html>
<html lang="en">
  
  <head>
        <!-- Required meta tags -->
        <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <link rel="stylesheet" href="https://fonts.googleapis.com/icon?family=Material+Icons">
    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css">

    <title>Crud exemple</title>
  </head>
  <body>
    <?php 
    if(isset($_SESSION['message'])):
    ?>
    <div class = "alert alert-<?=$_SESSION['msg_type']?>">
      <?php 
      echo $_SESSION['message'];
      unset($_SESSION['message']);
      ?>
      
     </div>
     <?php endif ?>
  
  <div class = "card" >
   <div class="card-body">
     <h5 class="card-title">Sign up</h5>
    <form action = "" method ="POST">
      <input type="hidden" name = "id" value = <?php echo $id; ?>>
      <div class="mb-3">
        <label for="exampleInputEmail1" class="form-label" >Name</label>
        <input type="text" class="form-control" name="name" value= "<?php echo $name; ?>" placeholder = "Put your name">
      </div>
      <div class="mb-3">
        <label for="exampleInputEmail1" class="form-label">Email</label>
        <input type="email" class="form-control" name="email" value= "<?php echo $email; ?>" placeholder = "put your mail">
      </div>
      <div class="form-group">
        <?php 
          if($update == true):
            ?>
            <button type="update" name="update" class="btn btn-info">Update</button>
        <?php
          else:
            ?>
            <button type="submit" name="submit" class="btn btn-primary">Submit</button>
        
        <?php endif; ?>

        
      </div>
          </div>
    
  </form>
<br>
  </div>

  <div class = "container">
      <div class = "row justify-content-center">
        <table class = "table table-striped">
          <thead>
            <th>NAME</th>
            <th>EMAIL</th>
            <th collspan = "1">ACTION</th>
          </thead>
            <?php
              while($row = mysqli_fetch_assoc($result))
              {
                ?>
              <tr>
                <td><?php echo $row['name']?></td>
                <td><?php echo $row['email']?></td>
                <td>
                  <a href="Crud.php?edit=<?php echo $row['id']; ?>" data-toggle="tooltip"><i class="material-icons">&#xE254;</i></a>
                  <a href="Crud.php?delete=<?php echo $row['id']; ?>" data-toggle="tooltip"><i class="material-icons">&#xE872;</i></a> 
              </td>
              </tr> 
              
              
              
            <?php 
              }
           ?>
        </table>

        
      </div>
  </div>
  <body>
  </html>