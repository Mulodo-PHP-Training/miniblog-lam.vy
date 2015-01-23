<div class="row">
	 <div class="col-md-12">
		<h3>List all posts <a href="posts/create"><button type="button" class="btn btn-success btn-sm" >Create post</button></a></h3>
			<?php if(isset($result)) echo html_entity_decode($result)?>
			<?php if (isset($data) && count($data) > 0) { ?>
                <table class="table table-hover">
					
                    <thead>
                        <tr class="success">
                            <th width="10%">No</th>
                            <th width= "40%">Title</th>
                            <th width="20%">Created date</th>
                            <th width="5%">Edit</th>
                            <th width="5%">Delete</th>
							<th width="10%">Status</th>
							<th width="20%">Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php 
                        $no = 0 ;
                        foreach ($data as $item) {
							$no++;
						?>    
						<tr>
                            <td><?php echo $no?></td>
                            <td><a href="posts/update/<?php echo $item['id']?>"><?php echo $item['title']?></a></td>
                            <td><?php echo date('Y-m-d H:i:m', $item['created_at'])?></td>
                            <td><a href="posts/update/<?php echo $item['id']?>"><span class="glyphicon glyphicon-edit"></span></a></td>
                            <td><a href="posts/delete/<?php echo $item['id']?>" onclick="return xacnhan('Are you sure want to delete this post?');"><span class="glyphicon glyphicon-remove"></span></a></td>
							
							<?php 
							//check status
							if ($item['status'] == 1) {
								echo "
				                       <td>Published</td>
				                       <td><a href=\"posts/$item[id]/unpublish\" class=\"btn btn-success btn-xs\" style=\"width:72px\">Un Publish</a></td>
				                       ";
								
							} else echo "
					                   <td>Un Published</td>
				                       <td><a href=\"posts/$item[id]/publish\" class=\"btn btn-success btn-xs\" style=\"width:72px\">Publish</a></td>";
							?>
							
                        </tr>                    	
						<?php 
                        }
                        ?>
						
                    </tbody>
                </table>
                <?php }?>
	 </div>
</div>
<script type="text/javascript">
        function xacnhan(text) {
            if (!window.confirm(text)) {
                return false;
            }
            return true;            
        }
</script>