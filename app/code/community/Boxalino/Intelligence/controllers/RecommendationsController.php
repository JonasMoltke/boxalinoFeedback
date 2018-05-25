<?php

class Boxalino_Intelligence_RecommendationsController extends Mage_Core_Controller_Front_Action
{

    public function indexAction(){

      $this->loadLayout();
      $block = $this->getLayout()->createBlock('Boxalino_Intelligence_Block_Product_List_Parametrized');
      $format = $block->getFormat();

      //No reason for echo - if necessary use renderLayout
      if ($format == 'json') {
          $this->getLayout()->createBlock('Boxalino_Intelligence_Block_Product_List_Parametrized')->setTemplate('boxalino\recommendation_json.phtml')->toHtml();
      }
      if ($format == 'html') {
          $this->getLayout()->createBlock('Boxalino_Intelligence_Block_Product_List_Parametrized')->setTemplate('boxalino\recommendation.phtml')->toHtml();
      }

    }

}
