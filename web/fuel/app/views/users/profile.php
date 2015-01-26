<div class="container">

      <div class="row">
        
		<div class="col-md-12">
		  <div class="panel panel-success">
                <div class="panel-heading">
                    <h3 class="panel-title">User's profile</h3>
                    <?php if (isset($result)) echo html_entity_decode($result)?>
                </div>
                <?php
                if (isset ($data)) {
                ?>
                <div class="panel-body">
					<p><a href="#"><span class="glyphicon glyphicon-user"></span> : <b><?php echo $data['lastname'].' '. $data['firstname']?></b></a></p>
					<p>					
					Login name : <b><?php echo $data['username']?></b>
					<br />
					Email : <b><?php echo $data['email']?></b>
					<br />
					Join date : <i><?php echo date('Y-m-d', $data['created_at'])?></i>
					
					</p>
					<hr>
					<p>
					<a href="users/<?php echo $data['id']?>/posts">View all user's posts <span class="glyphicon glyphicon-edit"></a>
					<br />
					<a href="users/<?php echo $data['id']?>/comments">View all user's comments <span class="glyphicon glyphicon-comment"></a>
					</p>
				</div>
				<?php 
				}
				?>
            </div>
            
		</div>
		
		
		
      </div>
			
		
    </div><!-- /.container -->