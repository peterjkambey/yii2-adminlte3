<?php

namespace dashboard\assets;

use Yii\helpers\Html;
use yii\helpers\Url;

?>

<?php
class SidebarMenu2 extends \yii\widgets\Menu
{
    public function run()
    {
        return Html::tag('nav', Html::tag('ul', $this->renderItems($this->items), ['class' => 'nav nav-pills nav-sidebar flex-column', 'data-widget' => 'treeview', 'role' => 'menu', 'data-accordion' => 'false']), ['class' => 'mt-2']);
    }

    protected function renderItem($item)
    {
    }

    protected function renderItems($items)
    {
        $navitem = '';
        foreach ($items as $i => $item) {
            if (isset($item['url'])) {
                $navitem .= '<li class="nav-item"> <a href="'.Url::to($item['url']).'" class="nav-link"> <i class="far fa-circle nav-icon"></i> <p>'.$item['label'].'</p> </a> </li>';
            } else {
                $navitem .= '<li class="nav-item has-treeview menu-open"> <a href="#" class="nav-link"> <i class="far fa-circle nav-icon"></i> <p>'.$item['label'].'</p> </a> </li>';
            }
        }

        return $navitem;
    }
}
