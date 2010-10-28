#include <GL/glut.h>

#define GP_WINDOW_WIDTH  640
#define GP_WINDOW_HEIGHT 480
#define GP_APPLICATION_NAME "Graphics Processing"

void gpInit(void);
void gpDisplay(void);
void gpReshape(int,int);
void gpKeyboard(unsigned char,int,int);

double eye_x = 0;
double eye_y = 0;
double eye_z = 2;

double ref_x = 0;
double ref_y = 0;
double ref_z = 0;

double ups_x = 0;
double ups_y = 1;
double ups_z = 0;

int main(int argc, char *argv[])
{
    glutInit(&argc, argv);
    glutInitDisplayMode(GLUT_SINGLE | GLUT_RGBA);
    glutInitWindowSize(GP_WINDOW_WIDTH, GP_WINDOW_HEIGHT);

    int window_x = (glutGet(GLUT_SCREEN_WIDTH) - GP_WINDOW_WIDTH)/2;
    int window_y = (glutGet(GLUT_SCREEN_HEIGHT) - GP_WINDOW_HEIGHT)/2;
    glutInitWindowPosition(window_x, window_y);

    glutCreateWindow(GP_APPLICATION_NAME);

    glutDisplayFunc(gpDisplay);
    glutReshapeFunc(gpReshape);
    glutKeyboardFunc(gpKeyboard);

    gpInit();

    glutMainLoop();

    return 0;
}

void gpInit(void)
{
    glClearColor(0.0, 0.0, 0.0, 0.0);
    glShadeModel(GL_FLAT);
}

void gpDisplay(void)
{
    glClear(GL_COLOR_BUFFER_BIT);
    glColor3f(1.0, 1.0, 1.0);
    glLoadIdentity();
    gluLookAt(eye_x, eye_y, eye_z, ref_x, ref_y, ref_z, ups_x, ups_y, ups_z);
    glutWireCube(1);
    glFlush();
}

void gpReshape(int width, int height)
{
    glViewport(0, 0, width, height);
    glMatrixMode(GL_PROJECTION);
    glLoadIdentity();
    gluPerspective(60, width / (height * 1.0), 1, 100);
    glMatrixMode(GL_MODELVIEW);
}

void gpKeyboard(unsigned char key, int x, int y)
{
    switch (key) {
        case 'w':
            eye_z = eye_z + 0.1;
            break;
        case 's':
            eye_z = eye_z - 0.1;
            break;
    }
    gpDisplay();
}
