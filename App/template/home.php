<?php
include('App/template/header.php'); ?>
<style>
	.uploadbtn{
		width: 10%;
	}
</style>
<div id="id01" >
  
  <form class="content animate" action="<?php echo base_url().'index.php';?>" method="post" enctype="multipart/form-data">
  	<input type="hidden" name="token"  value="<?php echo $_SESSION['token'];?>"/>
    <input type="hidden" name="form"  value="upload"/>
    <div class="imgcontainer">
     <h2>Dashboard</h2> 
      <div class='register' >
        <a href='<?php echo base_url().'index.php?flag=logout';?>' >Logout </a>
    </div>
    </div>
   <?php if(is_flash('err_msg') !== NULL){?>
<span class="error_msg"><?php echo pop_flash('err_msg'); ?></span>
<?php } ?>

 <?php if(is_flash('success')){?>
<span class="success"><?php echo pop_flash('success'); ?></span>
<?php } ?>

    <div class="container">
      <label for="file"><b>Upload File</b></label>
      <input type="file" placeholder="Enter Email" name="file" required>

      <button type="submit" class='uploadbtn'>Upload</button>
    </div>
   
  </form>
</div>

<?php include('App/template/footer.php'); ?>
?>