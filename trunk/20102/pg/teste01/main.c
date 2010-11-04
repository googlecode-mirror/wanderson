#include <GL/glut.h>
#include <stdlib.h>
#include <stdio.h>
#include <math.h>

// Angle of Rotation
float xpos = 0;
float ypos = 0;
float zpos = 0;
float xrot = 0;
float yrot = 0;
float angle = 0;

// Positions of the Cubes
float positionz[10];
float positionx[10];

void cubepositions(void) {
    int i;
    for (i = 0; i < 10; i++) {
        positionz[i] = rand() % 5 + 5;
        positionx[i] = rand() % 5 + 5;
    }
}

// Draw Cube
void cube(void) {
    int i;
    for (i = 0; i < 10; i++) {
        glPushMatrix();
        // Translate Cube
        glTranslated(positionx[i+1] * 10, 0, positionz[i+1] * 10);
        glutSolidCube(2);
        glPopMatrix();
    }
}

void init(void) {
    cubepositions();
}

void enable(void) {
    glEnable(GL_DEPTH_TEST);
    glEnable(GL_LIGHTING);
    glEnable(GL_LIGHT0);
    glShadeModel(GL_SMOOTH);
}

void camera(void) {
    glRotatef(xrot, 1, 0, 0);
    glRotatef(yrot, 0, 1, 0);
    glTranslated(xpos, ypos, zpos);
}

void display(void) {
    glClearColor(0,0,0,1);
    glClear(GL_COLOR_BUFFER_BIT | GL_DEPTH_BUFFER_BIT);
    glLoadIdentity();
    camera();
    enable();
    cube();
    glutSwapBuffers();
    angle++;
}

void reshape(int w, int h) {
    glViewport(0, 0, w, h);
    glMatrixMode(GL_PROJECTION);
    glLoadIdentity();
    gluPerspective(60, w / h, 1, 1000);
    glMatrixMode(GL_MODELVIEW);
}

void keyboard(unsigned char key, int x, int y) {
    if (key == 'q') {
        xrot += 1;
        if (xrot > 360) xrot -= 360;
    }
    if (key == 'z') {
        xrot -= 1;
        if (xrot < -360) xrot += 360;
    }
    if (key == 'w') {
        float xrotrad, yrotrad;
        yrotrad = (yrot / 180 * 3.141592654f);
        xrotrad = (xrot / 180 * 3.141592654f);
        xpos -= (float) (sin(yrotrad));
        zpos += (float) (cos(yrotrad));
        ypos += (float) (sin(xrotrad));
    }
    if (key == 's') {
        float xrotrad, yrotrad;
        yrotrad = (yrot / 180 * 3.141592654f);
        xrotrad = (xrot / 180 * 3.141592654f);
        xpos += (float) (sin(yrotrad));
        zpos -= (float) (cos(yrotrad));
        ypos -= (float) (sin(xrotrad));
    }
    if (key == 'd') {
        yrot += 2;
        if (yrot > 360) yrot -= 360;
    }
    if (key == 'a') {
        yrot -= 2;
        if (yrot < -360) yrot += 360;
    }
    if (key == 27) {
        exit(0);
    }
}

int main(int argc, char **argv) {
    glutInit(&argc, argv);
    glutInitDisplayMode(GLUT_DOUBLE | GLUT_DEPTH);
    glutInitWindowSize(500,500);
    glutInitWindowPosition(100,100);
    glutCreateWindow("A basic OpenGL Window");
    init();
    glutDisplayFunc(display);
    glutIdleFunc(display);
    glutReshapeFunc(reshape);
    glutKeyboardFunc(keyboard);
    glutMainLoop();
    return 0;
}
