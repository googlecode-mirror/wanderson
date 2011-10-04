#!/bin/bash

# Downloader
# Hashbang: Bash > Interpretador de Comandos

# Programa para Execução dos Downloads
DOWNLOADER="wget" # Nome do Programa
DL_OPTIONS="-c"   # Continuar Download Pausado
FAILURE=15        # Resultado de Término com Falha
SUCCESS=0         # Código de Sucesso
TIMEOUT=no        # Timeout (String ou Inteiro)

# Impressão de Informações
# print_info n_success n_failure
function print_info() {
    echo "Programa de download utilizado: $DOWNLOADER $DL_OPTIONS"
    # Bloco Condicional: Comparação entre Strings
    if test $TIMEOUT != "no"; then
        # Entra caso TIMEOUT é Inteiro
        echo "Timeout de execucao: $TIMEOUT"
    fi
    echo "Numero total de downloads executados: $(($1+$2))"
    echo "Numero de downloads executados com sucesso: $1"
    return $SUCCESS
}

# Execução de Comando de Downloader sem TIMEOUT
# exec_cmd1 timeout url
function exec_dl1() {
    # t=$1; shift # Remoção de Linha Desnecessária
    # Modificações: Somente um Elemento é Necessário
    $DOWNLOADER $DL_OPTIONS $2 # Execução do Downloader
    return $? # Resultado do Término do Último Comando Executado
}

# Execução de Comando de Downloader com TIMEOUT
# exec_cmd2 timeout cmd params
function exec_dl2() {
    t=$1; shift # Deslocamento de 1 Parâmetros Informado à Esquerda
    # Execução do Downloader em Background
    # Modificações: Somente um Elemento é Necessário
    $DOWNLOADER $DL_OPTIONS $1 & # Envio para Background da Execução
    # Capturar o PID e Esperar o Tempo Solicitado
    # Conectar a Saída de Erro na Saída Padrão
    # Terminar o Processo de Forma "Elegante"
    # Escritor Especial e Descartável
    pid=$!; sleep $t; kill -KILL $pid 2>/dev/null; # Saída de Erro para Vazio
    # Esperar o PID e Conectar a Saída de Erro na Saída Padrão
    wait $pid 2>/dev/null # Enviar Saída de Erro para "Nada"
    return $? # Resultado do Término do Último Comando Executado
}

# Verifica a Quantidade de Parâmetros Informados
if test $# -lt 1; then # Nenhum Parâmetro Informado
    # Apresentação de Erros
    echo "$0: Parametros insuficientes"
    echo "Uso: $0 [ -t timeout ] urls..."
    # Resultado do Término
    exit $FAILURE # Falha de Execução
fi

# Verifica Segundo Parâmetro: Tempo de Espera
if [ "$1" == "-t" ]; then # Parâmetro Informado
    # Utilização de TIMEOUT Informado
    TIMEOUT=$2; shift 2 # Deslocamento de Duas Posições à Esquerda
fi

# Número de Downloads com Sucesso: ns
# Número de Downloads com Falha:   nf
ns=0; nf=0;
while true; do # Laço de Repetição Infinito
    # Existem Downloads para Execução?
    # Capturar o Primeiro Parâmetro como URL
    # Deslocar 1 Parâmetro à Esquerda
    if [ $# == 0 ]; then break; else URL=$1; shift; fi
    # Bloco Condicional
    case $TIMEOUT in # Verificar Tipo de TIMEOUT
        # TIMEOUT 'no' Descartável na Função
        no) EXEC_DL="exec_dl1 $TIMEOUT";;
        *)  EXEC_DL="exec_dl2 $TIMEOUT"
    esac
    $EXEC_DL $URL
    if test $? -eq 0; then ns=$((ns+1)); else nf=$((nf+1)); fi
done

shift # TODO Execução de shift Necessário?
print_info $ns $nf # Apresentação de Resultados

