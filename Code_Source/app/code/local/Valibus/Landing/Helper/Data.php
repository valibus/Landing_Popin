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
     * @return int
     * @description return in second the number of days before 2nd display
     */
    public function getRepeatDelay(){
        $value=Mage::getStoreConfig('landing/time/repeatdelay');
        if ($value>0)
            $timeRepeat=$value;
        else
            $timeRepeat=15;
        //convert delay in second
        return $timeRepeat*24*60*60;
    }

    /**
     * @param $timeFirst
     * @return bool
     * @description check if popin can be showed again
     */
    public function getShowAgain($timeFirst){
        $diff=time()-$timeFirst;
        if($diff>$this->getRepeatDelay())
            return true;
        else {
            return false;
        }
    }

    /**
     * @param $timeFirst
     * @param $status
     * @return bool
     * @description check if popin can be showed for the first time (if it as not be shown before and if the minimum delay is ok
     */
    public function getShowFirst($timeFirst,$status){
        $diff=time()-$timeFirst;
        if($diff>$this->getTimeBefore() && $status==0){
            return true;
        }else {
            return false;
        }
    }

    private function getSetupedContent($contentType="static"){
        if($contentType=='static'){
            $blockId=Mage::getStoreConfig('landing/content/cmsblock');
            //test if a block is set in static display
            if($blockId==0)
                $blockContent['error']=$this->__('Please setup any cms block to display in System/configuration/valib.us landing /content');
            else
                $blockContent['Static']=Mage::getModel('cms/block')->load($blockId)->getContent();
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

            //test if a content is set in social configuration
            if(!isset($blockContent))
                $blockContent['error']=$this->__('Please setup any social networks content to display in System/configuration/valib.us landing /content');
        }
        return $blockContent;
    }
    public function getDisplayContent(){
        return $this->getSetupedContent($this->getDisplayOrigin());
    }
}