 <div class="container">
		<?php if (isset($result)) echo html_entity_decode($result)?>
      <div class="row">
      <?php 
      if (count($data) > 0) {
			//show data result
			foreach ($data as $item) {
      ?>
        <div class="col-md-12">
		   <div class="panel panel-success">
                
                <div class="panel-heading">
					<p>In post : <a href="posts/detail/<?php echo $item['post_id']?>"><b><?php echo $item['title']?></b></a>
					<br />
					Post date : <?php echo date('Y-m-d', $item['created_at'])?><br />
					Modified date : <?php echo date('Y-m-d', $item['modified_at'])?>
					</p>
				</div>
				<div class="panel-body">
                    <p><?php echo $item['content']?></p>
                </div>
            </div>
        </div>
		<?php 
		    }
		}
		
		?>
		
		
		
      </div>
			
		
    </div><!-- /.container -->