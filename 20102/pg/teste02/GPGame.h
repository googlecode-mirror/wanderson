class GPGame
{
    private:
    static GPGame *instance;
    static int WIDTH;
    static int HEIGHT;
    static const char *NAME;
    GPGame();
    public:
    static void display(void);
    static void reshape(int,int);
    static GPGame* getInstance(void);
    void run(void);
};
