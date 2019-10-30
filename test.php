<?php
/**
 * |-----------------------------------------------------------------------------------
 * @Copyright (c) 2014-2018, http://www.sizhijie.com. All Rights Reserved.
 * @Website: www.sizhijie.com
 * @Version: 思智捷信息科技有限公司
 * @Author : szjcomo 
 * |-----------------------------------------------------------------------------------
 */

require './vendor/autoload.php';

use szjcomo\drawing\Drawing;


//测试用例

//生成验证码
/*验证码配置项：
	'width'=>100,  //宽度
	'height'=>30,  //高度
	'lang'=>'zh',  //语言
	'bg_color'=>[255,255,255], //背景颜色
	'text_color'=>[0,0,0], 	   //文字颜色
	'fontSize'=>20,  		   //文字大小
	'angle'=>0, 			   //倾斜度
	'font'=>'en.ttf',  		   //字体
	'text'=>'5 + 6',  		   //需要绘的文字
	'use_curve'=>true,  	   //是否开启混淆线
	'position_x'=>'auto', 	   //开始绘制横向坐标位置 默认自动计算
	'position_y'=>'auto',      //开始绘制纵向坐标位置 默认自动计算
	'quality'=>80 			   //图片保存质量
	'filename'=>'' 			   //图片保存路径
	'callback'=>null    	   //如果传入了callback 那么用户自己处理 否则请传入filename自行保存
*/

Drawing::create([
	//'filename'=>'./test/'.time().'.jpg',
	'text'=>mt_rand(1,9).' + '.mt_rand(1,9),
	'callback'=>function($im){
		imagejpeg($im,'hello.jpg',60);
	}
]);