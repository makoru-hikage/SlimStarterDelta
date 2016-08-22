<?php

namespace SlimStarter\TwigExtension;

use SlimStarter\Menu\MenuManager;

class MenuRenderer extends \Twig_Extension
{
    protected $menu;

    public function __construct(MenuManager $menu){
        $this->menu = $menu;
    }

    public function getName()
    {
        return 'menu_renderer';
    }

    public function getFunctions()
    {
        return array(
            new \Twig_SimpleFunction('render_menu', 
                [$this, 'renderMenu']
            )
        );
    }

    public function renderMenu($name, $tag = 'ul', $option)
    {
        return $this->menu->render($name, $tag, $option);
    }
}