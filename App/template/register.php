
<div id="id01" >
  
  <form class="content animate" action="<?php echo base_url().'index.php';?>" method="post">
       <input type="hidden" name="token"  value="<?php echo $_SESSION['token'];?>"/>
    <input type="hidden" name="form"  value="register"/>
    <div class="imgcontainer">
     <h2>User regsitration</h2>
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
        
      <button type="submit">register</button>
    </div>
    <div class='register' >
        <a href='<?php echo base_url().'index.php?page=login';?>' >Login Here </a>
    </div>
  </form>
</div>
