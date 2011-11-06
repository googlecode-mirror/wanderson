KVERSION   = $(shell uname -r)
KDIRECTORY = /lib/modules/$(KVERSION)/build

obj-m = main.o

all:
	make -C "$(KDIRECTORY)" "M=$(PWD)" modules

clean:
	make -C "$(KDIRECTORY)" "M=$(PWD)" clean
