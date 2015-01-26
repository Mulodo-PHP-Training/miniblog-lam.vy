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
                    <a href="posts/detail/<?php echo $item['id']?>"><h3 class="panel-title"><?php echo $item['title']?></h3></a>
                </div>
                <div class="panel-body">
					<p>
					<br />
					Post date : <?php echo date('Y-m-d', $item['created_at'])?><br />Modified date : <?php echo date('Y-m-d', $item['modified_at'])?></p>
				</div>
            </div>
            
		</div>
        
		<?php 
		    }
		}
		
		?>
		
		
		
      </div>
			
		
    </div><!-- /.container -->