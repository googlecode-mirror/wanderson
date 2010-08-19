#include <GL/gl.h>
#include <GL/glu.h>
#include <GL/glut.h>
#include <math.h>

#define PI 3.1415926535898

void display(void)
{
    glClear(GL_COLOR_BUFFER_BIT);
    glLineWidth(1);
    glColor3f(1,0,0);

    // Polígono
    glBegin(GL_POLYGON);
        glVertex2f(10,10);
        glVertex2f(100,100);
        glVertex2f(120,80);
        glVertex2f(100,10);
    glEnd();

    // Circunferência
    glBegin(GL_LINE_LOOP);
    {
        int points = 100;
        float angle, radius = 50;
        int x = 100;
        int y = 200;
        int i;
        for (i = 0; i < points; i++) {
            angle = 2 * PI * i / points;
            glVertex2f(cos(angle) * radius + x, sin(angle) * radius + y);
        }
    }
    glEnd();

    // Círculo
    glBegin(GL_TRIANGLE_FAN);
    {
        int points = 100;
        float angle, radius = 50;
        int x = 100;
        int y = 300;
        int i;
        for (i = 0; i < points; i++) {
            angle = 2 * PI * i / points;
            glVertex2f(cos(angle) * radius + x, sin(angle) * radius + y);
        }
    }
    glEnd();

    // Elipse
    glBegin(GL_LINE_LOOP);
    {
        int points = 100;
        float angle, xradius = 100, yradius = 50;
        int x = 100;
        int y = 400;
        int i;
        for (i = 0; i < points; i++) {
            angle = 2 * PI * i / points;
            glVertex2f(cos(angle) * xradius + x, sin(angle) * yradius + y);
        }
    }
    glEnd();

    // Arco
    glBegin(GL_LINE_STRIP);
    {
        int points = 100;
        float angle, radius = 50;
        float arc = 180.0;
        int x = 250;
        int y = 200;
        int i;
        for (i = 0; i < points; i++) {
            angle = 2 * PI * (arc / 360.0) * i / points;
            glVertex2f(cos(angle) * radius + x, sin(angle) * radius + y);
        }
    }
    glEnd();

    // Pizza
    glBegin(GL_LINE_LOOP);
    {
        int points = 100;
        float angle, radius = 50;
        float arc = 75.0;
        int x = 250;
        int y = 300;
        int i;
        glVertex2f(x,y);
        for (i = 0; i < points; i++) {
            angle = 2 * PI * (arc / 360.0) * i / points;
            glVertex2f(cos(angle) * radius + x, sin(angle) * radius + y);
        }
    }
    glEnd();

    // Arco Preenchido
    glBegin(GL_TRIANGLE_FAN);
    {
        int points = 100;
        float angle, radius = 50;
        float arc = 75.0;
        int x = 250;
        int y = 400;
        int i;
        glVertex2f(x,y);
        for (i = 0; i < points; i++) {
            angle = 2 * PI * (arc / 360.0) * i / points;
            glVertex2f(cos(angle) * radius + x, sin(angle) * radius + y);
        }
    }
    glEnd();

    glFlush();
}

void reshape(int width, int height)
{
    if (height == 0) height = 1;
    glViewport(0, 0, width, height);
    glMatrixMode(GL_PROJECTION);
    glLoadIdentity();
    gluOrtho2D(0, width, 0,height);

    glMatrixMode(GL_MODELVIEW);
    glLoadIdentity();
}

int main(int argc, char** argv)
{
    glutInit(&argc, argv);
    glutInitDisplayMode(GLUT_SINGLE | GLUT_RGBA);
    glutInitWindowSize(500,500);
    glutCreateWindow("Wanderson");

    glutDisplayFunc(display);
    glutReshapeFunc(reshape);

    glutMainLoop();

    return 0;
}
