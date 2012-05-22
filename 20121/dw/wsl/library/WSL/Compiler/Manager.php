<?php

class WSL_Compiler_Manager {
	public function __construct(WSL_Compiler_Context $context) {}
	public function setBeforePlugin(WSL_Compiler_PluginBeforeInterface $plugin) {}
	public function setAfterPlugin(WSL_Compiler_PluginAfterInterface $plugin) {}
	public function execute($name) {}
	public function compile() {}
	public function getContext() {}
}
