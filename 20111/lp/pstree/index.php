<?php

require_once 'node.php';
require_once 'tree.php';
require_once 'psnode.php';
require_once 'pstree.php';

$tree = new PSTree();
$tree->insert(10)->insert(9)->insert(12)->insert(11);

PSNode::setDistanceX(1);
PSNode::setDistanceY(1);

$tree->render();