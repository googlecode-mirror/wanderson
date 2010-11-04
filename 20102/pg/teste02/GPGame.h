#include <GL/glut.h>

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

GPGame* GPGame::instance = NULL;

int GPGame::WIDTH  = 640;
int GPGame::HEIGHT = 480;
const char* GPGame::NAME = "Graphis Processing";

GPGame::GPGame()
{
    glutInitDisplayMode(GLUT_SINGLE);
    glutInitWindowSize(WIDTH,HEIGHT);
    int x = (glutGet(GLUT_SCREEN_WIDTH) - WIDTH)/2;
    int y = (glutGet(GLUT_SCREEN_HEIGHT) - HEIGHT)/2;
    glutInitWindowPosition(x,y);
    glutCreateWindow(NAME);
    glutDisplayFunc(display);
    glutReshapeFunc(reshape);
}

void GPGame::display(void)
{
    glClear(GL_COLOR_BUFFER_BIT);
    glFlush();
}

void GPGame::reshape(int width, int height)
{
    glViewport(0, 0, width, height);
    glMatrixMode(GL_PROJECTION);
    glLoadIdentity();
    gluPerspective(120, width / (height * 1.0), 1, 100);
    glMatrixMode(GL_MODELVIEW);
}

GPGame* GPGame::getInstance()
{
    if (instance == NULL) {
        instance = new GPGame();
    }
    return instance;
}

void GPGame::run(void)
{
    glutMainLoop();
}
