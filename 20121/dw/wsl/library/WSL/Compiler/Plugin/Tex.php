<?php

class WSL_Compiler_Plugin_Tex implements WSL_Compiler_PluginBeforeInterface {
	public function beforeAction(WSL_Compiler_Manager $manager) {
		$context = $manager->getContext();
		if (!$context->has('document.tex')) {
			throw new WSL_Compiler_PluginException("Where's 'document.tex'?");
		}
	}
}
