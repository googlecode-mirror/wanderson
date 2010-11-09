/*
 * Object.h
 * Estrutura da Classe Object de Jogo
 * @author: Wanderson Henrique Camargo Rosa
 */

#ifndef OBJECT_H_
#define OBJECT_H_

class Object
{
private:
    double position_x;
    double position_y;
    double position_z;
public:
    Object(void);
    virtual ~Object(void);

    Object* setPositionX(double);
    Object* setPositionY(double);
    Object* setPositionZ(double);

    double getPositionX(void);
    double getPositionY(void);
    double getPositionZ(void);

    virtual Object* draw(void)=0;
};

#endif
