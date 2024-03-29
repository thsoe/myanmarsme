<?php
//require_once './entities/DirectoryTag.php';
//require_once './entities/Tags.php';

/** @Entity
  * @Table(name="userdirectory")
*/
class UserDirectory
{
/** @Id @Column(type="bigint")
 * @GeneratedValue
 */
   private $directoryid;

      public function getdirectoryid(){
      return $this->directoryid;
      }

	  public function setdirectoryid($directoryid){
		$this->directorytag->setdirectorytagid($directoryid);
		$this->directoryid=$directoryid;
	   }
	   
	   /** @Column(type="string")
 */
   private $name;

      public function getname(){
      return $this->name;
      }

	  public function setname($name){
	   $this->name=$name;
	   }
	   
	   /** @Column(type="string")
 */
   private $colorcode;

      public function getcolorcode(){
      return $this->colorcode;
      }

	  public function setcolorcode($colorcode){
	   $this->colorcode=$colorcode;
	   }
	   
	   /** @Column(type="string")
 */
   private $description;

      public function getdescription(){
      return $this->description;
      }

	  public function setdescription($description){
	   $this->description=$description;
	   }
	   
	   /** @Column(type="string")
 */
   private $smeuseremail;

      public function getsmeuseremail(){
      return $this->smeuseremail;
      }

	  public function setsmeuseremail($smeuseremail){
	   $this->smeuseremail=$smeuseremail;
	   }
	   
	   /** @Column(type="integer")
 */
   private $public;

      public function getpublic(){
      return $this->public;
      }

	  public function setpublic($public){
	   $this->public=$public;
	   }
	   
	   /** @Column(type="integer")
 */
   private $rating;

      public function getrating(){
      return $this->rating;
      }

	  public function setrating($rating){
	   $this->rating=$rating;
	   }
	   
	 /**
     * @OneToOne(targetEntity="DirectoryTag",cascade={"all"})
     * @JoinColumn(name="directoryid", referencedColumnName="directoryid")
     **/
  
	protected $directorytag;
	   
	function __construct() {
          $this->directorytag = new DirectoryTag();
	}
	
	public function gettagid(){
	   return $this->directorytag->gettagid();
	   }
	public function settagid($tagid){
	   $this->directorytag->settagid($tagid);
	   }
	public function toJSON(){
	return '{ "directoryid":"'.$this->directoryid.'","name":"'.$this->name.'",
				"colorcode":"'.$this->colorcode.'","description":"'.$this->description.'",
				"smeuseremail":"'.$this->smeuseremail.'","public":"'.$this->public.'","rating":"'.$this->rating.'"}';
				//,"tagid":"'.$this->gettagid().'","tagname":"'.$this->directorytag->getTagname().'"				
	 }
	 
	 /**
     * @ManyToMany(targetEntity="Tags")
     * @JoinTable(name="DirectoryTag",
     *      joinColumns={@JoinColumn(name="directoryid", referencedColumnName="directoryid")},
     *      inverseJoinColumns={@JoinColumn(name="tagid", referencedColumnName="tagid")}
     *      )
     **--/
    private $tags;

    // ...

    public function __construct() {
        $this->tags = new \Doctrine\Common\Collections\ArrayCollection();
    }
	
	
	*/
}
?>