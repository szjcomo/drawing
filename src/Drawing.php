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
 * 验证码类
 */
class Drawing 
{
	/**
	 * [create 输出验证码]
	 * @Author   szjcomo
	 * @DateTime 2019-10-24
	 * @param    array      $config [description]
	 * @param    string     $type   [description]
	 * @return   [type]             [description]
	 */
	public static function create(array $config = [],string $type = 'verify')
	{
		$instance = null;
		switch ($type) {
			default:
				$instance = new Verify($config);
				break;
		}
		return $instance->create($config);
	}
}