<?php

/**
 * @Class Valibus_Landing_Helper_Data
 * @author Valib.us
 */
class Valibus_Landing_Helper_Data extends Mage_Core_Helper_Abstract{

    /**
     * @return string
     */
    private function getDisplayOrigin(){
        $type=Mage::getStoreConfig('landing/content/managementtype');
        if(0==$type)
            return "static";
        else
            return "dynamic";
    }
    /**
     * @return mixed
     */
    public function getTimeBefore(){
        $value=Mage::getStoreConfig('landing/time/before');
        if ($value>0)
            return $value;
        else
            return 10;
    }
    /**
     * @return mixed
     * @description Indicate the time before the second display
     */
    public function getRepeatDelay(){
        $value=Mage::getStoreConfig('landing/time/repeatdelay');
        if ($value>0)
            return $value;
        else
            return 15;
    }

    private function getSetupedContent($contentType="static"){
        if($contentType=='static'){
            $blockId=Mage::getStoreConfig('landing/content/cmsblock');
            if($blockId==0)
                return $this->__('Please setup any cms block to display in System/configuration/valib.us landing /content');
            else
                return Mage::getModel('cms/block')->load($blockId)->getContent();
        }
        elseif($contentType=='dynamic')
        {
            //getfacebook content
            if(Mage::getStoreConfig('landing/content/fbactivated')==1)
                $blockContent['facebook']=Mage::getStoreConfig('landing/content/fbcontent');
            //get google content
            if(Mage::getStoreConfig('landing/content/googleactivated')==1)
                $blockContent['google']=Mage::getStoreConfig('landing/content/googlecontent');
            //get twitter content
            if(Mage::getStoreConfig('landing/content/twitteractivated')==1)
                $blockContent['twitter']=Mage::getStoreConfig('landing/content/twittercontent');

            if(isset($blockContent))
                return $blockContent;
            else
                return $this->__('Please setup any social networks content to display in System/configuration/valib.us landing /content');
        }
    }
    public function getDisplayContent(){
        return $this->getSetupedContent($this->getDisplayOrigin());
    }
}