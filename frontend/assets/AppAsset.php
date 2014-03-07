<?php
/**
 * @link http://www.yiiframework.com/
 * @copyright Copyright (c) 2008 Yii Software LLC
 * @license http://www.yiiframework.com/license/
 */

namespace frontend\assets;

use yii\web\AssetBundle;

/**
 * @author Qiang Xue <qiang.xue@gmail.com>
 * @since 2.0
 */
class AppAsset extends AssetBundle
{
	public $basePath = '@webroot';
	public $baseUrl = '@web';
	public $css = [
            'plugins/form-datepicker/css/datepicker.css',
            'plugins/form-select2/select2.css',
            'css/styles.min.css', 
            'css/ie8.css', 
            'js/jqueryui.min.css', 
            'demo/variations/default.css',
            'css/styles.css?=120',
            'css/site.css'
            ];
	public $js = [
            'js/jquery.cookie.js',
            'js/jquery.nicescroll.min.js',
            'plugins/form-datepicker/js/bootstrap-datepicker.js',
            'plugins/form-select2/select2.min.js',
            'plugins/jquery-rateit/src/jquery.rateit.js'
            ];
	public $depends = [
		'yii\web\YiiAsset',
		'yii\bootstrap\BootstrapAsset',
	];
}
