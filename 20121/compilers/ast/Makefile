# Variáveis
CC = g++
CPPFLAGS += -Wall
# Construção
all: main.o tree.o node.o operand.o operator.o
	${CC} $? -o main
# Limpeza
clean:
	rm -rf main main.o tree.o node.o operand.o operator.o
