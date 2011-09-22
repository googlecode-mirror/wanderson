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

# Laço de Repetição
# Chamada do Editor
# Chamada do Compilador Java
# Redirecionamento de Erros para Arquivo
until vim "$1.java" && javac "$1.java" 2> errors.log ; do
    # Estado de Terminação com Falha (Diferente de Zero)
    # Espera Usuário Sair do Paginador
    cat errors.log | head -n 1 | less # Exibição da Primeira Linha de Erro
done

# Remover Arquivo de Log
rm -f errors.log

# Retorno Esperado
exit 0 # Sucesso
