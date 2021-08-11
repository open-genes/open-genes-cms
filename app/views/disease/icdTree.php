<?php

/* @var $this \yii\web\View */
/* @var $icdTree array */
/* @var $depth int */

?>
<br>
<br>
<br>
<br>
<pre>
    <?php
        echo PHP_EOL . "Автоматически сгруппированные заболевания по {$depth} уровню дерева МКБ" . PHP_EOL . PHP_EOL;
        echo count($icdTree) . ' категорий' . PHP_EOL . PHP_EOL;
        foreach ($icdTree as $icdCategory => $diseases) {
            echo $icdCategory . ':' . PHP_EOL;
            foreach ($diseases as $omim => $disease) {
                echo "\t" . $omim . ' ' . $disease . PHP_EOL;
            }
            echo PHP_EOL;
        }
    ?>
</pre>
