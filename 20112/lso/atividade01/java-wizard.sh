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

# Verificar Arquivo Existente
if [ ! -f "$1.java" ]; then # Não é um Arquivo
    echo "
public class $1 {
    public static void main(String args[]) {
        // Main Code Here
    }
}
" > "$1.java" # Redirecionamento de Saída Padrão para Arquivo
fi

# Retorno Esperado
exit 0 # Sucesso
