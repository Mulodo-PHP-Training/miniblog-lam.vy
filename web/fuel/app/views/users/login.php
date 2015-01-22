<!-- /.container -->
   <div class="container">
		<div class="col-md-3">
		</div>
		<div class="col-md-6" style="margin-top:30px">
				
				<form class="form-horizontal" method="post" action ="users/login" >
				
				  <div class="form-group"  >
					<label for="inputEmail3" class="col-sm-2 control-label" style="text-align:left;margin-left:0px;padding-left:0px;"></label>
					<div class="col-sm-10">
					  <h3>User Login</h3>
					</div>
					<div class="col-sm-12">
					
						<?php 
						if (isset($result)) echo html_entity_decode($result);
						
						?>
					</div>
				  </div>
				  
				  <div class="form-group"  >
					<label for="inputEmail3" class="col-sm-2 control-label" style="text-align:left;margin-left:0px;padding-left:0px;">Username</label>
					<div class="col-sm-10">
					  <input type="text" class="form-control custom-text" id="inputEmail3" placeholder="Username" style="width:70%;" name="username">
					</div>
				  </div>
				  <div class="form-group">
					<label for="inputPassword3" class="col-sm-2 control-label" style="text-align:left;margin-left:0px;padding-left:0px;">Password</label>
					<div class="col-sm-10">
					  <input type="password" class="form-control custom-text" id="inputPassword3" placeholder="Password" style="width:70%;" name="password">
					</div>
				  </div>
				  <div class="form-group">
					
				  </div>
				  <div class="form-group">
					<div class="col-sm-offset-2 col-sm-10">
					  <button type="submit" class="btn btn-success">Sign in</button>
					</div>
				  </div>
				</form>
		 </div><!--end col-->
		<div class="col-md-3">
		</div> 
   </div>
   <!--  end div container login -->