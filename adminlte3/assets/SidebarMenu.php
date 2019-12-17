<?php

namespace dashboard\assets;

use Yii;
use yii\helpers\Html;
use yii\helpers\ArrayHelper;
use yii\base\InvalidConfigException;

/**
 * Description of SideMenu3.
 *
 * @author Misbahul D Munir <misbahuldmunir@gmail.com>
 *
 * @since 1.0
 */
class SidebarMenu extends \yii\base\Widget
{
    /**
     * @var array the HTML attributes for the widget container tag
     *
     * @see \yii\helpers\Html::renderTagAttributes() for details on how attributes are being rendered.
     */
    public $options = ['class' => 'nav nav-pills nav-sidebar flex-column', 'role' => 'menu', 'data-accordion' => 'false'];
    /**
     * @var array list of items in the nav widget. Each array element represents a single
     *            menu item which can be either a string or an array with the following structure:
     *
     * - label: string, required, the nav item label.
     * - url: optional, the item's URL. Defaults to "#".
     * - visible: bool, optional, whether this menu item is visible. Defaults to true.
     * - linkOptions: array, optional, the HTML attributes of the item's link.
     * - options: array, optional, the HTML attributes of the item container (LI).
     * - active: bool, optional, whether the item should be on active state or not.
     * - dropDownOptions: array, optional, the HTML options that will passed to the [[Dropdown]] widget.
     * - items: array|string, optional, the configuration array for creating a [[Dropdown]] widget,
     *   or a string representing the dropdown menu. Note that Bootstrap does not support sub-dropdown menus.
     * - encode: bool, optional, whether the label will be HTML-encoded. If set, supersedes the $encodeLabels option for only this item.
     *
     * If a menu item is a string, it will be rendered directly without HTML encoding.
     */
    public $items = [];
    /**
     * @var bool whether the nav items labels should be HTML-encoded
     */
    public $encodeLabels = true;
    /**
     * @var bool whether to automatically activate items according to whether their route setting
     *           matches the currently requested route
     *
     * @see isItemActive
     */
    public $activateItems = true;
    /**
     * @var bool whether to activate parent menu items when one of the corresponding child menu items is active
     */
    public $activateParents = true;
    /**
     * @var string the route used to determine if a menu item is active or not.
     *             If not set, it will use the route of the current request.
     *
     * @see params
     * @see isItemActive
     */
    public $route;
    /**
     * @var array the parameters used to determine if a menu item is active or not.
     *            If not set, it will use `$_GET`.
     *
     * @see route
     * @see isItemActive
     */
    public $params;

    /**
     * Initializes the widget.
     */
    public function init()
    {
        parent::init();
        if ($this->route === null && Yii::$app->controller !== null) {
            $this->route = Yii::$app->controller->getRoute();
        }
        if ($this->params === null) {
            $this->params = Yii::$app->request->getQueryParams();
        }
        $this->options['data-widget'] = 'treeview';
    }

    /**
     * Renders the widget.
     */
    public function run()
    {
        return $this->renderItems($this->items, $this->options, 1);
    }

    /**
     * Renders widget items.
     */
    public function renderItems($items, $options = [], $level = 1)
    {
        $contents = [];
        foreach ($items as $item) {
            if (isset($item['visible']) && !$item['visible']) {
                continue;
            }
            $contents[] = $this->renderItem($item, $level);
        }

        return Html::tag('ul', implode("\n", $contents), $options);
    }

    /**
     * Renders a widget's item.
     *
     * @param string|array $item the item to render
     *
     * @return string the rendering result
     *
     * @throws InvalidConfigException
     */
    public function renderItem($item, $level)
    {
        if (is_string($item)) {
            return $item;
        }
        if (!isset($item['label'])) {
            throw new InvalidConfigException("The 'label' option is required.");
        }
        $encodeLabel = isset($item['encode']) ? $item['encode'] : $this->encodeLabels;
        $label = $encodeLabel ? Html::encode($item['label']) : $item['label'];

        $options = ArrayHelper::getValue($item, 'options', []);
        Html::addCssClass($options, 'nav-item');

        $items = ArrayHelper::getValue($item, 'items');

        $url = ArrayHelper::getValue($item, 'url', '');

        $linkOptions = ArrayHelper::getValue($item, 'linkOptions', []);
        Html::addCssClass($linkOptions, 'nav-link');

        $icon = ArrayHelper::getValue($item, 'icon', 'far fa-circle nav-icon');
        $badge = ArrayHelper::getValue($item, 'badge', '');
        $rightSections = [];

        $active = $this->isItemActive($item);

        if ($icon !== '') {
            $icon = Html::tag('i', '', ['class' => $icon]);
        }
        if (empty($items)) {
            $items = '';
        } else {
            $rightSections[] = '<i class="fas fa-angle-left right"></i>';
            Html::addCssClass($options, 'has-treeview');

            if (is_array($items)) {
                $items = $this->renderItems($items, ['class' => 'nav nav-treeview'], $level + 1);
            }
        }

        if (!empty($badge)) {
            $rightSections[] = $badge;
        }

        $menuLabel = "$icon <p>".$label.implode(' ', $rightSections).'</p>';

        if ($active) {
            Html::addCssClass($linkOptions, 'active');
            if (!empty($items)) {
                Html::addCssClass($options, 'menu-open');
            }
        }

        return Html::tag('li', Html::a($menuLabel, $url, $linkOptions).$items, $options);
    }

    /**
     * Checks whether a menu item is active.
     * This is done by checking if [[route]] and [[params]] match that specified in the `url` option of the menu item.
     * When the `url` option of a menu item is specified in terms of an array, its first element is treated
     * as the route for the item and the rest of the elements are the associated parameters.
     * Only when its route and parameters match [[route]] and [[params]], respectively, will a menu item
     * be considered active.
     *
     * @param array $item the menu item to be checked
     *
     * @return bool whether the menu item is active
     */
    protected function isItemActive($item)
    {
        if (!$this->activateItems) {
            return false;
        }
        if (isset($item['url']) && is_array($item['url']) && isset($item['url'][0])) {
            $route = $item['url'][0];
            if ($route[0] !== '/' && Yii::$app->controller) {
                $route = Yii::$app->controller->module->getUniqueId().'/'.$route;
            }
            if (ltrim($route, '/') !== $this->route) {
                return false;
            }
            unset($item['url']['#']);
            if (count($item['url']) > 1) {
                $params = $item['url'];
                unset($params[0]);
                foreach ($params as $name => $value) {
                    if ($value !== null && (!isset($this->params[$name]) || $this->params[$name] != $value)) {
                        return false;
                    }
                }
            }

            return true;
        }

        if (isset($item['items']) && is_array($item['items'])) {
            foreach ($item['items'] as $subItem) {
                if ($this->isItemActive($subItem)) {
                    return true;
                }
            }
        }

        return false;
    }
}
