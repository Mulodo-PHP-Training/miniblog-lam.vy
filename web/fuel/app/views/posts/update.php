<div class="container">
		<div class="col-md-3">
		</div>
		<div class="col-md-6" style="margin-top:30px">
				
				<form class="form-horizontal"  method="post" action="posts/update/<?php echo Uri::segment(3)?>">
				
				  <div class="form-group"  >
					<label for="inputEmail3" class="col-sm-2 control-label" style="text-align:left;margin-left:0px;padding-left:0px;"></label>
					<div class="col-sm-10">
					  <h3>Update post</h3>
					</div>
					<div class="col-sm-12">
					<?php if (isset($result)) echo html_entity_decode($result)?>
					</div>
				  </div>
				  
				  <div class="form-group"  >
					<label for="inputTitle" class="col-sm-2 control-label" style="text-align:left;margin-left:0px;padding-left:0px;">Title</label>
					<div class="col-sm-10">
					  <input type="text" name="title" class="form-control custom-text" id="inputTitle" value="<?php if (isset($post)) echo $post['title']?>" style=width:100%;">
					</div>
				  </div>
				  <div class="form-group">
					<label for="inputContent" class="col-sm-2 control-label" style="text-align:left;margin-left:0px;padding-left:0px;">Content</label>
					<div class="col-sm-10">
					 <textarea class="form-control" rows="10" name="content"><?php if (isset($post)) echo $post['content']?></textarea>
					</div>
				  </div>
				  <div class="form-group">
					
				  </div>
				  <div class="form-group">
					<div class="col-sm-offset-2 col-sm-10">
					  <button type="submit" class="btn btn-success" name="save">Update</button>
					  <button type="reset" class="btn btn-success" name="reset">Reset</button> 
					  <a href="posts/manage" class="btn btn-success">Cancel</a> 
					  <button type="submit" class="btn btn-success" name="preview">Preview</button>
					</div>
				  </div>
				</form>
		 </div><!--end col-->
		<div class="col-md-3">
		</div> 
   </div>
   <?php 
   if (isset($_POST['preview'])) {
   	
   ?>
   <!-- preview-->
    <div class="container">
	 <hr>
		
		<div class="row">
			<div class="col-md-12">
				<h1>Preview</h1>
				
				<a href="#"><h1><?php echo $post['title']?></h1></a>
				<p><span class="glyphicon glyphicon-user"></span> : <a href="#"><?php echo Session::get('username')?></a></p>
				<p><i>Post date : <?php echo date('Y-m-d H:i:m', $post['created_at'])?>
				<br />
				   Modified date :<?php echo date('Y-m-d H:i:m', $post['modified_at'])?>
				   </i>
				</p>
				<?php echo html_entity_decode($post['content'])?>
		   </div>
		</div>
		
    </div><!--end preview-->
   <?php 
   }
   ?>