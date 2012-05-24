<?php

interface WSL_Model_File_InfoHandlerInterface {
    public function find($container, $category, $reference);
    public function load(array $files);
    public function save(WSL_Model_File_File $file);
    public function delete(WSL_Model_File_File $file);
}