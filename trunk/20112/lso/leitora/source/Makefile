KVERSION   = $(shell uname -r)
KDIRECTORY = /lib/modules/$(KVERSION)/build

obj-m = verifier.o

all:
	make -C "$(KDIRECTORY)" "M=$(PWD)" modules

clean:
	make -C "$(KDIRECTORY)" "M=$(PWD)" clean
