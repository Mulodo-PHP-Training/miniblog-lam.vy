    <div class="container">
	  
					
		<?php 
			if (isset($result)) echo html_entity_decode($result);
						
		?>
	  
      <div class="row">             
		
		
		<?php 
		
		if (count($data) > 0) {

			foreach($data as $item) {
		?>
		<div class="col-md-6">
		  <div class="panel panel-success">
                <div class="panel-heading">
                    <h3 class="panel-title"><span class="glyphicon glyphicon-user"></span> : <a href="users/profile/<?php echo $item['id']?>"><?php echo $item['lastname'].' '.$item['firstname'];?></a></h3>
                </div>
                <div class="panel-body">
					<p>Login name : <?php echo $item['username']?>
					<br />
					Join date : <?php echo date('Y-m-d', $item['created_at'])?></p>
					<p><a href="users/<?php echo $item['id'];?>/posts">View all users'posts <span class="glyphicon glyphicon-edit"></span></a>
					<br />
					<a href="users/<?php echo $item['id'];?>/comments">View all users'comments <span class="glyphicon glyphicon-comment"></span></a>
					</p>
				</div>
            </div>
            
		</div>
		<?php 		
			}
		}
		?>
		
		
		
      </div>
		<div class="container">
            <div class="row paging" style="text-align:left">
            
                <ul class="pagination">
                    <?php 
                    	  if (count($data) > 0) {	
                    	      $pagi = Pagination::instance('paginate'); 
                    
                              echo $pagi->render();
						  }
   					?>
                </ul>
            </div>
        </div>	
		
    </div><!-- /.container -->