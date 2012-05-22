<?php

class WSL_Compiler_Plugin_Dvi implements WSL_Compiler_PluginAfterInterface {
	public function afterAction(WSL_Compiler_Manager $manager) {
		$context = $manager->getContext();
		if (!$context->hasElement('document.dvi')) {
			throw new WSL_Compiler_PluginException("Where's 'document.dvi'?");
		}
	}
}
