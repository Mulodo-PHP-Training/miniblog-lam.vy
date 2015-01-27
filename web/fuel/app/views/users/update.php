<div class="container">
<div class="col-md-3">
		</div>
		<div class="col-md-6" style="margin-top:30px">
				
				<form class="form-horizontal"  action="users/update" method="post">
				
				  <div class="form-group"  >
					<label for="inputEmail3" class="col-sm-2 control-label" style="text-align:left;margin-left:0px;padding-left:0px;"></label>
					<div class="col-sm-10">
					  <h3>Update Your Profile</h3>
					</div>
					<div class="col-sm-12">
					
						<?php 
						if (isset($result)) echo html_entity_decode($result);
						
						?>
					</div>
				  </div>
				  
				  <div class="form-group"  >
					<label for="inputLastname" class="col-sm-2 control-label" style="text-align:left;margin-left:0px;padding-left:0px;">Last name</label>
					<div class="col-sm-10">
					  <input type="text" class="form-control custom-text" id="inputLastname" placeholder="Lastname" style="width:70%;" name="lastname" value="<?php echo $data['lastname'];?>">
					</div>
				  </div>
				  <div class="form-group">
					<label for="inputFirstname" class="col-sm-2 control-label" style="text-align:left;margin-left:0px;padding-left:0px;">First name</label>
					<div class="col-sm-10">
					  <input type="text" class="form-control custom-text" id="inputFirstname" placeholder="Firstname" style="width:70%;" name="firstname" value="<?php echo $data['firstname'];?>">
					</div>
				  </div>
				  
				  <div class="form-group">
					<label for="inputEmail" class="col-sm-2 control-label" style="text-align:left;margin-left:0px;padding-left:0px;">Email</label>
					<div class="col-sm-10">
					  <input type="email" class="form-control custom-text" id="inputEmail" placeholder="Email" style="width:70%;" name="email" value="<?php echo $data['email'];?>">
					</div>
				  </div>
				  
				  <div class="form-group">
					
				  </div>
				  <div class="form-group">
					<div class="col-sm-offset-2 col-sm-10">
					  <button type="submit" class="btn btn-success" name="submit">Update</button>
					  <a href="users/" class="btn btn-success">Cancel</a>
					  
					</div>
				  </div>
				</form>
		 </div><!--end col-->
		<div class="col-md-3">
		</div> 
</div>		