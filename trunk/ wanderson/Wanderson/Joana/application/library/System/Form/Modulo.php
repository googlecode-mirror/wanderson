<?php
	class System_Form_Modulo extends System_Form {
		public function __construct($options = null) {
			parent::__construct($options);
			
			/* Elementos */
			$id = new System_Form_Element_PrimaryKey('id');
			
			$codigo = new Zend_Form_Element_Text('codigo');
			$codigo
			->setLabel('Código')
			->setAttrib('class', 'text')
			->setRequired(true)
			->addValidator(new Zend_Validate_NotEmpty(), true)
			->addValidator(new Zend_Validate_Alnum(false), true)
			->addValidator(new Zend_Validate_StringLength(1,10))
			->addFilter(new Zend_Filter_StringTrim())
			->addFilter(new Zend_Filter_StringToUpper());
			
			$nome = new Zend_Form_Element_Text('nome');
			$nome
			->setLabel('Nome do Módulo')
			->setAttrib('class', 'text')
			->setRequired(true)
			->addValidator(new Zend_Validate_NotEmpty(), true)
			->addValidator(new Zend_Validate_Alpha(true), true)
			->addValidator(new Zend_Validate_StringLength(1,40))
			->addFilter(new Zend_Filter_StringTrim());
			
			$producao = new Zend_Form_Element_Checkbox('producao');
			$producao
			->setLabel('Módulo em Produção')
			->setAttrib('class', 'checkbox')
			->addFilter(new System_Filter_Checkbox())
			->setValue(1);
			
			$venda = new Zend_Form_Element_Checkbox('venda');
			$venda
			->setLabel('Módulo Aberto para Venda')
			->setAttrib('class', 'checkbox')
			->addFilter(new System_Filter_Checkbox())
			->setValue(0);
			
			$objetivo = new System_Form_Element_Textarea('objetivo');
			$objetivo
			->setLabel('Objetivos')
			->setRequired(true)
			->addValidator(new Zend_Validate_NotEmpty());

			$requisitos = new System_Form_Element_Textarea('requisitos');
			$requisitos
			->setLabel('Requisitos')
			->setRequired(true)
			->addValidator(new Zend_Validate_NotEmpty());
			
			$publico = new System_Form_Element_Textarea('publico');
			$publico
			->setLabel('Público Alvo')
			->setRequired(true)
			->addValidator(new Zend_Validate_NotEmpty());
			
			$conteudo = new System_Form_Element_Textarea('conteudo');
			$conteudo
			->setLabel('Conteúdo da Disciplina')
			->setRequired(true)
			->addValidator(new Zend_Validate_NotEmpty());
			
			$material = new System_Form_Element_Textarea('material');
			$material
			->setLabel('Material Didático')
			->setRequired(true)
			->addValidator(new Zend_Validate_NotEmpty());
			
			$logistica = new System_Form_Element_Textarea('logistica');
			$logistica
			->setLabel('Instruções à Logística')
			->setRequired(true)
			->addValidator(new Zend_Validate_NotEmpty());
			
			$investimento = new Zend_Form_Element_Text('investimento');
			$investimento
			->setLabel('Investimento')
			->setAttrib('class', 'text')
			->setRequired(true)
			->addValidator(new Zend_Validate_NotEmpty(), true)
			->addValidator(new Zend_Validate_StringLength(1,10))
			->addValidator(new System_Validate_Currency());
			
			$carga = new Zend_Form_Element_Text('carga');
			$carga
			->setLabel('Carga Horária')
			->setAttrib('class', 'text')
			->setRequired(true)
			->addValidator(new Zend_Validate_NotEmpty(), true)
			->addValidator(new Zend_Validate_Digits(), true)
			->addValidator(new Zend_Validate_Int())
			->addFilter(new Zend_Filter_Digits())
			->addFilter(new Zend_Filter_Int());
			
			$minimo = new Zend_Form_Element_Text('minimo');
			$minimo
			->setLabel('Número Mínimo de Alunos')
			->setAttrib('class', 'text')
			->setRequired(true)
			->addValidator(new Zend_Validate_NotEmpty(), true)
			->addValidator(new Zend_Validate_Digits(), true)
			->addValidator(new Zend_Validate_Int(), true)
			->addFilter(new Zend_Filter_Digits())
			->addFilter(new Zend_Filter_Int());
			
			$maximo = new Zend_Form_Element_Text('maximo');
			$maximo
			->setLabel('Número Máximo de Alunos')
			->setAttrib('class', 'text')
			->setRequired(true)
			->addValidator(new Zend_Validate_NotEmpty(), true)
			->addValidator(new Zend_Validate_Digits(), true)
			->addValidator(new Zend_Validate_Int(), true)
			->addFilter(new Zend_Filter_Digits())
			->addFilter(new Zend_Filter_Int());
			
			$submit = new Zend_Form_Element_Submit('submit');
			$submit
			->setLabel('Gravar')
			->setAttrib('class', 'button');
			
			/* Adicionar Elementos */
			$elements = array(
				$id,
				$codigo,
				$nome,
				$producao,
				$venda,
				$objetivo,
				$requisitos,
				$publico,
				$conteudo,
				$material,
				$logistica,
				$investimento,
				$carga,
				$minimo,
				$maximo,
				$submit
			);
			$this->addElements($elements);
		}
	}
