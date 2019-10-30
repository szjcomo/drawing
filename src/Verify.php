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
 * 数字验证码类
 */
class Verify extends AbstractDrawing
{
	/**
	 * [$config 配置项]
	 * @var array
	 */
	protected $config = [
		'width'=>100,'height'=>30,'lang'=>'zh','bg_color'=>[255,255,255],'text_color'=>[0,0,0],
		'fontSize'=>20,'angle'=>0,'font'=>'','text'=>'5 + 6','use_curve'=>true,
		'position_x'=>'auto','position_y'=>'auto','quality'=>80
	];
	/**
	 * [$im 图片img]
	 * @var [type]
	 */
	protected $im;
	/**
	 * [__construct 构造函数]
	 * @Author   szjcomo
	 * @DateTime 2019-10-24
	 * @param    array      $config [description]
	 */
	public function __construct(array $config = [])
	{
		putenv('GDFONTPATH=' . realpath('.'));
		if(!isset($config['font'])) $this->config['font'] = str_replace('\\','/',dirname(__DIR__)).'/en.ttf';
		$this->config = array_merge($this->config,$config);
	}
	/**
	 * [create 创建数字验证码]
	 * @Author   szjcomo
	 * @DateTime 2019-10-24
	 * @return   [type]     [description]
	 */
	public function create()
	{
		return $this->addCanvas()->fillBgColor()->fillText()->fillInterferenceLine()->show();
	}

	/**
	 * [save 输入或保存图片]
	 * @Author   szjcomo
	 * @DateTime 2019-10-24
	 * @return   [type]     [description]
	 */
	protected function show()
	{
		if(isset($this->config['callback'])){
			return call_user_func($this->config['callback'],$this->im);
		} else {
			if(isset($this->config['filename'])) imagejpeg($this->im,$this->config['filename'],$this->config['quality']);
			return $this->config['filename'];
		}
	}

	/**
	 * [addCanvas 生成一张画布]
	 * @Author   szjcomo
	 * @DateTime 2019-10-24
	 */
	protected function addCanvas()
	{
		$this->im = imagecreate($this->config['width'],$this->config['height']) or die("Cannot Initialize new GD image stream");
		return $this;
	}
	/**
	 * [fillBgColor 填充画布背景]
	 * @Author   szjcomo
	 * @DateTime 2019-10-24
	 * @return   [type]     [description]
	 */
	protected function fillBgColor()
	{
		$rgbarr = $this->hex2rgb($this->config['bg_color']);
		$isTrue = imagecolorallocate($this->im,$rgbarr[0],$rgbarr[1],$rgbarr[2]);
		if($isTrue == -1) throw new \Exception(self::$ErrorMessage[$this->config['lang']]['bg_color_error']);
		return $this;
	}
	/**
	 * [fillText 在画布上画文字]
	 * @Author   szjcomo
	 * @DateTime 2019-10-24
	 * @return   [type]     [description]
	 */
	protected function fillText()
	{
		$rgbarr = $this->hex2rgb($this->config['text_color']);
		$text_color = imagecolorallocate($this->im,$rgbarr[0],$rgbarr[1],$rgbarr[2]);
		if($text_color == -1) throw new \Exception(self::$ErrorMessage[$this->config['lang']]['text_color_error']);
		$tmparr = imagettfbbox($this->config['fontSize'],$this->config['angle'],$this->config['font'],$this->config['text']);
		$position_x = $this->config['position_x'] === 'auto'?intval(($this->config['width'] - $tmparr[2])/2):$this->config['position_x'];
		$position_y = $this->config['position_y'] === 'auto'?intval(($this->config['height'] + $tmparr[7]) / 2) + abs($tmparr[7]):$this->config['position_y'];
		imagettftext($this->im,$this->config['fontSize'],$this->config['angle'],$position_x>0?$position_x:0,$position_y,$text_color,$this->config['font'],$this->config['text']);
		return $this;
	}

	/**
	 * [fillInterferenceLine 线制干扰线]
	 * @Author   szjcomo
	 * @DateTime 2019-10-24
	 * @return   [type]     [description]
	 */
	protected function fillInterferenceLine()
	{
		if($this->config['use_curve'] !== true) return $this;
		$rgbarr = $this->hex2rgb($this->config['text_color']);
		$text_color = imagecolorallocate($this->im,$rgbarr[0],$rgbarr[1],$rgbarr[2]);
       	$px = $py = 0;
        // 曲线前部分
        $A = mt_rand(1, $this->config['height'] / 2); // 振幅
        $b = mt_rand(-$this->config['height'] / 4, $this->config['height'] / 4); // Y轴方向偏移量
        $f = mt_rand(-$this->config['height'] / 4, $this->config['height'] / 4); // X轴方向偏移量
        $T = mt_rand($this->config['height'], $this->config['width'] * 2); // 周期
        $w = (2 * M_PI) / $T;
        $px1 = 0; // 曲线横坐标起始位置
        $px2 = mt_rand($this->config['width'] / 2, $this->config['width'] * 0.8); // 曲线横坐标结束位置
        for ($px = $px1; $px <= $px2; $px = $px + 1) {
            if (0 != $w) {
                $py = $A * sin($w * $px + $f) + $b + $this->config['height'] / 2; // y = Asin(ωx+φ) + b
                $i  = (int) ($this->config['fontSize'] / 8);
                while ($i > 0) {
                    imagesetpixel($this->im, $px + $i, $py + $i, $text_color); // 这里(while)循环画像素点比imagettftext和imagestring用字体大小一次画出（不用这while循环）性能要好很多
                    $i--;
                }
            }
        }
        // 曲线后部分
        $A   = mt_rand(1, $this->config['height'] / 2); // 振幅
        $f   = mt_rand($this->config['height'] / 4, $this->config['height'] / 4); // X轴方向偏移量
        $T   = mt_rand($this->config['height'], $this->config['width'] * 2); // 周期
        $w   = (2 * M_PI) / $T;
        $b   = $py - $A * sin($w * $px + $f) - $this->config['height'] / 2;
        $px1 = $px2;
        $px2 = $this->config['width'];
        for ($px = $px1; $px <= $px2; $px = $px + 1) {
            if (0 != $w) {
                $py = $A * sin($w * $px + $f) + $b + $this->config['height'] / 2; // y = Asin(ωx+φ) + b
                $i  = (int) ($this->config['fontSize'] / 8);
                while ($i > 0) {
                    imagesetpixel($this->im, $px + $i, $py + $i, $text_color);
                    $i--;
                }
            }
        }
		return $this;
	}
	/**
	 * [__destruct 析构函数]
	 * @author 	   szjcomo
	 * @createTime 2019-10-30
	 */
	public function __destruct()
	{
		echo '析构函数执行'.PHP_EOL;
		if($this->im) imagedestroy($this->im);
	}

}