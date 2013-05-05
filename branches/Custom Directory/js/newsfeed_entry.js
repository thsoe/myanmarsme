function clear(){
				   $("#url").val("");
				   $("#title").val("");
				   $("#snippet").val("");
			}
			
			function _delete(){
				var url=$(this).parent().parent().find("td:eq(0) a").attr("href");
				var mode="delete";
				var data={url:url,mode:mode};
				var index=$(this).parent().parent().index();
				var success=function (result,status,jqXHR){
		        	if(result.msg.indexOf('successfully')>-1){
		        		try{
		        			$("#data").find("tr:eq("+index+")").remove();
		        		}
		        		catch(e){
		        			alert(e.message);
		        		}
		        	}
		        	alert(result.msg);
				};
				 $.ajax({
					 url : "../php/newsfeed_service.php",
					 type : 'POST',
					 data : data,
					 success : success, 
					 dataType : 'json'
				});
				
			}
			function edit(e){
				$("#mode").val("edit");
				$("#url").val($(this).find("td:eq(0) a").attr("href"));
				$("#preUrl").val($(this).find("td:eq(0) a").attr("href"));
				$("#title").val($(this).find("td:eq(0) a").text());
				$("#snippet").val($(this).find("td:eq(1)").text());
				$("#index").val($(this).index())
				 ShowDialog(true);
			}
			
			function load(){
				$("#data tr:even").css('background-color','#F8F8F8');
				
				$.ajax({
					url : '../php/newsfeed_service.php',
					type : 'POST',
					data : { mode:'retrieve'},
					dataType : 'json',
					success : function(result){
//						document.write(JSON.stringify(result));
						for(var i=0; i<result.length; i++){
							var feed=result[i];
//							alert(JSON.stringify(user));
							var row="<tr>";
							 row+="<td align='center'><a href='"+feed.url+"' id='url' >"+feed.title+"</a></td>";
							 row+="<td>"+feed.snippet+"</td>";
							 row+="<td><div id='remove' ><a href='#'>delete</a></div></td>";
							 row+="</tr>"
							 $("#data").append($(row));	 							
						}	
				      $("#data tr:gt(0)").bind("dblclick",edit);
				      $("div #remove").bind("click",_delete);
					}
								
				});
				
				      $("#add").click(function (e)
				      {
				    	 try{
				      	 clear();
				      	 $("#mode").val("new");
				         ShowDialog(true);
				         e.preventDefault();
				    	 }
				    	 catch(a){
				    		 alert(a.message);
				    	 }
				      });
				      
				      

				      $("#btnCancel").click(function (e)
				      {
				         HideDialog();
				         e.preventDefault();
				      });

				      $("#btnSave").click(function (e)
				      {
				         HideDialog();
				         e.preventDefault();
				         
				         var url=$("#url").val();
				         var title=$("#title").val();
				         var snippet=$("#snippet").val();
				         var mode=$("#mode").val();
				         var preUrl=$("#preUrl").val();
				       try{
					         var data={url:url,title:title,snippet:snippet,mode:mode,preUrl:preUrl};
					    var success=function (result,status,jqXHR){
						        	try{
							        	if(result.msg.indexOf('successfully')>-1){
								        	 var temp="<tr><td align='center'><a href='"+url+"' id='url'>"+title+"</a></td><td>"+snippet+"</td>";
									         temp+="<td><div id='remove'><a href='#'>delete</a></div></td><tr>";
									         var tr=$(temp);
									         $(tr).find("div").bind("click",_delete);
									         var mode=$("#mode").val();
									         var index=$("#index").val();
									         if(mode=="new"){
									         	$('#data tr:last').after($(tr).bind("dblclick",edit));
									         }
									         else if(mode="edit"){
									         //.after($("<td><div id="remove">-</div></td>").bind("click",_delete)
									         	$("#data tr:eq("+index+")").replaceWith($(tr).bind("dblclick",edit));
									         }
							        	}
							        	alert(result.msg);
						        	}
						        	catch(e){
						        		alert(e.message);
						        	}
						        };
					        $.ajax({
					        		url : "../php/newsfeed_service.php",
					        		data : data,
					        		type : 'POST',
					        		success : success,
					        		dataType:'json'
					      });	 
				       }
					      catch(e){
					    	  alert(e.message);
					      }
				      });
			
			}
			
			
			
			function ShowDialog(modal)
			{
			     $("#overlay").show();
			     $("#popup").fadeIn(300);
			     if (modal)
			     {
			        $("#overlay").unbind("click");
			     }
			     else
			     {
			      	$("#overlay").click(function (e)
			        {
			           HideDialog();
			        });
			     }
			}

		   function HideDialog()
		   {
		      $("#overlay").hide();
		      $("#popup").fadeOut(300);
		   } 