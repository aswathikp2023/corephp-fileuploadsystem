<div id="id01" >
  
  <form class="content animate" action="<?php echo base_url().'index.php';?>" method="post">
    <input type="hidden" name="token"  value="<?php echo $_SESSION['token'];?>"/>
    <input type="hidden" name="form"  value="login"/>
    <div class="imgcontainer">
     <h2>User Login</h2>
    </div>
       <?php if(is_flash('err_msg') !== NULL){?>
        <span class="error_msg"><?php echo pop_flash('err_msg'); ?></span>
        <?php } ?>

         <?php if(is_flash('success')){?>
        <span class="success"><?php echo pop_flash('success'); ?></span>
        <?php } ?>
    <div class="container">
      <label for="email"><b>Email</b></label>
      <input type="email" placeholder="Enter Email" name="email" required>

      <label for="password"><b>Password</b></label>
      <input type="password" placeholder="Enter Password" name="password" required>
        
      <button type="submit">Login</button>
    </div>
    <div class='register' >
        <a href='<?php echo base_url().'index.php?page=register';?>' >Register New User </a>
    </div>
  </form>
</div>
