#ifndef GPCamera_h
#define GPCamera_h

class GPCamera
{
    int rot_x;
    double csin;
    double ccos;
    double pos_x;
    double pos_y;
    double pos_z;
    double step;
    double getSin(void);
    double getCos(void);
    public:
    static double PI;
    GPCamera(void);
    GPCamera* setRotationX(int);
    GPCamera* setPositionX(double);
    GPCamera* setPositionY(double);
    GPCamera* setPositionZ(double);
    GPCamera* setStep(double);
    int getRotationX(void);
    double getPositionX(void);
    double getPositionY(void);
    double getPositionZ(void);
    double getStep(void);
    GPCamera* place(void);
    GPCamera* toRight(int);
    GPCamera* toLeft(int);
};

#endif
