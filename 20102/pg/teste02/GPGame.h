#ifndef GPGame_h
#define GPGame_h

class GPCamera;

class GPGame
{
    private:
    static GPGame* instance;
    static int WIDTH;
    static int HEIGHT;
    static const char* NAME;
    GPCamera* camera;
    GPGame();
    GPGame* init(int*,char**);
    public:
    static void display(void);
    static void reshape(int,int);
    static void keyboard(unsigned char,int,int);
    static GPGame* getInstance(void);
    void run(int*,char**);
    GPCamera* getCamera(void);
};

#endif
