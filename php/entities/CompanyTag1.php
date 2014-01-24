<?php

/** @Entity
  * @Table(name="companytag")
*/
class CompanyTag1
{
/** @Id @Column(type="bigint")
 * @GeneratedValue
 */
   private $companytagid;

      public function getcompanytagid(){
      return $this->companytagid;
      }

	  public function setcompanytagid($companytagid){
	   $this->companytagid=$companytagid;
	   }
	   
	   /** @Column(type="bigint")
 */
   private $companyid;

      public function getcompanyid(){
      return $this->companyid;
      }

	  public function setcompanyid($companyid){
	   $this->companyid=$companyid;
	   }
	   
	   /** @Column(type="bigint")
 */
   private $tagid;

      public function gettagid(){
      return $this->tagid;
      }

	  public function settagid($tagid){
	   $this->tagid=$tagid;
	   }
	   
	public function toJSON(){
	return '{ "companytagid":"'.$this->companytagid.'","companyid":"'.$this->companyid.'","tagid":"'.$this->tagid.'"}';
	 }
}
?>