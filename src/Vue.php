<?php
/**
 * @link https://github.com/antkaz/yii2-vue
 * @copyright Copyright (c) 2018 Anton Kazarinov
 * @license https://github.com/antkaz/yii2-vue/blob/master/LICENSE
 */

namespace antkaz\vue;

use yii\base\InvalidConfigException;
use yii\base\Widget;
use yii\helpers\Html;
use yii\helpers\Json;
use yii\web\JsExpression;
use yii\web\View;

/**
 * Class Vue
 *
 * @author Anton Kazarinov <askazarinov@gmail.com>
 * @package antkaz\vue
 */
class Vue extends Widget
{
    /**
     * @var array The data object for the Vue instance.
     *
     * @see https://vuejs.org/v2/api/index.html#data
     */
    public $data;

    /**
     * @var array Methods to be mixed into the Vue instance.
     *
     * @see https://vuejs.org/v2/api/index.html#methods
     */
    public $methods;

    /**
     * @var array The HTML tag attributes for the widget container tag.
     *
     * @see \yii\helpers\Html::renderTagAttributes() for details on how attributes are being rendered.
     */
    public $options = [];

    /**
     * @var array The options for the Vue.js.
     *
     * @see https://vuejs.org/v2/api/#Options-Data for informations about the supported options.
     */
    public $clientOptions = [];

    /**
     * Initializes the Vue.js.
     *
     * This method will initializes the HTML attributes for container.
     * After will be registered the Vue asset bundle.
     * If you override this method, make sure you call the parent implementation first.
     *
     * @throws \yii\base\InvalidArgumentException
     */
    public function init()
    {
        parent::init();

        $this->initOptions();
        $this->initClientOptions();
        $this->registerJs();
    }

    /**
     * Initializes the HTML tag attributes for the widget container tag.
     */
    protected function initOptions()
    {
        if (!isset($this->options['id'])) {
            $this->options['id'] = $this->getId();
        }
    }

    /**
     * Initializes the options for the Vue object
     */
    protected function initClientOptions()
    {
        if (!isset($this->clientOptions['el'])) {
            $this->clientOptions['el'] = "#{$this->getId()}";
        }

        $this->initData();
        $this->initMethods();
    }

    /**
     * Initializes the data object for the Vue instance
     */
    protected function initData()
    {
        if (empty($this->data)) {
            return;
        }

        if (is_array($this->data) || $this->data instanceof JsExpression) {
            $this->clientOptions['data'] = $this->data;
        } elseif (is_string($this->data)) {
            $this->clientOptions['data'] = new JsExpression($this->data);
        }
    }

    /**
     * Initializes methods to be mixed into the Vue instance.
     *
     * @throws InvalidConfigException
     */
    protected function initMethods()
    {
        if (empty($this->methods)) {
            return;
        }

        if (!is_array($this->methods)) {
            throw new InvalidConfigException("The 'items' option are not an array");
        }

        foreach ($this->methods as $methodName => $handler) {
            $function = $handler instanceof JsExpression ? $handler : new JsExpression($handler);
            $this->clientOptions['methods'][$methodName] = $function;
        }
    }

    /**
     * Registers a specific asset bundles.
     * @throws \yii\base\InvalidArgumentException
     */
    protected function registerJs()
    {
        VueAsset::register($this->getView());

        $options = Json::htmlEncode($this->clientOptions);
        $js = "var app = new Vue({$options})";
        $this->getView()->registerJs($js, View::POS_END);
    }

    /**
     * @inheritdoc
     */
    public static function begin($config = [])
    {
        $object = parent::begin($config);

        echo Html::beginTag('div', $object->options);

        return $object;
    }

    /**
     * @inheritdoc
     */
    public static function end()
    {
        echo Html::endTag('div');

        return parent::end();
    }
}