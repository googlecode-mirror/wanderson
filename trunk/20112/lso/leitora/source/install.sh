#!/bin/bash

# Instalação de Dispositivos
# Driver para Verificadora de CPF e CNPJ
# @author Wanderson Henrique Camargo Rosa

# Informações
USERID=$(id -u)
DRIVER_NAME="verifier"
DEVICE_NAME="verifier"

# Mensagens de Erro
function verifier_error() {
    echo ERROR: $1
    if [ ! -z $2 ]; then
        exit $2
    fi
}

# Verificar Usuário Raiz
if [ $USERID -ne 0 ]; then
    verifier_error "Necessário Usuário Raiz" 1
fi

# Instalar Módulo
insmod "$DRIVER_NAME.ko"
if [ $? -ne 0 ]; then
    verifier_error "Impossível Instalar Módulo" 2
fi

# Capturar Número Maior do Dispositivo
MAJOR=$(grep "$DRIVER_NAME" /proc/devices | cut -d' ' -f1)
if [ -z $MAJOR ]; then
    verifier_error "Impossível Encontrar Número Maior" 3
fi

# Remover Dispositivo
rm -f "/dev/$DEVICE_NAME"
# Adicionar Dispositivo de Caractere
mknod "/dev/$DEVICE_NAME" c "$MAJOR" 0
# Modificar Permissões
chmod 666 "/dev/$DEVICE_NAME"

exit 0 # Sucesso de Execução

