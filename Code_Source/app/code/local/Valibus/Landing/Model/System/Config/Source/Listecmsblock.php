<?php
/*
 * @author: valib.us
 * @content: prepare model for option array in system config
 */
class Valibus_Landing_Model_System_Config_Source_Listecmsblock {
    /**
     * Options getter
     *
     * @return array
     */
    public function toOptionArray()
    {
        $blocks = Mage::getModel('cms/block')
            ->getCollection()
            ->addFieldToFilter('is_active', 1);
        $arrayOut= array(array('value' => '0', 'label'=>'None'));
        foreach($blocks as $block)
        {
            array_push($arrayOut, array('value' => $block->block_id, 'label'=>$block->title));
        }
        return $arrayOut;
    }
}