package br.nom.camargo.wanderson.btserver;

import java.awt.AWTException;
import java.awt.Robot;
import java.awt.event.KeyEvent;
import java.io.IOException;
import java.io.InputStream;

import javax.microedition.io.Connector;
import javax.microedition.io.StreamConnection;
import javax.microedition.io.StreamConnectionNotifier;

/**
 * Serviço de Impressão para Saída Padrão
 * Recebe Informações por Bluetooth e Coloca os Valores na Saída Padrão
 * @author Wanderson Henrique Camargo Rosa
 */
public class SystemOutServer implements Runnable
{
    /**
     * Identificador Único de Conexão
     */
    private final String UUID = "879c3537-ae66-4013-a677-9b7e5339d13c";

    /**
     * Notificador de Conexão
     * Trabalha como um Servidor de Sockets
     */
    private StreamConnectionNotifier notifier;

    /**
     * Fluxo de Execução Concorrente para Transferência
     */
    private SystemOutConnection connection;

    /**
     * Simulador de Teclado
     */
    private Robot robot;

    /**
     * Construtor Padrão
     * @throws SystemOutServerException Impossível Construir Servidor
     */
    public SystemOutServer() throws SystemOutServerException
    {
        try {
            /* Endereço para Conexão */
            String address = "btspp://localhost:" + getUUID() + ";name=Android Presenter";
            output("V: Abertura de Servidor de Conexão");
            notifier = (StreamConnectionNotifier) Connector.open(address);
            output("V: Servidor de Conexão Aberto");
            /* Fluxo Concorrente para Transferência */
            connection = new SystemOutConnection();
            /* Inicialização do Simulador */
            robot = new Robot();
        } catch (IOException e) {
            /* Erro ao Abrir o Serviço */
            output("W: Erro ao Abrir o Serviço");
            output("W: Mensagem > " + e.getMessage());
            throw new SystemOutServerException(e);
        } catch (AWTException e) {
            output("W: Erro ao Inicializar o Simulador de Mouse");
            output("W: Mensagem > " + e.getMessage());
            throw new SystemOutServerException(e);
        }
    }

    /**
     * Padroniza o Identificador Único para Utilização na API
     * @return Valor Solicitado
     */
    public String getUUID()
    {
        /* Formato javax.bluetooth sem Separação */
        output("V: Transformação de Identificador Único");
        return UUID.replace("-", "");
    }

    /**
     * Envio dos Dados para a Saída Padrão
     * @param message Mensagem para Envio
     */
    public void output(String message)
    {
        System.out.println(message);
    }

    /**
     * Execução Principal do Servidor
     */
    public void run()
    {
        /* Execução Secundária de Transferência */
        output("V: Iniciando Fluxo para Conexão");
        connection.run();
    }

    /**
     * Fluxo Concorrente para Transferência de Informações
     * @author Wanderson Henrique Camargo Rosa
     */
    private class SystemOutConnection extends Thread
    {
        /**
         * Execução do Fluxo Concorrente
         */
        public void run()
        {
            try {
                /* Servidor de Socket Bloqueante */
                output("V: Esperando Conexão Externa");
                StreamConnection stream = notifier.acceptAndOpen();
                output("V: Conexão Aceita");
                /* Fecha o Servidor de Socket */
                output("V: Fechando Servidor de Conexões");
                notifier.close();
                output("V: Servidor de Conexões Fechado");

                output("V: Abrindo Fluxo de Entrada de Dados");
                InputStream in = stream.openInputStream();
                output("V: Fluxo de Entrada de Dados Aberto");
                output("V: Conexão Estabelecida");

                int size = 0; byte buffer[]; String message;
                output("V: Inicializando Laço Infinito");
                while (true && size >= 0) {
                    /* Leitura Bloqueante */
                    output("V: Esperando Quantidade de Bytes para Recebimento");
                    size = in.read();
                    if (size > 0) {
                        output("V: Tamanho para Recebimento > " + size);
                        buffer = new byte[size];
                        /* Leitura Bloqueante */
                        output("V: Esperando Buffer");
                        in.read(buffer);
                        output("V: Buffer Enviado");
                        message = new String(buffer);
                        output("V: Resultado > " + message);
                        output("V: Simulando Teclado conforme Mensagem");
                        if (message.equals("LEFT")) {
                            robot.keyPress(KeyEvent.VK_LEFT);
                            robot.keyRelease(KeyEvent.VK_LEFT);
                            output("V: Simulação para Esquerda");
                        } else if (message.equals("RIGHT")) {
                            robot.keyPress(KeyEvent.VK_RIGHT);
                            robot.keyRelease(KeyEvent.VK_RIGHT);
                            output("V: Simulação para Direita");
                        } else {
                            output("V: Mensagem Desconhecida");
                        }
                        output("V: Simulação Concluída");
                    } else {
                        output("W: Quantidade de Bytes Inválida > " + size);
                    }
                }
            } catch (IOException e) {
                output("W: Problema com a Conexão");
                output("W: Mensagem > " + e.getMessage());
            }
        }
    }
}
