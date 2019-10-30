<?php
/**
 * |-----------------------------------------------------------------------------------
 * @Copyright (c) 2014-2018, http://www.sizhijie.com. All Rights Reserved.
 * @Website: www.sizhijie.com
 * @Version: 思智捷信息科技有限公司
 * @Author : szjcomo 
 * |-----------------------------------------------------------------------------------
 */
namespace szjcomo\drawing;

/**
 * 抽像类
 */
abstract class AbstractDrawing
{
	/**
	 * 错误信息提示
	 */
	Protected static $ErrorMessage = [
		'zh'=>[
			'bg_color_error'	=>'画布颜色分配失败',
			'text_color_error' 	=>'文字颜色分配失败'
		]
	];
	
	/**
	 * [create 定义实现创建验证码]
	 * @Author   szjcomo
	 * @DateTime 2019-10-24
	 * @return   [type]     [description]
	 */
	abstract public function create();
	/**
	 * [hex2rgb 十六进制颜色转rgb数组]
	 * @Author   szjcomo
	 * @DateTime 2019-10-24
	 * @param    string/array     $hex []
	 * @return   [type]          [description]
	 */
	public static function hex2rgb($color)
	{
		if(!self::checkIsHex($color)) return $color;
		$hexColor = str_replace('#', '', $color);
		$lens = strlen($hexColor);
		if ($lens != 3 && $lens != 6) {
		    return false;
		}
		$newcolor = '';
		if ($lens == 3) {
		    for ($i = 0; $i < $lens; $i++) {
		        $newcolor .= $hexColor[$i] . $hexColor[$i];
		    }
		} else {
		    $newcolor = $hexColor;
		}
		$hex = str_split($newcolor, 2);
		$rgb = [];
		foreach ($hex as $key => $vls) {
		    $rgb[] = hexdec($vls);
		}
		return $rgb;
	}

	/**
	 * [checkIsHex 检测是否十六进制的颜色代码]
	 * @Author   szjcomo
	 * @DateTime 2019-10-24
	 * @param    [type]     $color [description]
	 * @return   [type]            [description]
	 */
	public static function checkIsHex($color):bool
	{
		return is_array($color)?false:true;
	}
}