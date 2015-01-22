<div class="container">

<div class="col-md-3">
		</div>
		<div class="col-md-6" style="margin-top:30px">
				
				<form class="form-horizontal" method="post" action="users/password" onsubmit="return validateForm()" name="myForm"  >
				
				  <div class="form-group"  >
					<label for="inputEmail3" class="col-sm-3 control-label" style="text-align:left;margin-left:0px;padding-left:0px;"></label>
					<div class="col-sm-9">
					  <h3>Change Your Password</h3>
					</div>
					<div class="col-sm-12">
					<div id ="result">
					<?php 
						if (isset($result)) echo html_entity_decode($result);
						
					?>
					</div>
					</div>
				  </div>
				  
				  <div class="form-group"  >
					<label for="inputOld" class="col-sm-3 control-label" style="text-align:left;margin-left:0px;padding-left:0px;">Old password</label>
					<div class="col-sm-9">
					  <input type="password" name="oldpassword" class="form-control custom-text" id="inputOld" placeholder="Old password" style="width:70%;">
					</div>
				  </div>
				  <div class="form-group">
					<label for="inputPassword" class="col-sm-3 control-label" style="text-align:left;margin-left:0px;padding-left:0px;">New password</label>
					<div class="col-sm-9">
					  <input type="password" name="newpassword" class="form-control custom-text" id="inputPassword" placeholder="New password" style="width:70%;">
					</div>
				  </div>
				  
				  <div class="form-group">
					<label for="inputRetype" class="col-sm-3 control-label" style="text-align:left;margin-left:0px;padding-left:0px;">Retype password</label>
					<div class="col-sm-9">
					  <input type="password" name="retype" class="form-control custom-text" id="inputRetype" placeholder="Retype password" style="width:70%;">
					</div>
				  </div>
				  
				  <div class="form-group">
					
				  </div>
				  <div class="form-group">
					<div class="col-sm-offset-3 col-sm-9">
					  <button type="submit" class="btn btn-success" name="submit">Save</button>
					  <a href="users/" class="btn btn-success">Cancel</a>
					</div>
				  </div>
				</form>
		 </div><!--end col-->
		<div class="col-md-3">
		
		</div>
</div>
<script>

function validateForm() {
    var newpass = document.forms["myForm"]["newpassword"].value;
    var oldpass = document.forms["myForm"]["oldpassword"].value;
    var re = document.forms["myForm"]["retype"].value;
    if (oldpass == null || oldpass == "") {
    	document.getElementById("result").innerHTML = "<div class=\"alert alert-warning\" role=\"alert\">"
   		 + "<strong>Sorry!</strong> Please fill in your old pasword ."
   		 +"</div>";
           return false;
    }
    if (newpass == null || newpass == "") {
    	document.getElementById("result").innerHTML = "<div class=\"alert alert-warning\" role=\"alert\">"
		 + "<strong>Sorry!</strong> Please fill in your new pasword ."
		 +"</div>";
        return false;
    } 
    if (re == null || re == "") {
    	document.getElementById("result").innerHTML = "<div class=\"alert alert-warning\" role=\"alert\">"
      		 + "<strong>Sorry!</strong> Please retype your new password ."
      		 +"</div>";
              return false;
    }

    if (re != newpass) {
    	document.getElementById("result").innerHTML = "<div class=\"alert alert-warning\" role=\"alert\">"
     		 + "<strong>Sorry!</strong> Retype password not match your new password ."
     		 +"</div>";
             return false;
    } 
}

</script>