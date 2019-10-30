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
 * 获取表达式验证码
 */
class Express
{

	/**
	 * [getCode 获取表达式]
	 * @author 	   szjcomo
	 * @createTime 2019-10-30
	 * @return     [type]     [description]
	 */
	public static function getCode(string $type = 'auto')
	{
		$arrs = ['plusExpress','subExpress','multExpress','divExpress'];
		$arr = ['+'=>'plusExpress','-'=>'subExpress','*'=>'multExpress','/'=>'divExpress','auto'=>$arrs[mt_rand(0,count($arrs) - 1)]];
		$action = $arr[$type];
		return self::$action();
	}
	/**
	 * [plusExpress 生成加法表达式]
	 * @author 	   szjcomo
	 * @createTime 2019-10-30
	 * @return     [type]     [description]
	 */
	protected static function plusExpress()
	{
		$number1 = self::getNumberRand();
		$number2 = self::getNumberRand($number1);
		return ['text'=>$number1 .' + ' . $number2,'result'=>$number2 + $number1]; 
	}

	/**
	 * [getNumberRand 获取随机数]
	 * @author 	   szjcomo
	 * @createTime 2019-10-30
	 * @return     [type]     [description]
	 */
	protected static function getNumberRand(int $discard = 0)
	{
		if($discard === 0) return mt_rand(1,9);
		$odd = $discard % 2 !== 0;
		$arr = range(1,9,2);
		if($odd) $arr = range(2,8,2);
		return $arr[mt_rand(0,count($arr) - 1)];
	}

	/**
	 * [subExpress 减法表达式]
	 * @author 	   szjcomo
	 * @createTime 2019-10-30
	 * @return     [type]     [description]
	 */
	protected static function subExpress()
	{
		$number1 = self::getNumberRand();
		$number2 = self::getNumberRand($number1);
		$result = 0;
		$text = '';
		if($number1 > $number2){
			$text = $number1 .' - '. $number2;
			$result = $number1 - $number2;
		} elseif($number1 == $number2){
			$text = $number1 .' - '. $number2;
		} else {
			$text = $number2 .' - '. $number1;
			$result = $number2 - $number1;
		}
		return ['text'=>$text,'result'=>$result];
	}
	/**
	 * [multExpress 获取乘法表达式]
	 * @author 	   szjcomo
	 * @createTime 2019-10-30
	 * @return     [type]     [description]
	 */
	protected static function multExpress()
	{
		$number1 = self::getNumberRand();
		$number2 = self::getNumberRand($number1);
		$text = $number1 .' × '.$number2;
		$result = $number1 * $number2;
		return ['text'=>$text,'result'=>$result];
	}
	/**
	 * [divExpress 获取除法表达式]
	 * @author 	   szjcomo
	 * @createTime 2019-10-30
	 * @return     [type]     [description]
	 */
	protected static function divExpress()
	{
		$tmp = [];
		$number1 = mt_rand(2,9);
		do{
			$total = mt_rand(9,18);
			if($total % $number1 == 0){
				$tmp = ['text'=>$total .' ÷ '.$number1,'result'=>$total/$number1];
				break;
			}
		}while (true);
		return $tmp;
	}
}