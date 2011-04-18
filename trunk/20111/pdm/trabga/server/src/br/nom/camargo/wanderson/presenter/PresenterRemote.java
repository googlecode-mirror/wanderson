package br.nom.camargo.wanderson.presenter;

import java.awt.AWTException;
import java.awt.Robot;
import java.awt.event.KeyEvent;
import java.util.Observable;
import java.util.logging.Logger;

import br.nom.camargo.wanderson.hermes.RemoteControl;
import br.nom.camargo.wanderson.hermes.RemoteException;
import br.nom.camargo.wanderson.hermes.RemoteServer;

/**
 * Controle de Apresentação
 * 
 * Interpretador dos comandos enviados pelo servidor de mensagens. Executa
 * tarefas sobre o computador local utilizando um simulador de usuário
 * disponível no Java.
 * 
 * @author Wanderson Henrique Camargo Rosa
 */
public class PresenterRemote extends Observable implements RemoteControl
{
    /**
     * Simulador de Usuário
     */
    private static Robot robot = null;

    /**
     * Último Comando Executado pelo Interpretador
     */
    private PresenterCommand last = null;

    /**
     * Informação do Último Comando Executado
     * @return Elemento de Informação
     */
    public PresenterCommand getLastCommand()
    {
        return last;
    }

    public PresenterRemote exec(RemoteServer server, byte buffer[])
        throws RemoteException
    {
        Logger l = Logger.getLogger("Hermes_RemoteLogger");
        l.info("Control Presenter Execução do Interpretador");
        String message = new String(buffer);
        try {
            last = PresenterCommand.valueOf(message);
        } catch (IllegalArgumentException e) {
            last = PresenterCommand.NONE;
        }
        try {
            switch (last) {
            case LEFT:
                l.info("Control Presenter Movimentação para Esquerda");
                getRobot().keyPress(KeyEvent.VK_LEFT);
                getRobot().keyRelease(KeyEvent.VK_LEFT);
                setChanged();
                break;
            case RIGHT:
                l.info("Control Presenter Movimentação para Direita");
                getRobot().keyPress(KeyEvent.VK_RIGHT);
                getRobot().keyRelease(KeyEvent.VK_RIGHT);
                setChanged();
                break;
            default:
                l.warning("Control Presenter Comando Desconhecido");
                throw new RemoteException("Invalid Command");
            }
        } finally {
            l.info("Control Presenter Finalização de Execução do Controle");
            notifyObservers();
        }
        return this;
    }

    /**
     * Captura do Simulador de Usuário
     * @return Objeto Solicitado
     * @throws RemoteException Impossível Criar um Simulador
     */
    protected Robot getRobot() throws RemoteException
    {
        if (robot == null) {
            try {
                robot = new Robot();
            } catch (AWTException e) {
                throw new RemoteException(e);
            }
        }
        return robot;
    }

    /**
     * Comandos Disponíveis
     * 
     * @author Wanderson Henrique Camargo Rosa
     */
    public enum PresenterCommand
    {
        LEFT, RIGHT, NONE;
    }
}
