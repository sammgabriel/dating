<?php
/**
 * Author Name: Samantha Gabriel
 * Date: February 16, 2019
 * File Name: premiummember.php
 */

class PremiumMember extends Member {

    private $_inDoorInterests;
    private $_outDoorInterests;

    function getInDoorInterests() {

        return $this->_inDoorInterests;
    }

    function setInDoorInterests($inDoorInterests) {

        $this->_inDoorInterests = $inDoorInterests;
    }

    function getOutDoorInterests() {

        return $this->_outDoorInterests;
    }

    function setOutDoorInterests($outDoorInterests) {

        $this->_outDoorInterests = $outDoorInterests;
    }
}