<div class="container">
		<div class="row">
			<div class="col-lg-12">
			<a href="#"><h1><?php echo $data['title'];?></h1></a>
			<p><span class="glyphicon glyphicon-user"></span> : <a href="#"><?php echo $data['username'];?></a></p>
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
				<form class="form-horizontal" action="comments/create" method ="post"  >
					<div class="form-group">
					
						<div class="col-sm-12">
						 <textarea class="form-control" rows="3" placeholder="enter comment here..."></textarea>
						</div>
					</div>
				 
					<div class="form-group">
						<div class=" col-sm-12">
						  <button type="submit" class="btn btn-success" name="submit">Comment</button>
						  
						</div>
					</div>
				</form>
				
			</div>
			<!-- end write comment -->
	</div>
</div>
