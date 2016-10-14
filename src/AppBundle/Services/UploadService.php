<?php 
namespace AppBundle\Services;
use Symfony\Component\HttpFoundation\File\UploadedFile;

class UploadService {
	
	private $targetDir;

	public function __construct($targetDir) {
		$this->targetDir = $targetDir;
	}

	public function upload(UploadedFile $file) {
		
		$filename = md5(uniqid()).'.'.$file->getClientOriginalExtension();

		$file->move($this->targetDir, $filename);

		return $filename;
	}	
}
