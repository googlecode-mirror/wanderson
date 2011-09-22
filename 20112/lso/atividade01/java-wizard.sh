#!/bin/bash
# Java Wizard
# @author Wanderson Henrique Camargo Rosa

# Verificação de Parâmetro
if [ -z "$1" ]; then # Bloco Condicional
    echo "Erro: Nome de Classe Necessário" # Mensagem Informativa de Erro
    exit 1 # Estado de Finalização com Falha (Diferente de Zero)
fi

# Nome da Classe
echo "$1" # Saída Padrão

# Retorno Esperado
exit 0 # Sucesso
