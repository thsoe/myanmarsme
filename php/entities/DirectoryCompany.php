<?php

/** @Entity
  * @Table(name="directorycompany")
*/
class DirectoryCompany
{
/** @Id @Column(type="bigint")
 * @GeneratedValue
 */
   private $directoryCompnayid;

      public function getdirectoryCompnayid(){
      return $this->directoryCompnayid;
      }

	  public function setdirectoryCompnayid($directoryCompnayid){
	   $this->directoryCompnayid=$directoryCompnayid;
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
   private $directoryid;

      public function getdirectoryid(){
      return $this->directoryid;
      }

	  public function setdirectoryid($directoryid){
	   $this->directoryid=$directoryid;
	   }
	   
	   /** @Column(type="string")
 */
   private $compnayDescription;

      public function getcompnayDescription(){
      return $this->compnayDescription;
      }

	  public function setcompnayDescription($compnayDescription){
	   $this->compnayDescription=$compnayDescription;
	   }
	   
	   /** @Column(type="integer")
 */
   private $rank;

      public function getrank(){
      return $this->rank;
      }

	  public function setrank($rank){
	   $this->rank=$rank;
	   }
	   
	public function toJSON(){
	return '{ "directoryCompnayid":"'.$this->directoryCompnayid.'","companyid":"'.$this->companyid.'","directoryid":"'.$this->directoryid.'","compnayDescription":"'.$this->compnayDescription.'","rank":"'.$this->rank.'"}';
	 }
}
?>