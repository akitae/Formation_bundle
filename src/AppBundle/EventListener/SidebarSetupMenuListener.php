<?php

namespace AppBundle\EventListener;

use AppBundle\Entity\User;
use Avanzu\AdminThemeBundle\Event\SidebarMenuEvent;
use Avanzu\AdminThemeBundle\Model\MenuItemModel;
use JMS\DiExtraBundle\Annotation as DI;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Security\Core\Authorization\AuthorizationChecker;

/**
 * Class SidebarSetupMenuListener.
 *
 * @DI\Service("menu.listener")
 */
class SidebarSetupMenuListener
{

    /**
     * @param SidebarMenuEvent $event
     * @DI\Observe("theme.sidebar_setup_menu")
     * @DI\Observe("theme.breadcrumb")
     */
    public function onSetupMenu(SidebarMenuEvent $event)
    {
        $request = $event->getRequest();

        foreach ($this->getMenu($request) as $item) {
            $event->addItem($item);
        }
    }

    protected function getMenu(Request $request)
    {
        $earg = array();

        $rootItems = [
            new MenuItemModel('objet', 'objet', 'objet_index', $earg, 'fa fa-indent'),
            new MenuItemModel('acheteur', 'acheteur', 'acheteur_index', $earg, 'fa fa-mobile'),
            new MenuItemModel('vendeur', 'vendeur', 'vendeur_index', $earg, 'fa fa-mobile'),
            new MenuItemModel('api/doc', 'api/doc','test.dev/api/doc', $earg, 'fa fa-laptop')

        ];



        return $this->activateByRoute($request->get('_route'), $rootItems);
    }

    protected function activateByRoute($route, $items)
    {
        // First check exact match
        $found = false;
        foreach ($items as $item) { /** @var $item MenuItemModel */
            if ($item->hasChildren()) {
                $this->activateByRoute($route, $item->getChildren());
            } else {
                if ($item->getRoute() == $route) {
                    $item->setIsActive(true);
                    $found = true;
                }
            }
        }
        // Then check approx match admin_A_*
        if (!$found) {
            $routeElts = explode('_', $route);
            if ($routeElts[0] == 'admin' && count($routeElts) == 3) {
                foreach ($items as $item) { /** @var $item MenuItemModel */
                    if ($item->hasChildren()) {
                        $this->activateByRoute($route, $item->getChildren());
                    } else {
                        $elts = explode('_', $item->getRoute());
                        if ($elts[0] == 'admin' && $elts[1] == $routeElts[1]) {
                            $item->setIsActive(true);
                        }
                    }
                }
            }
        }

        return $items;
    }
}
