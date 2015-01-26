/**
 * This is file contain function for action comment
 */

$(document).ready(function() {
  load_comment();
  $("#submit").click(function(){
	 
	  var content = $("#cm-content").val();
	  var post_id = $("#cm-post_id").val();
	  
      $.ajax({
          url: "comments/create",
          type: "POST",
          data: "content="+content+"&post_id="+post_id,
          success: function(msg) {
        	  
              $("#rs-comment").html(msg);
			  load_comment();
			  
          }
      });
	return false;
  });

  function load_comment() {
		var post_id = $("#cm-post_id").val();	
		  
	    $.ajax({
	        url: "comments/get_all_post_comment",
	        type: "POST",
	        data: "post_id="+post_id,
	        success: function(msg) { 
		        var data = JSON.parse(msg);
	        	
	        	var rs = "";
	        	for(i = 0; i < data.data.length; i++) {
					
	        		rs += '<div class="col-sm-12" >'
	        		        +'<p><a href="#"><h4>'+data.data[i].username+'</h4></a> <span class="content-comment" cid="'+data.data[i].id+'">'+data.data[i].content+'</span>'
	        				+'<span class="comment"> '+data.data[i].created_at+' - <span class="link-comment" cid="'+data.data[i].id+'"><span class="glyphicon glyphicon-edit"></span></span> - <span class="del-comment" cid="'+data.data[i].id+'">'
	        				     +'<span class="glyphicon glyphicon-remove"></span></span>'	
	        				+'</p>'
	        				+'	<div class="edit-comment" cid="'+data.data[i].id+'">'
			        				+'<h3>Edit comment</h3>'
			        				+'<form class="form-horizontal"  >'
			        				+'	<div class="form-group">'
			        					
			        				+'		<div class="col-sm-12">'
			        				+'		 <textarea class="form-control" rows="3" placeholder="enter comment here..." cid="'+data.data[i].id+'" name="u-comment"></textarea>'
			        				+'		</div>'
			        				+'	</div>'
			        				 
			        				+'	<div class="form-group">'
			        				+'		<div class=" col-sm-12">'
			        				+'		  <button type="button" class="btn btn-success" name="update" cid="'+data.data[i].id+'" >Update comment</button>'
			        				+'		  <button type="button" class="btn btn-success cancel" cid="'+data.data[i].id+'" name="cancel">Cancel</button>'
			        				+'		</div>'
			        				+'	</div>'
			        				+'</form>'
			        		+'  </div>	'
	        				+'</div>';
    				
    				
			    }
	        	$("#all-comment").html(rs);
	        	$(".link-comment").click(function(){
	        		id = $(this).attr("cid");
					$(".edit-comment[cid="+id+"]").show();
					content = $(".content-comment[cid="+id+"]").text();
					$(".form-control[cid="+id+"]").text(content);
					$(".form-control[cid="+id+"]").focus();
	        		
	        	});
	        	$("button[name=cancel]").click(function(){
	    			
					id = $(this).attr("cid");
					
					$(".edit-comment[cid="+id+"]").hide();
					$(".link-comment[cid="+id+"]").focus();
			    });

	        	$(".del-comment").click(function(){
	        	   
	        	    if(window.confirm("Are you sure you want to delete this comment?")){
		        	    comment_id = $(this).attr("cid");
	        	    	$.ajax({
	        	            url: "comments/delete",
	        	            type: "POST",
	        	            data: "id="+comment_id+"&post_id="+post_id,
	        	            success: function(msg) {
		        	           if (msg == 1) {
	        	          	      load_comment();
		        	           } else if (msg == 2) {
									alert ("Sorry! You don't have permission for delete this comment");
			        	       } else if (msg == 0) {
			        	    	   alert ("Sorry! You must be logged for this action");
			        	       }
	        	  			  
	        	            }
	        	        });
	        	    }
	        	    else{
	        	        return false;
	        	    }
	          });
	          //update comment
	          $("button[name=update]").click(function(){
	        	  cid = $(this).attr("cid");
	        	  ucontent = $("textarea[cid="+cid+"]").val();
	        	  //call ajax to update
	        	  $.ajax({
      	            url: "comments/update",
      	            type: "POST",
      	            data: "comment_id="+cid+"&post_id="+post_id+"&content="+ucontent,
      	            success: function(msg) {
      	            	   //check result return 
	        	           if (msg == 1) {
	        	        	 alert("Update comment success!");  
      	          	         load_comment();
	        	           } else if (msg == 2){
								alert ("Sorry! You don't have permission for edit this comment");
		        	       } else {
		        	    	   alert("Sorry! The comment must be filled in.")
		        	       }
      	  			  
      	            }
      	        });
	          });	
	          
	        }
		});

	}

  
  
});


