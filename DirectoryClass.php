<?php
class DirectoryClass {
	private $directoryPath;
	private $toExt;

	public function __construct($directoryPath = '', $newExt = '') {
		$this->directoryPath = $directoryPath;
		$this->toExt = $newExt;

		$this->handleAction();
	}

	protected function verifyPath() : bool {
		if(!is_dir($this->directoryPath)):
			return false;
		else:
			return true;
		endif;
	}

	protected function readDir() {
		$filesInDir = scandir($this->directoryPath);

		if ($filesInDir == false):
			return false;
		else:
			return $filesInDir;
		endif;
	}

	protected function retrieveFileInfo($file) : array {
		$file = array('ext'=>pathinfo($file, PATHINFO_EXTENSION),'name'=> pathinfo($file, PATHINFO_FILENAME));

		return $file;
	}

	protected static function changeFileExtention($new_name, $filename) {
		rename($this->directoryPath.$filename, $this->directoryPath.$new_name);
	}

	protected  function handleAction() {
		if ($this->verifyPath() == false):
			echo "The path specified is not a directory";
		else:
			$files = $this->readDir();
			if ($files == false):
				echo "No record was returned";
			else:
				foreach ($files as $file):
					$fileData = $this->retrieveFileInfo($file);
					if ($fileData['ext'] != $this->toExt and $fileData['ext'] != ''):
						$this->changeFileExtention($fileData['name'].".".$this->toExt, $file);
					endif;
				endforeach;

				echo "all done";
			endif;
		endif;
	}
}

$class = new DirectoryClass('../abia-ems/templates/', "php");
?>