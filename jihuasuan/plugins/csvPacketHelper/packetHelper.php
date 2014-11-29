<?php
/**
 * @brief data packet help abstract
 * @date 2013/8/31 23:15:30
 * @author nswe
 */
abstract class packetHelper
{
	//csv source image path
	protected $sourceImagePath;

	//csv target image path
	protected $targetImagePath;

	//csv file convert array data
	protected $dataLine;
	/**
	 * constructor,open the csv packet date file
	 * @param string $csvFile csv file name
	 * @param string $targetImagePath create csv image path
	 */
	public function __construct($csvFile,$targetImagePath)
	{
		if(!preg_match('|^[\w\-]+$|',basename($csvFile,'.csv')))
		{
			throw new Exception('the csv file name must use english');
		}

		if(!file_exists($csvFile))
		{
			throw new Exception('the csv file is not exists!');
		}

		if(!is_dir($targetImagePath))
		{
			throw new Exception('the save csv image dir is not exists!');
		}

		$content = file_get_contents($csvFile);
		if(function_exists('mb_detect_encoding') && mb_detect_encoding($content) != 'utf-8')
		{
			$content = iconv('UCS-2','UTF-8//IGNORE',$content);
		}

		$this->dataLine  = $this->csvConvertArray($content);

		$this->sourceImagePath = dirname($csvFile).'/'.basename($csvFile,'.csv');
		$this->targetImagePath = $targetImagePath;

		if(!$this->dataLine)
		{
			throw new Exception('the csv file is empty!');
		}
	}
	/**
	 * delete useless line until csv title position
	 * @param array $dataLine csv line array
	 * @param array $title csv title
	 * @return array
	 */
	protected function seekStartLine(&$dataLine,$title)
	{
		foreach($dataLine as $lineNum => $lineContent)
		{
			unset($dataLine[$lineNum]);
			if(strpos($lineContent,current($title)) !== false)
			{
				break;
			}
		}
		return $dataLine;
	}
	/**
	 * the mapping with column's num
	 * @param array $dataLine csv line array
	 * @param array $titleArray csv title
	 * @return array key and cols mapping
	 */
	protected function getColumnNum(&$dataLine,$titleArray)
	{
		$titleMapping  = array();
		$cvsTitle      = array();

		foreach($dataLine as $lineNum => $lineContent)
		{
			if(strpos($lineContent,current($titleArray)) !== false)
			{
				$cvsTitle = explode($this->getLineSeparator(),$lineContent);
				break;
			}
		}

		if(!$cvsTitle)
		{
			throw new Exception('can not match cvs title information');
		}

		foreach($cvsTitle as $key => $title)
		{
			if(in_array($title,$titleArray))
			{
				$titleMapping[$key] = $title;
			}
		}
		return $titleMapping;
	}
	/**
	 * get data from csv file
	 * @return array
	 */
	public function collect()
	{
		$mapping  = $this->getColumnNum($this->dataLine,$this->getDataTitle());
		$dataLine = $this->seekStartLine($this->dataLine,$this->getDataTitle());

		$packArray = array();
		$result    = array();
		$temp      = array();

		foreach($dataLine as $lineNum => $lineContent)
		{
			$packArray = explode($this->getLineSeparator(),$lineContent);
			foreach($mapping as $key => $title)
			{
				$temp[$title] = $this->runCallback($packArray[$key],$title);
			}
			$result[] = $temp;
		}
		return $result;
	}
	/**
	 * run title callback function
	 * @return mix
	 */
	public function runCallback($content,$title)
	{
		$configCallback = $this->getTitleCallback();
		if(isset($configCallback[$title]))
		{
			return call_user_func(array($this,$configCallback[$title]),$content);
		}
		return $content;
	}
	/**
	 * get data image path
	 * @return string
	 */
	public function getImagePath()
	{
		return $this->imagePath;
	}
	/**
	 * get every line separator
	 * @return string
	 */
	abstract public function getLineSeparator();
	/**
	 * get useful column in csv file
	 * @return array
	 */
	abstract public function getDataTitle();
	/**
	 * format csv text data convert to array data
	 * @param string $csvContent csv content data
	 * @return array
	 */
	abstract public function csvConvertArray($csvContent);
	/**
	 * get function config from title callback
	 * @return array
	 */
	abstract public function getTitleCallback();
}