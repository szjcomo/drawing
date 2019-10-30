<?php
/**
 * |-----------------------------------------------------------------------------------
 * @Copyright (c) 2014-2018, http://www.sizhijie.com. All Rights Reserved.
 * @Website: www.sizhijie.com
 * @Version: 思智捷信息科技有限公司
 * @Author : szjcomo 
 * |-----------------------------------------------------------------------------------
 */

namespace szjcomo\drawing\verify;
/**
 * 数字验证码
 */
class General
{
	/**
	 * [$chars 数字集合]
	 * @var string
	 */
	protected static $CODE_SET = '2345678abcdefhijkmnpqrstuvwxyzABCDEFGHJKLMNPQRTUVWXY';
	/**
	 * [getCode 获取随机数字]
	 * @author 	   szjcomo
	 * @createTime 2019-10-30
	 * @param      int|integer $length [description]
	 * @return     [type]              [description]
	 */
	public static function getCode(int $length = 4):string
	{
		$str = '';
		$len = strlen(self::$CODE_SET);
		while ($length--) {
			$str .= self::$CODE_SET[mt_rand(0,$len - 1)];
		}
		return $str;
	}

}
