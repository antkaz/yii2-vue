<p align="center">
    <a href="https://vuejs.org/" target="_blank" rel="external">
        <img src="https://camo.githubusercontent.com/728ce9f78c3139e76fa69925ad7cc502e32795d2/68747470733a2f2f7675656a732e6f72672f696d616765732f6c6f676f2e706e67" width="200" />
    </a>
    <h1 align="center">Vue.js Extension for Yii2</h1>
    <br>
</p>

This is the <a href="https://vuejs.org/" target="_blank">Vue.js</a> extension for Yii2.

# Installation

The preferred way to install this extension is through composer.

Run

```bash
php composer.phar require antkaz/yii2-vue
```

or add

```
"antkaz/yii2-vue": "~1.0"
```

to the **require** section of your `composer.json` file.

## Usage

After installing the extension, just use it in your code:

```php
<?php

use antkaz\vue\Vue;
use \yii\web\JsExpression;
?>
<div class="vue">
    <?php Vue::begin([
        'clientOptions' => [
            'data' => [
                'message' => 'Hello Vue!'
            ],
            'methods' => [
                'reverseMessage' => new JsExpression("function() {this.message = this.message.split('').reverse().join('')}")
            ]
        ]
    ]) ?>

    <p>{{ message }}</p>
    <button v-on:click="reverseMessage">Reverse Message</button>

    <?php Vue::end() ?>
</div>
```

Alternative method without using a widget:

```php
<?php

use antkaz\vue\VueAsset;
VueAsset::register($this); // register VueAsset
?>

<div id="app" class="vue">

    <p>{{ message }}</p>
    <button v-on:click="reverseMessage">Reverse Message</button>

</div>

<script>
    var app = new Vue({
        el: '#app',
        data: {
            message: 'Hello Vue.js!'
        },
        methods: {
            reverseMessage: function () {
                this.message = this.message.split('').reverse().join('')
            }
        }
    })
</script>
```

