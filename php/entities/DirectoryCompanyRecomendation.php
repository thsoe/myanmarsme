<?php

/** @Entity
  * @Table(name="directorycompanyrecomendation")
*/
class DirectoryCompanyRecomendation
{
/** @Id @Column(type="bigint")
 * @GeneratedValue
 */
   private $id;

      public function getid(){
      return $this->id;
      }

	  public function setid($id){
	   $this->id=$id;
	   }
	   
	   /** @Column(type="bigint")
 */
   private $directorycompanyid;

      public function getdirectorycompanyid(){
      return $this->directorycompanyid;
      }

	  public function setdirectorycompanyid($directorycompanyid){
	   $this->directorycompanyid=$directorycompanyid;
	   }
	   
	   /** @Column(type="string")
 */
   private $recommendation;

      public function getrecommendation(){
      return $this->recommendation;
      }

	  public function setrecommendation($recommendation){
	   $this->recommendation=$recommendation;
	   }
	   
	   /** @Column(type="integer")
 */
   private $linkoption;

      public function getlinkoption(){
      return $this->linkoption;
      }

	  public function setlinkoption($linkoption){
	   $this->linkoption=$linkoption;
	   }
	   
	public function toJSON(){
	return '{ "id":"'.$this->id.'","directorycompanyid":"'.$this->directorycompanyid.'","recommendation":"'.$this->recommendation.'","linkoption":"'.$this->linkoption.'"}';
	 }
}
?>