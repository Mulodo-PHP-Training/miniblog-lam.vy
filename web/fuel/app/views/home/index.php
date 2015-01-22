    <div class="container">

      <div class="row">
        
        
		<?php 
				//loop data posts
				if (count($data) > 0) {
					foreach($data as $item) {
					
		?>
					<div class="col-md-6">
					  	<div class="panel panel-success">
			                <div class="panel-heading">
			                    <a href="posts/detail/<?php echo $item['id'];?>"><h3 class="panel-title"><?php echo $item['title'];?></h3></a>
			                </div>
			                <div class="panel-body">
								<p><a href="users/profile/<?php echo $item['author_id'];?>"><span class="glyphicon glyphicon-user"></span> : <?php echo $item['username'];?></a>
								<br />
								Post date : <?php echo date('Y-m-d',$item['created_at']);?></p>
							</div>
			            </div>
            
					</div>	
		<?php 
					}
				}
		?>
		
		
		
      </div>
		<div class="container">
			
            <div class="row paging">
            
                <ul class="pagination">
                    <?php $pagi = Pagination::instance('paginate'); ?>
   					<?php echo $pagi->render(); ?>
                </ul>
            </div>
        </div>	
		
    </div><!-- /.container -->
	