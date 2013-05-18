<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed'); 
class DirectoryItems{
	private $filearray = array();
	private $config=array();

	public function createListFile($directory, $replacechar = "_"){
		$this->directory = $directory;
		$this->replacechar=$replacechar;
		$d = "";
		if (is_dir($this->directory)) {
			$d = opendir($this->directory) or die("Couldn't open directory." );
			while (false !==($f=readdir($d))) {
				if (is_file("$this->directory/$f")) {
					$title = $this->createTitle($f);
					$this->filearray[$title] = $f;
				}
			}
		closedir($d);
			}else {
				//error
				die ("Must pass in a directory.");
			}
	}

	public function getFileArray(){
		return $this->filearray;
	}

	public function indexOrder(){
		sort($this->filearray);
	}
	////////////////////////////////////////////////////////////////////
	public function naturalCaseInsensitiveOrder(){
		natcasesort($this->filearray);
	}
	////////////////////////////////////////////////////////////////////
	public function getCount(){
		return count($this->filearray);
	}
	
	function checkAllImages(){
		$bln = true;
		$extension = "";
		$types = array("jpg","jpeg","gif","png","JPG");
		foreach ($this->filearray as $key => $value){
			$extension = substr($value,(stripos($value, ".") + 1), 3);
			$extension = strtolower($extension);
			if(!in_array($extension, $types)){
				$bln = false;
				break;
			}
		}
		return $bln;
	}
	private function createTitle($title){
		//strip extension
		$title = substr($title,0,stripos($title, "."));
		//replace word separator
		$title = str_replace($this->replacechar," ",$title);
		return $title;
		}

	public function checkAllSpecificType($extension){
		$extension = strtolower($extension);
		$bln = true;
		$ext = "";
		foreach ($this->filearray as $key => $value){
		$ext = substr($value,(strpos($value, ".") + 1));
		$ext = strtolower($ext);
		if($extension != $ext){
		$bln = false;
		break;
		}
		}
		return $bln;
		}

	public function filter($extension){
		$extension = strtolower($extension);
		foreach ($this->filearray as $key => $value){
			$ext = substr($key,(strpos($key, ".")+1));
			$ext = strtolower($ext);
			if($ext != $extension){
				unset ($this->filearray[$key]);
				}
			}
		}

	public function removeFilter(){
		unset($this->filearray);
		$d = "";
		$d = opendir($this->directory) or die("Couldn't open directory.");
		while(false !== ($f = readdir($d))){
			if(is_file("$this->directory/$f")){
				$title = $this->createTitle($f);
				$this->filearray[$f] = $title;
				}
			}
		closedir($d);
		}
	public function imagesOnly(){
		$extension = "";
		$types = array("jpg", "jpeg", "gif", "png");
		foreach($this->filearray as $key => $value){
			$extension = substr($value,(strpos($value, ".") + 1),3);
			$extension = strtolower($extension);
				if(!in_array($extension, $types)){
					unset($this->filearray[$key]);
				}
			}
		}

}
?>