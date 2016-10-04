<?php

class Boxalino_Intelligence_Block_Script extends Mage_Core_Block_Template
{

    public function setTemplate($template)
    {
        if(!Mage::helper('intelligence')->isPluginEnabled()){
            return $this;
        }
        return parent::setTemplate($template); // TODO: Change the autogenerated stub
    }

    public function getScripts()
    {
        $html = '';
        $session = Mage::getSingleton('Boxalino_Intelligence_Model_Session');
        $scripts = $session->getScripts(false);

        foreach ($scripts as $script) {
            $html .= $script;
        }
        $session->clearScripts();

        return $html;
    }

    public function isSearch()
    {
        $current = $this->getRequest()->getRouteName() . '/' . $this->getRequest()->getControllerName();
        return $current == 'catalogsearch/result';
    }
}