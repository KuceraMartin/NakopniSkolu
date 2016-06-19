<?php

namespace App\Services;

use App\Model\Entity;
use Nette\Object;


class ImagePathGetter extends Object
{

	/** @var string */
	private $wwwDir;

	/** @var string */
	private $relativePath;

	/** @var string */
	private $blankImagePath;


	public function __construct(string $wwwDir, string $relativePath, string $blankImagePath)
	{
		$this->wwwDir = $wwwDir;
		$this->relativePath = $relativePath;
		$this->blankImagePath = $blankImagePath;
	}


	public function getPath(Entity $entity): string
	{
		$path = $this->constructPath($entity);
		if (file_exists("$this->wwwDir/$path")) {
			return $path;
		}
		return $this->blankImagePath;
	}

	public function constructPath(Entity $entity): string
	{
		return "$this->relativePath/$entity->id.jpg";
	}

}
