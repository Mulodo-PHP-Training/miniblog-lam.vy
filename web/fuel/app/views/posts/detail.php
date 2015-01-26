<div class="container">
		<div class="row">
			<div class="col-lg-12">
			<a href="#"><h1><?php echo $data['title'];?></h1></a>
			<p><span class="glyphicon glyphicon-user"></span> : <a href="users/profile/<?php echo $data['author_id'] ?>"><?php echo $data['username'];?></a></p>
				<p><i>Post date : <?php echo date('Y-m-d H:i:m', $data['created_at']);?>
				<br />
				   Modified date :<?php echo date('Y-m-d H:i:m', $data['modified_at']);?>
				   </i>
			</p>
			<?php echo html_entity_decode($data['content']);?>
			
			</div>
			<!--  start write comment -->
			<div class="col-lg-12">
				<h3>Write a comment</h3>
				
				<div class="col-sm-12" id ="rs-comment">
					
				</div>
				<form class="form-horizontal">
					<div class="form-group">
					
						<div class="col-sm-12">
						 <textarea class="form-control" rows="3" placeholder="enter comment here..." name="cm-content" id ="cm-content"></textarea>
						</div>
						<div class="col-sm-12">
						<input type="hidden" name="post_id" value="<?php echo Uri::segment(3)?>" id="cm-post_id" />
						</div>
					</div>
				 
					<div class="form-group">
						<div class=" col-sm-12">
						  <button type="button" class="btn btn-success" name="submit" id = "submit">Comment</button>
						  
						</div>
					</div>
				</form>
				
			</div>
			<!-- end write comment -->
			<div class="col-lg-12">
				<h4>View all comments</h4>
			</div>
			<div id="all-comment">
			
			</div>
	</div>
</div>


