var imgCount=0;
var deleteList="";
function clear(){
				   $("#popup #name").val("");
				   $("#popup #logoRow").html("");
				   $("#popup #logoRow").append("<a href=\"#\" id=\"logo\" class=\"attach\" >Attach Logo</a>");
				   $("#popup #logoRow").find("#logo").bind('click',logoClick);
				   $("#popup #desc").val("");
				   $("#popup #longDesc").val("");
				   $("#popup #attachImgRow").html("");
				   $("#popup #attachImgRow").append("<a href=\"#\" id=\"attachImg\" class=\"attach\" >Attach Image</a>");
				   $("#popup #attachImgRow").find("#attachImg").bind('click',imageClick);
				   $("#popup #businessAdd").val("");
				   $("#popup #worksiteAdd").val("");
				   $("#popup #contactNo1").val("");
				   $("#popup #contactNo2").val("");
				   $("#popup #rank").val("1");
				   $("#popup #advertisementRow").html("");
				   $("#popup #advertisementRow").append("<a href=\"#\" id=\"advertisement\" class=\"attach\" >Attach Advertisement Image</a>");
				   $("#popup #advertisementRow").find("#advertisement").bind('click',advertisementClick);
				   deleteList="";
				   
			}
			
			function _delete(){
				var id=$(this).parent().find(":hidden").val();
				var mode="delete";
				var data={id:id,mode:mode};
				
				var success=function(result,status,jrXHR){
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
					 url : "../php/company_service.php",
					 type : 'POST',
					 data : data,
					 success : success,
					 dataType : 'json' 
				});
				
			}
			
function logoClick(event){
	  try{
		  event.preventDefault();
		  $("#file").unbind('change');
		  $("#file").bind('change',fileChange);
		  $("#file").click();
		  $("#fieldId").val("logo");
	  }
	  catch(e){
		  alert(e.message);
	  }
  }
  
  function advertisementClick(event){
	  try{
		  event.preventDefault();
		  $("#file").unbind('change');
		  $("#file").bind('change',fileChange);
		  $("#file").click();
		  $("#fieldId").val("advertisement");
	  }
	  catch(e){
		  alert(e.message);
	  }
  }
  
  function imageClick(event){
	  try{
		  event.preventDefault();
		  $("#file").unbind('change');
		  $("#file").bind('change',fileChange);
		  $("#file").click();
		  $("#fieldId").val("attachImg");
	  }
	  catch(e){
		  alert(e.message);
	  }
  }
  
  function fileChange(event){
//	    	$("#hiddenFrame form").submit();
	  		event.preventDefault();
	  		if(!checkFileExtension(this)){
	  			return; 
	  		}
	    	  $("#loading")
	  		.ajaxStart(function(){
	  			$(this).show();
	  		})
	  		.ajaxComplete(function(){
	  			$(this).hide();
	  		});
	    	  
	  		$.ajaxFileUpload
	  		(
	  			{
	  				url:'../php/file_service.php',
	  				secureuri:false,
	  				fileElementId:'file',
	  				dataType: 'json',
	  				data:{name:'logan', id:'id',mode:'save', companyName : $("#name").val()},
	  				success: function (data, status)
	  				{
	  					
	  					if(typeof(data.error) != 'undefined')
	  					{
	  						if(data.error != '')
	  						{
	  							alert(data.error);
	  						}else
	  						{
	  							
	  							var fieldId=$("#fieldId").val();
	  							if(fieldId.indexOf("attachImg") > -1){
	  								imgCount += 1;
	  							}
	  							if(fieldId.indexOf("attachImg") > -1){
	  								$("<div><input type='checkbox' id='" + fieldId + (imgCount) + "' value=" + data.filePath + " checked />" + data.fileName + "</div>").insertBefore($("#" + fieldId + "Row").find("#attachImg"));
	  							}
	  							else{
	  								$("#" + fieldId + "Row").append($("<div><input type='checkbox' id='" + fieldId + "' value=" + data.filePath + " checked />" + data.fileName + "</div>"));
//	  								$("#"+fieldId+"Row").find("div").append($());
	  							}
	  							
	  							$("#"+fieldId+"Row").find("div").find("a").unbind("click");
	  							$("#"+fieldId+"Row").find("div").find(":checkbox").unbind("click");
	  							$("#file").unbind('change');
	  							$("#"+fieldId+"Row").find("div").find(":checkbox").bind("click", remove);
//	  							$("#"+fieldId+"Row").css("display","inline");
//	  							alert(data.msg);
	  							if(imgCount == 6 && (fieldId.indexOf("attachImg")) > -1){
	  								$("#"+fieldId+"Row").find("#attachImg").remove();
	  							}
	  							else if((fieldId.indexOf("attachImg")) == -1) {
	  								$("#"+fieldId+"Row").find("a").remove();
	  							}
	  						
	  						}
	  					}
	  					else{
	  					}
	  				},
	  				error: function (data, status, e)
	  				{
	  					alert(data.message);
	  				}
	  			}
	  		)
	  		
	  		return false;
  }
function edit(e){
	clear();
	$("#popup #id").val($(this).find("input:hidden").val());
	$("#popup #mode").val("edit");
	$("#popup #index").val($(this).index())
	$("#popup #name").val($(this).find("td:eq(0)").text());
	$("#popup #desc").val($(this).find("td:eq(1)").html());
	
	var longDesc=$(this).find("#longDesc").html();
	$("#popup #longDesc").val(longDesc);
	
	$("#popup #businessAdd").val($(this).find("td:eq(2)").text());
	$("#popup #worksiteAdd").val($(this).find("td:eq(3)").text());
	
	$("#popup #contactNo1").val($(this).find("td:eq(4)").text());
	$("#popup #contactNo2").val($(this).find("td:eq(5)").text());

	$("#popup #rank").val($(this).find("td:eq(6)").text());
	var logo=$(this).find("#logo").html();
	if(logo!=''){
		$("#logoRow").find("a").remove();
		$("#logoRow").append($("<div><input type='checkbox' id='logo' value="+logo+" checked />"+logo.substring(logo.lastIndexOf("/")+1)+"</div>"));
		$("#logoRow").find(":checkbox").bind('click',remove);
	}	
	
	var advertisement=$(this).find("#advertisement").html();
	if(advertisement!=''){
		$("#advertisementRow").find("a").remove();
		$("#advertisementRow").append($("<div><input type='checkbox' id='advertisement' value="+advertisement+" checked />"+advertisement.substring(advertisement.lastIndexOf("/")+1)+"</div>"));
		$("#advertisementRow").find(":checkbox").bind('click',remove);
	}	
	
	var count=0;
	var image1=$(this).find("#image1").html();
	if(image1!=''){
		count++;
		$("<div><input type='checkbox' id='attachImg1' value="+image1+" checked />"+image1.substring(image1.lastIndexOf("/")+1)+"</div>").insertBefore($("#attachImgRow").find("a"));
	}	
	
	var image2=$(this).find("#image2").html();
	if(image2!=''){
		count++;
		$("<div><input type='checkbox' id='attachImg2' value="+image2+" checked />"+image2.substring(image2.lastIndexOf("/")+1)+"</div>").insertBefore($("#attachImgRow").find("a"));
	}	
	
	var image3=$(this).find("#image3").html();
	if(image3!=''){
		count++;
		$("<div><input type='checkbox' id='attachImg3' value="+image3+" checked />"+image3.substring(image3.lastIndexOf("/")+1)+"</div>").insertBefore($("#attachImgRow").find("a"));
	}
	
	var image4=$(this).find("#image4").html();
	if(image4!=''){
		count++;
		$("<div><input type='checkbox' id='attachImg4' value="+image4+" checked />"+image4.substring(image4.lastIndexOf("/")+1)+"</div>").insertBefore($("#attachImgRow").find("a"));
	}	
	
	var image5=$(this).find("#image5").html();
	if(image5!=''){
		count++;
		$("<div><input type='checkbox' id='attachImg5' value="+image5+" checked />"+image5.substring(image5.lastIndexOf("/")+1)+"</div>").insertBefore($("#attachImgRow").find("a"));
	}	
	
	var image6=$(this).find("#image6").html();
	if(image6!=''){
		count++;
		$("<div><input type='checkbox' id='attachImg6' value="+image6+" checked />"+image6.substring(image6.lastIndexOf("/")+1)+"</div>").insertBefore($("#attachImgRow").find("a"));
		
		if(count==6)
			$("#attachImgRow").find("a").remove();
		imgCount=count;
	}
	$("#attachImgRow").find(":checkbox").bind('click',remove);
	
	
	 ShowDialog(true);
}
			
function load(){
	
	for(var i=1; i<=20; i++)
		$("#rank").append("<option>"+i+"</option>");
	
	$.ajax({
		url : '../php/company_service.php',
		type : 'POST',
		data : { mode:'retrieve'},
		dataType : 'json',
		success : function(result){
//			document.write(JSON.stringify(result));
//			return;
//			result=JSON.stringify(result);
//			result.replace();
//			result=JSON.parse(result);
			for(var i=0; i<result.length; i++){
				var company=result[i];
				var row="<tr>";
				row+="<tr>";
				row+="<td>"+company.name+"</td>";
//				 $table.="<td>".$company->getLogo()."</td>";
				row+="<td>"+company.description+"</td>";
//				 $table.="<td>".$company->getLongDesc()."</td>";
//				 $table.="<td>".$company-> getImage1()."</td>";
//				 $table.="<td>".$company-> getImage2()."</td>";
//				 $table.="<td>".$company-> getImage3()."</td>";
//				 $table.="<td>".$company-> getImage4()."</td>";
//				 $table.="<td>".$company-> getImage5()."</td>";
//				 $table.="<td>".$company-> getImage6()."</td>";
				row+="<td>"+company.businessAddress+"</td>";
				row+="<td>"+company.worksiteAddress+"</td>";
				row+="<td>"+company.contactNo1+"</td>";
				row+="<td>"+company.contactNo2+"</td>";
//				 $table.="<td>".$company->getAd()."</td>";
				row+="<td>"+company.rank+"</td>";
				row+="<td><div id='remove' ><a href='#'>delete</a></div><input type='hidden' value='"+company.id+"'>";
				row+="<div id='longDesc' style='display:none;'>"+company.longDesc+"</div>";
				row+="<div id='logo' style='display:none;'>"+company.logo+"</div>";
				row+="<div id='image1' style='display:none;'>"+company.image1+"</div>";
				row+="<div id='image2' style='display:none;'>"+company.image2+"</div>";
				row+="<div id='image3' style='display:none;'>"+company.image3+"</div>";
				row+="<div id='image4' style='display:none;'>"+company.image4+"</div>";
				row+="<div id='image5' style='display:none;'>"+company.image5+"</div>";
				row+="<div id='image6' style='display:none;'>"+company.image6+"</div>";
				row+="<div id='advertisement' style='display:none;'>"+company.ad+"</div>";
				 
				row+="</td>";
				row+="</tr>"
				 $("#data").append($(row));	 							
			}	
	      $("#data tr:gt(0)").bind("dblclick",edit);
	      $("div #remove").bind("click",_delete);
		},
		error :function(result,status,jaxqr){
//			alert("err"+result.responseText);
//			document.write(result.responseText);
			try{
				alert("error:"+result.responseText);
				$.parseJSON(result.responseText);
			}
			catch(e){
				alert(e.message);
			}
		}
					
	});
	
		$("#data tr:even").css('background-color','#F8F8F8');
	
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
	         var data={mode:"cancel"};
	         $.post("../php/file_service.php",data,function(result){
//	        	 alert(result);
	         });
	      });

	      $("#btnSave").click(function (e)
	      {
	         HideDialog();
	         e.preventDefault();
	         
	         var name=$("#name").val();
	         var desc=$("#desc").val();
	         var longDesc=$("#longDesc").val();
	         var logo="";
	         if($("#logoRow").find(":checkbox")!='undefined' && $("#logoRow").find(":checkbox")!=null)
	        	 logo=$("#logoRow").find(":checkbox").val();
	         var advertisement="";
	         if($("#advertisementRow").find(":checkbox")!='undefined' && $("#advertisementRow").find(":checkbox")!=null)
	        	 advertisement=$("#advertisementRow").find(":checkbox").val();
	         var contactNo1=$("#contactNo1").val();
	         var contactNo2=$("#contactNo2").val();
	         var rank=$("#rank").val();
	         var businessAdd=$("#businessAdd").val();
	         var worksiteAdd=$("#worksiteAdd").val();
	         var id=$("#id").val();
	         var mode=$("#mode").val();
	         var image={image1:'',image2:'',image3:'',image4:'',image5:'',image6:''};
	         var count=0;
	         $("#attachImgRow div").each(function(){
	        	 count++;
	        	 switch(count){
	        	 	case 1: image.image1 = $(this).find(":checkbox").val();
	        	 		break;
	        	 	case 2: image.image2 = $(this).find(":checkbox").val();
	        	 		break;
	        	 	case 3: image.image3 = $(this).find(":checkbox").val();
	        	 		break;
	        	 	case 4: image.image4 = $(this).find(":checkbox").val();
	        	 		break;
	        	 	case 5: image.image5 = $(this).find(":checkbox").val();
	        	 		break;
	        	 	case 6: image.image6 = $(this).find(":checkbox").val();
	        	 		break;
	        	 	default:
	        	 		
	        	 
	        	 }; 
	         });
	         
	        
	         var success= function(result,status,jqXHR){
		        	try{
			        	if(result.msg.indexOf('successfully') > -1){
				        	 var temp= "<tr><td>" + name + "</td><td>" + desc + "</td><td>" + businessAdd + "</td><td>" + worksiteAdd + "</td>";
					         temp += "<td>" + contactNo1 + "</td><td>" + contactNo2 + "</td><td>" + rank + "</td>";
					         temp += "<td><div id='remove'><a href='#'>delete</a></div>";
					         temp += "<input type='hidden' value='" + result.id + "'>";
					         temp += "<div id='longDesc' style='display:none;'>" + longDesc + "</div>";
					         temp += "<div id='logo' style='display:none;'>" + result.logo + "</div>";
					         temp += "<div id='image1' style='display:none;'>" + result.image1 + "</div>";
					         temp += "<div id='image2' style='display:none;'>" + result.image2 + "</div>";
					         temp += "<div id='image3' style='display:none;'>" + result.image3 + "</div>";
					         temp += "<div id='image4' style='display:none;'>" + result.image4 + "</div>";
					         temp += "<div id='image5' style='display:none;'>" + result.image5 + "</div>";
					         temp += "<div id='image6' style='display:none;'>" + result.image6 + "</div>";
					         temp += "<div id='advertisement' style='display:none;'>" + result.advertisement + "</div>";
					         temp += "</td><tr>";
					         var tr = $(temp);
					         $(tr).find("div").bind("click",_delete);
					         var mode = $("#mode").val();
					         var index = $("#index").val();
					         if(mode == "new"){
					         	$('#data tr:last').after($(tr).bind("dblclick",edit));
					         }
					         else if(mode="edit"){
					         //.after($("<td><div id="remove"><a href='#'>delete</a></div></td>").bind("click",_delete)
					         	$("#data tr:eq(" + index + ")").replaceWith($(tr).bind("dblclick",edit));
					         }
			        	}
			        	alert(result.msg);
		        	}
		        	catch(e){
		        		alert(e.message);
		        	}
		        };
	         
	       try{
		         var data={id:id,name:name,desc:desc,longDesc:longDesc,
		        		 logo:logo,image1:image.image1,image2:image.image2,image3:image.image3,
		        		 image4:image.image4,image5:image.image5,image6:image.image6,
		        		 contactNo1: contactNo1,contactNo2:contactNo2,businessAdd:businessAdd,worksiteAdd:worksiteAdd,
		        		 rank:rank,advertisement:advertisement, mode:mode,deleteList:deleteList};
		        $.ajax({
		        	url : "../php/company_service.php",
		        	type: 'POST',
		        	data : data,
		        	success : success,
		        	dataType : 'json'
		        });	 
		        
	       	}
	        catch(e){
	    	  alert(e.message);
	        }
	      });
	  
	      $("#logo").bind('click',logoClick);
	      $("#advertisement").click(advertisementClick);
	      $("#file").bind('change',fileChange);
	      $("#attachImg").bind('click',imageClick);
}

function remove(event){
	event.preventDefault();
	var fieldId=$(this).attr("id");
	var path=$(this).val();
	var cvalue=path;
	if(path.indexOf("..")!=0){
		path=".."+path;
		if(deleteList=='')
			deleteList=path;
		else
			deleteList+=","+path;
	}
	
	var data={mode:"delete",filePath:path};
	var success=function(result,status,jrXHR){
		var err="";
		if(typeof(result.error) != 'undefined' && result.error != '')
		{
			alert(result.error);
		}
		else{
			if(fieldId.indexOf("attachImg")==-1){
//				$("#"+fieldId+"Row").parent().html();
				$("#"+fieldId).parent().remove();
			}
			else if(fieldId.indexOf("attachImg")>-1){
				$("#"+fieldId).parent().remove();
			}
			if(fieldId=='logo'){
				$("#"+fieldId+"Row").append($("<a href=\"#\" id=\"logo\" class=\"attach\" >Attach Logo</a>"));
				$("#"+fieldId+"Row").find(".attach").bind('click',logoClick);
			}
			else if(fieldId=='advertisement'){
				$("#"+fieldId+"Row").append($("<a href=\"#\" id=\"advertisement\" class=\"attach\" >Attach Advertisement Image</a>"));
				$("#"+fieldId+"Row").find(".attach").bind('click',advertisementClick);
			}
			else if(fieldId.indexOf("attachImg")>-1 && imgCount==6){
				$("#attachImgRow").append($("<a href=\"#\" id=\"attachImg\" class=\"attach\" >Attach Image</a>"));
				$("#attachImg").bind('click',imageClick);
			}
//			$("#file").bind('change',fileChange);
			if(fieldId.indexOf("attachImg")>-1){
				imgCount-=1;
			}
			 $("#loading").hide();
		}
 };
 	if(cvalue.indexOf("..")==0){
		$.ajax({
				type: 'POST',
				url : "../php/file_service.php",
				data : data,
				success : success,
				dataType: 'json'
				});
 	}
 	else{
 		success("",null,null);
 	}
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
   
   function checkFileExtension(elem) {
       var filePath = elem.value;


       if(filePath.indexOf('.') == -1)
           return false;
       

       var validExtensions = new Array();
       var ext = filePath.substring(filePath.lastIndexOf('.') + 1).toLowerCase();

       validExtensions[0] = 'jpg';
       validExtensions[1] = 'jpeg';
       validExtensions[3] = 'png';
       validExtensions[4] = 'gif';
   

       for(var i = 0; i < validExtensions.length; i++) {
           if(ext == validExtensions[i])
               return true;
       }


       alert('The file extension ' + ext.toUpperCase() + ' is not allowed!');
       return false;
   } 