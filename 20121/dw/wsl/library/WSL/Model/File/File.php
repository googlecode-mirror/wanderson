<?php

class WSL_Model_File_File {

    public function getHash() {}
    public function getRealPath() {}
    public function save() {}
    public function delete() {}

    public function setContainer($container) {}
    public function getContainer() {}
    public function setCategory($category) {}
    public function getCategory() {}
    public function setReference($reference) {}
    public function getReference() {}
    public function setOrder($order) {}
    public function getOrder() {}

    public static function factory($params) {}
    public static function findFromReference($container, $category, $reference) {}
    public static function findFromHashes(array $hashes) {}
    public static function synchronize(array $oldfiles, array $newfiles) {}

    public static function setDefaultHandler(WSL_Model_File_InfoHandlerInterface $handler) {}
    public static function getDefaultHandler() {}

}
