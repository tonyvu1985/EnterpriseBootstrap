<?php
/*
 * Top menu block
 *
 * @category    Responsive
 * @package     Responsive_Page
 * @author      Tony Vu <vuductrung2003@gmail.com>
 */

class Tvcom_Page_Block_Html_Topmenu extends Mage_Page_Block_Html_Topmenu
{    
    protected function _getHtml(Varien_Data_Tree_Node $menuTree, $childrenWrapClass)
    {
        $html = '';

        $children = $menuTree->getChildren();
        $parentLevel = $menuTree->getLevel();
        $childLevel = is_null($parentLevel) ? 0 : $parentLevel + 1;

        $counter = 1;
        $childrenCount = $children->count();

        $parentPositionClass = $menuTree->getPositionClass();
        $itemPositionClassPrefix = $parentPositionClass ? $parentPositionClass . '-' : 'nav-';

        foreach ($children as $child) {
            
            $child->setLevel($childLevel);
            $child->setIsFirst($counter == 1);
            $child->setIsLast($counter == $childrenCount);
            $child->setPositionClass($itemPositionClassPrefix . $counter);

            $outermostClassCode = '';
            $outermostClass = $menuTree->getOutermostClass();
            
            if ($child->hasChildren()) {
                if ($childLevel == 0 && $outermostClass) {
                    $outermostClassCode = ' class="' . $outermostClass . '"';
                    $child->setClass($outermostClass);
                }
            }            
            $html .= '<li ' . $this->_getRenderedMenuItemAttributes($child) . '>';                        
            
            if ($childLevel == 0){ // Top level 0 
                if($child->hasChildren()){                
                    $html   .= '<a href="#" class="dropdown-toggle" data-toggle="dropdown">'
                            . $this->escapeHtml($child->getName()) . '<b class="caret"></b>' .
                            '</a>';                
                }
                else{
                    $html .= '<a href="' . $child->getUrl() . '" ' . $outermostClassCode . '>'
                            . $this->escapeHtml($child->getName()) . '</a>';
                }
            }else{                
                    $html .= '<a href="' . $child->getUrl() . '" ' . $outermostClassCode . '>'
                            . $this->escapeHtml($child->getName()) . '</a>';
                
            }
            
            if ($child->hasChildren()) {
                if (!empty($childrenWrapClass)) {
                    $html .= '<div class="' . $childrenWrapClass . '">';
                }
                $html .= '<ul class="level' . $childLevel . ' dropdown-menu">';
                $html .= $this->_getHtml($child, $childrenWrapClass);
                /* last link to the parent category */
                $html .= '<li class="divider"></li>';
                $html .= '<li>' . '<a id="nav-parentlink" href="' . $child->getUrl() . '">'
                            . $this->escapeHtml($child->getName()) . '</a></li>';
                $html .= '</ul>';

                if (!empty($childrenWrapClass)) {
                    $html .= '</div>';
                }
            }
            
            $html .= '</li>';

            $counter++;
        }

        return $html;
    }

    /**
    * Returns array of menu item's classes
    *
    * @param Varien_Data_Tree_Node $item
    * @return array
    */
   protected function _getMenuItemClasses(Varien_Data_Tree_Node $item)
   {
       $classes = array();

       $classes[] = 'level' . $item->getLevel();
       $classes[] = $item->getPositionClass();

       if ($item->getIsFirst()) {
           $classes[] = 'first';
       }

       if ($item->getIsActive()) {
           $classes[] = 'active';
       }

       if ($item->getIsLast()) {
           $classes[] = 'last';
       }

       if ($item->getClass()) {
           $classes[] = $item->getClass();
       }

       if ($item->hasChildren()) {
           if ($item->getLevel() == 0){
                $classes[] = 'parent dropdown';
           }else{
                $classes[] = 'parent dropdown-submenu';
           }
       }

       return $classes;
   }

}
