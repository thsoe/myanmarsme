
function clear(){
				   $("#name").val("");
				   $("#latitude").val("");
				   $("#longitude").val("");
				   $("#address").val("");
				   $("#contactNo").val("");
				   $("#contactNo2").val("");
				   $("#contactNo3").val("");
				   $("#area").val("");
				   $("#stateDivision").val("");
				   $("#midcZone").val("");
				   
				   $("#estYear").val(new Date().getFullYear());
				   $("#industrialCountry").val("");
			}
			
			function _delete(){
				var id=$(this).parent().find(":hidden").val();
				var mode="delete";
				var data={id:id,mode:mode};
				
				var success=function (result,status,jqXHR){
		        	if(result.msg.indexOf('successfully')>-1){
		        		try{
		        			$("#data").find(":hidden[value='"+id+"']").parent().parent().remove();
		        		}
		        		catch(e){
		        			alert(e.message);
		        		}
		        	}
		        	alert(result.msg);
				};
				 $.ajax({
					 url : "../php/zone_service.php",
					 type : 'POST',
					 data : data,
					 success : success, 
					 dataType : 'json'
				});
				
			}
			function edit(e){
				$("#id").val($(this).find(":hidden").val());
				$("#mode").val("edit");
				$("#name").val($(this).find("td:eq(0)").text());
				$("#longitude").val($(this).find("td:eq(1)").text());
				$("#latitude").val($(this).find("td:eq(2)").text());
				$("#address").val($(this).find("td:eq(3)").text());
				$("#contactNo").val($(this).find("td:eq(4)").text());
				$("#contactNo2").val($(this).find("td:eq(5)").text());
				$("#contactNo3").val($(this).find("td:eq(6)").text());
				$("#area").val($(this).find("td:eq(7)").text());
				$("#stateDivision").val($(this).find("td:eq(8)").text());
				$("#midcZone").val($(this).find("td:eq(9)").text());
				$("#estYear").val($(this).find("td:eq(10)").text());
				$("#industrialCountry").val($(this).find("td:eq(11)").text());
				 $("#mode").val("edit");
				 $("#index").val($(this).index())
				 ShowDialog(true);
			}
			
			function load(){
				var date = new Date();
				var cYear = date.getFullYear();
				for(var i=-10;i<10;i++){
					if(cYear==(cYear+i)){
						$("#estYear").append("<option selected='true'>"+(cYear+i)+"</option>");
					}
					else{
						$("#estYear").append("<option>"+(cYear+i)+"</option>");
					}
				}
				
				$.ajax({
					url : '../php/zone_service.php',
					type : 'POST',
					data : { mode:'retrieve'},
					//dataType : 'json',
					success : function(result){
//						document.write(JSON.stringify(result));
						for(var i=0; i<result.length; i++){
							var user=result[i];
//							alert(JSON.stringify(user));
							var row="<tr>";
							 row+="<td>"+user.name+"</td>";
							 row+="<td>"+user.lat+"</td>";
							 row+="<td>"+user.lng+"</td>";
							 row+="<td>"+user.address+"</td>";
							 row+="<td>"+user.contactNo+"</td>";
							 row+="<td>"+user.contactNo2+"</td>";
							 row+="<td>"+user.contactNo3+"</td>";
							 row+="<td>"+user.area+"</td>";
							 row+="<td>"+user.stateDivision+"</td>";
							 row+="<td>"+user.midcZone+"</td>";
							 row+="<td>"+user.establishmentYear+"</td>";
							 row+="<td>"+user.industryCount+"</td>";
							 row+="<td><div id='remove' ><a href='#'>delete</a></div><input type='hidden' value='"+user.id+"'></td>";
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
				         
				         var name=$("#name").val();
				         var latitude=$("#latitude").val();
				         var longitude=$("#longitude").val();
				         var address=$("#address").val();
				         var contactNo=$("#contactNo").val();
				         var contactNo2=$("#contactNo2").val();
				         var contactNo3=$("#contactNo3").val();
				         var area=$("#area").val();
				         var stateDivision=$("#stateDivision").val();
				         var midcZone=$("#midcZone").val();
				         var estYear=$("#estYear").val();
				         var industrialCountry=$("#industrialCountry").val();
				         var id=$("#id").val();
				         var mode=$("#mode").val();
				       try{
					         var data={id:id,name:name,latitude:latitude,longitude:longitude,
					        		 address:address,contactNo:contactNo, contactNo2: contactNo2,
					        		 contactNo3:contactNo3,area:area,stateDivision:stateDivision,
					        		 midcZone:midcZone,estYear:estYear,industrialCountry:industrialCountry,
					        		 mode:mode};
					         
					    var success=function (result,status,jqXHR){
						        	try{
							        	if(result.msg.indexOf('successfully')>-1){
								        	 var temp="<tr><td>"+name+"</td><td>"+latitude+"</td><td>"+longitude+"</td><td>"+address+"</td>";
									         temp+="<td>"+contactNo+"</td><td>"+contactNo2+"</td><td>"+contactNo3+"</td><td>"+area+"</td>";
									         temp+="<td>"+stateDivision+"</td><td>"+midcZone+"</td><td>"+estYear+"</td><td>"+industrialCountry+"</td>";
									         temp+="<td><div id='remove'><a href='#'>delete</a></div><input type='hidden' value='" + result.id + "'></td><tr>";
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
					        		url : "../php/zone_service.php",
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
				      
				  	$("#data tr:even").css('background-color','#F8F8F8');
			
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