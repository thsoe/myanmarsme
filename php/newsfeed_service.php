<?php error_reporting(E_ALL);
  ini_set("display_errors", 1); 
  header('Cache-Control: no-cache, must-revalidate');
  header('Content-type: application/json');?>
<?php require_once 'include/connection_util.php';
 ?>
<?php
	$msg="";
	if(isset($_POST["mode"])){
		$feed=new NewsFeed();	
		if(isset($_POST["url"]))	
			$feed->setUrl($_POST["url"]);
		if(isset($_POST["title"]))
			$feed->setTitle(str_replace("\\'","'",$_POST["title"]));
		if(isset($_POST["snippet"]))
			$feed->setSnippet(str_replace("\\'","'",$_POST["snippet"]));
		if($_POST["mode"] == "new"){
			try{
				ConnectionUtil::beginTransaction();
				ConnectionUtil::save($feed);
				ConnectionUtil::commit();
				 $msg = "successfully saved!";
			}
			catch(Exception $e){
				ConnectionUtil::rollback();
				$msg = $e->getMessage();
			} 
		}
		else if( $_POST["mode"] == "edit"){
			try{
				$id=$_POST["preUrl"];
				ConnectionUtil::beginTransaction();
				$dql="update NewsFeed n set n.url='".$feed->getUrl()."',n.title='".$feed->getTitle()."',n.snippet='".$feed->getSnippet()."' where n.url='".$id."'";
				ConnectionUtil::execute($dql);
				ConnectionUtil::commit();
				$msg = "successfully updated!";
			}
			catch(Exception $e){
				ConnectionUtil::rollback();
				$msg = $e->getMessage();
			} 
		}
		else if($_POST["mode"]=="delete"){
			try{
								
				ConnectionUtil::beginTransaction();
				$feed=ConnectionUtil::find("NewsFeed",$_POST["url"]);
				
				ConnectionUtil::delete($feed);
				ConnectionUtil::commit();
				$msg = "successfully deleted!";
			}
			catch(Exception $e){
				ConnectionUtil::rollback();
				$msg = $e->getMessage();
			} 	
		}
	}
	
	
	if($_POST["mode"] == 'retrieve'){
//		$users=ConnectionUtil::findAllWithLimit('IndustrialZone',array(),20,1);
		$feeds=ConnectionUtil::findAll('NewsFeed');
		echo "[\n";
		$i=0;		
		foreach($feeds as $feed){
			if($i > 0)
				echo ",";
			echo $feed->toJSON();
			$i++;
		}
		echo "]\n";
	}
	else{
		echo "{";
		echo				"\"msg\": \"" . $msg . "\"";
		echo "}";
	}
?>