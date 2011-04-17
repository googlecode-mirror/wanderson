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
 * Interpretador de Comandos do Apresentador de Slides
 * 
 * Trabalha como um tradutor do conteúdo enviado pelo serviço de mensagens. As
 * informações utilizam a Javascript Objeto Notation (JSON) para declarar os
 * comandos que devem ser executados sobre a máquina local.
 * 
 * @author Wanderson Henrique Camargo Rosa
 */
public class PresenterRemote extends Observable implements RemoteControl
{
    /**
     * Simulador de Execução
     */
    private Robot robot;

    public PresenterRemote exec(RemoteServer server, byte content[])
        throws RemoteException
    {
        Logger l = Logger.getLogger("Hermes_RemoteLogger");
        String message = new String(content);
        l.info("Control Presenter Mensagem Recebida: " + message);
        try {
            if (message.equals("LEFT")) {
                l.info("Control Presenter Navegação para Esquerda");
                getRobot().keyPress(KeyEvent.VK_LEFT);
                getRobot().keyRelease(KeyEvent.VK_LEFT);
            } else if (message.equals("RIGHT")) {
                l.info("Control Presenter Navegação para Direita");
                getRobot().keyPress(KeyEvent.VK_RIGHT);
                getRobot().keyRelease(KeyEvent.VK_RIGHT);
            } else {
                l.warning("Control Presenter Comando de Navegação Inválido");
                throw new RemoteException("Invalid Command");
            }
        } finally {
            l.info("Control Presenter Notificando Observadores");
            notifyObservers();
        }
        return this;
    }

    /**
     * Informação do Simulador de Execução
     * @return Elemento de Informação
     * @throws RemoteException Problemas na Criação do Simulador
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
}
