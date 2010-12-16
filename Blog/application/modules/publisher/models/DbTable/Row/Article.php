<?php

/**
 * Linha da Tabela de Artigos
 * 
 * @author Wanderson Henrique Camargo Rosa
 * @category Publisher
 * @package Publisher_Model
 * @subpackage DbTable
 */
class Publisher_Model_DbTable_Row_Article extends Zend_Db_Table_Row_Abstract
{
    public function save()
    {
        /*
         * Data de Atualização
         */
        $date = new Zend_Date();
        $this->updated = $date->get(Zend_Date::ISO_8601);
        /*
         * Autor como Usuário Atual
         * Cadastra somente se o artigo não possuir um autor já relacionado
         */
        if (empty($this->idauthor)) {
            $auth = Zend_Auth::getInstance();
            if ($auth->hasIdentity()) {
                $this->idauthor = $auth->getStorage()->read()->iduser;
            }
        }
        return parent::save();
    }

    public function findParentRow($parentTable, $ruleKey = null, Zend_Db_Table_Select $select = null)
    {
        if (is_string($parentTable)) {
            $table  = $this->_getTable();
            $mapper = $table->info(Zend_Db_Table::REFERENCE_MAP);
            if (array_key_exists($parentTable, $mapper)) {
                $parentTable = $mapper[$parentTable]['refTableClass'];
            }
        }
        return parent::findParentRow($parentTable, $ruleKey, $select);
    }

    /**
     * Configuração do Elemento conforme Formulário
     * 
     * @param Publisher_Form_Article $form Formulário
     */
    public function setFromForm(Publisher_Form_Article $form)
    {
        $this->setFromArray($form->getValues());
        return $this;
    }

    /**
     * Publicação de Artigo
     * @return Publisher_Model_DbTable_Row_Article Próprio Objeto
     */
    public function publish()
    {
        $this->published = 1;
        $this->save();
        return $this;
    }

    /**
     * Marca o Artigo como Não Publicado
     * @return Publisher_Model_DbTable_Row_Article Próprio Objeto
     */
    public function unpublish()
    {
        $this->published = 0;
        $this->save();
        return $this;
    }
}