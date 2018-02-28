<?php
/**
 * @link https://github.com/antkaz/yii2-vue
 * @copyright Copyright (c) 2018 Anton Kazarinov
 * @license https://github.com/antkaz/yii2-vue/blob/master/LICENSE
 */

namespace antkaz\vue;

use yii\web\AssetBundle;
use yii\web\View;

/**
 * Class VueAsset
 *
 * Registers Vue.js
 *
 * @author Anton Kazarinov <askazarinov@gmail.com>
 * @package antkaz\vue
 */
class VueAsset extends AssetBundle
{
    /**
     * @inheritdoc
     */
    public $sourcePath = '@npm/vue/dist';

    /**
     * @inheritdoc
     */
    public $js = [
        YII_ENV_DEV ? 'vue.js' : 'vue.min.js',
    ];

    /**
     * @inheritdoc
     */
    public $jsOptions = [
        'position' => View::POS_HEAD,
    ];
}