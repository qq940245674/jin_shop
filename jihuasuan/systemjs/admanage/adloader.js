/**
 * adLoader
 * iwebshop的广告加载器
 * @author nswe
 */
function adLoader()
{
	var _self        = this;
	var _id          = null;
	var adKey        = null;
	var positionData = null;
	var adData       = [];

	/**
	 * @brief 加载广告数据
	 * @param positionJson 广告位数据
	 * @param adArray      广告列表数据
	 * @param boxId        广告容器ID
	 */
	this.load = function(positionJson,adArray,boxId)
	{
		_self.positionData = positionJson;
		_self.adData       = adArray;
		_self._id          = boxId;
		$('#'+_self._id).css('overflow','hidden');
		_self.show();
	}

	/**
	 * @brief 展示广告位
	 */
	this.show = function()
	{
		//顺序显示
		if(_self.positionData.fashion == 1)
		{
			_self.adKey = (_self.adKey == null) ? 0 : _self.adKey+1;

			if(_self.adKey >= _self.adData.length)
			{
				_self.adKey = 0;
			}
		}
		//随机显示
		else
		{
			var rand = parseInt(Math.random()*1000);
			_self.adKey = rand % _self.adData.length;
		}

		var adRow = _self.adData[_self.adKey];

		if(adRow.type == 4)
		{
			$('#'+_self._id).html(eval(adRow.data));
		}
		else
		{
			$('#'+_self._id).html(adRow.data);
		}

		//多个广告数据要依次展示
		if(_self.adData.length > 1)
		{
			window.setTimeout(function(){_self.show();},5000);
		}
	}
}