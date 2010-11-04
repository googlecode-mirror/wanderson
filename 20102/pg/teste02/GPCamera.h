#ifndef GPCamera_h
#define GPCamera_h

class GPCamera
{
    int rot_x;
    int pos_x;
    int pos_y;
    int pos_z;
    int step;
    public:
    GPCamera(void);
    GPCamera* setRotationX(int);
    GPCamera* setPositionX(int);
    GPCamera* setPositionY(int);
    GPCamera* setPositionZ(int);
    GPCamera* setStep(int);
    int getRotationX(void);
    int getPositionX(void);
    int getPositionY(void);
    int getPositionZ(void);
    int getStep(void);
    GPCamera* place(void);
};

#endif
