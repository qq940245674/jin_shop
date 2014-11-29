<?php
/**
 * @copyright (c) 2009-2011 jihuasuan.cn
 * @file view_action.php
 * @brief 视图动作
 * @author Ben
 * @date 2010-12-16
 * @version 0.6
 */

/**
 * @class IViewAction
 * @brief 视图动作
 */
class IViewAction extends IAction
{
	public $defaultView = 'index';
	public $viewPath;
	public $view;
	public $basePath;

	/**
	 * @brief 执行视图渲染
	 * @return 视图
	 */
	public function run()
	{
		$controller = $this->getController();
		IInterceptor::run("onCreateView",$controller);

		$this->resolveView($this->getView());
		$data = null;

		if(file_exists($this->view.$controller->extend))
		{
			$controller->render($this->view,$data);
		}
		else
		{
			$path = $this->view.$controller->extend;
			$path = IException::pathFilter($path);
			$data = array(
				'title'   => 'HTTP 404',
				'heading' => 'not found',
				'message' => "not found this view page($path)",
			);
			throw new IHttpException($data,404);
		}
		IInterceptor::run("onFinishView");
	}

	/**
	 * @brief 获取视图
	 * @return string 获取视图
	 */
	public function getView()
	{
		if($this->viewPath == '')
		{
			$action = $this->getId();
			$this->viewPath = $action ? $action : $this->defaultView;
		}
		return $this->viewPath;
	}

	/**
	 * @brief 解析视图路径
	 * @param string $viewPath 视图名称
	 */
	public function resolveView($viewPath)
	{
		$viewPath = IFilter::act($viewPath,'filename');

		//分割模板目录的层次
		$view = strtr($viewPath,'-','/');

		$this->view = $this->basePath = $this->getController()->getViewFile($view);
	}
}