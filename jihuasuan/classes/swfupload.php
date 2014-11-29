<?php
/**
 * @copyright Copyright(c) 2011 jihuasuan.cn
 * @file swfupload.php
 * @brief swfupload上传组件
 * @author nswe
 * @date 2013/3/18 15:54:25
 */
class Swfupload
{
	//插件路径
	public $path;

	//提交地址
	public $submit;

	/**
	 * @brief 构造函数
	 * @param string $submit 处理地址
	 */
	public function __construct($submit = '')
	{
		$this->path   = IUrl::creatUrl().'plugins/swfupload/';
		$this->submit = $submit ? $submit : '/goods/goods_img_upload';

echo <<< OEF
	<script type="text/javascript" src="{$this->path}swfupload.js"></script>
	<script type="text/javascript" src="{$this->path}handlers.js"></script>
OEF;
	}

	/**
	 * @brief 展示插件
	 * @param string $name 用户名
	 * @param string $pwd  密码
	 */
	public function show($name = '',$pwd = '')
	{
		$sessionName = ISafe::name();
		$sessionId   = ISafe::id();
		$uploadUrl   = IUrl::creatUrl($this->submit);
		$admin_name  = ($name == '') ? ISafe::get('admin_name') : $name;
		$admin_pwd   = ($pwd  == '') ? ISafe::get('admin_pwd')  : $pwd;

echo <<< OEF
		<script type="text/javascript">
		window.onload = function()
		{
			new SWFUpload({
				// Backend Settings
				upload_url: "{$uploadUrl}",
				post_params: {"{$sessionName}": "{$sessionId}","admin_name":"{$admin_name}","admin_pwd":"{$admin_pwd}"},

				// File Upload Settings
				file_types : "*.jpg;*.jpge;*.png;*.gif",

				// Event Handler Settings - these functions as defined in Handlers.js
				//  The handlers are not part of SWFUpload but are part of my website and control how
				//  my website reacts to the SWFUpload events.
				swfupload_preload_handler : preLoad,
				swfupload_load_failed_handler : loadFailed,
				file_queue_error_handler : fileQueueError,
				file_dialog_complete_handler : fileDialogComplete,
				upload_progress_handler : uploadProgress,
				upload_error_handler : uploadError,
				upload_success_handler : uploadSuccess,
				upload_complete_handler : uploadComplete,

				// Button Settings
				button_placeholder_id : "uploadButton",
				button_width: 50,
				button_height: 21,
				button_text : '选择...',
				button_window_mode: SWFUpload.WINDOW_MODE.TRANSPARENT,
				button_cursor: SWFUpload.CURSOR.HAND,

				// Flash Settings
				flash_url : "{$this->path}swfupload.swf",

				custom_settings : {
					upload_target : "divFileProgressContainer"
				},

				// Debug Settings
				debug: false
			});
		};
		</script>
OEF;
	}
}