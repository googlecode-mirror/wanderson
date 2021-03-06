<?php

require_once 'node.php';
require_once 'tree.php';
require_once 'psnode.php';
require_once 'pstree.php';

PSNode::setDistanceX(25);
PSNode::setDistanceY(25);

$tree = new PSTree();
$tree->insert(4)
     ->insert(2)->insert(1)->insert(3)
     ->insert(6)->insert(5)->insert(7)
     ->setTranslateX(200)->setTranslateY(200)
     ->render();