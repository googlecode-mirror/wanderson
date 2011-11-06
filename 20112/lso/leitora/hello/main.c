#include <linux/init.h>
#include <linux/module.h>
MODULE_LICENSE("Dual BSD/GPL");

int hello_init(void)
{
    printk(KERN_ALERT "Hello, World\n");
    return 0;
}

void hello_exit(void)
{
    printk(KERN_ALERT "Goodbye, Cruel World\n");
}

module_init(hello_init);
module_exit(hello_exit);
