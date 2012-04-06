# Variáveis
CFLAGS = -Wall
CC     = g++ ${CFLAGS}

# Diretivas

all: main.o node.o operand.o
	${CC} $? -o main

node.o:
	${CC} -c node.cpp

operand.o:
	${CC} -c operand.cpp

main.o:
	${CC} -c main.cpp

clean:
	rm -rf main main.o node.o operand.o
