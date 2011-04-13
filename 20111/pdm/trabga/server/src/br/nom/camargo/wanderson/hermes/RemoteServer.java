package br.nom.camargo.wanderson.hermes;

import br.nom.camargo.wanderson.hermes.adapter.ConnectionAdapter;

/**
 * Servidor de Mensagens
 * 
 * Serviço para transferência de mensagens entre o dispositivo móvel e a máquina
 * local. Trabalha utilizando adaptadores que executam a lógica especializada da
 * comunicação. Informa objeto específico das informações transferidas. Pode
 * trabalhar como um objeto executável.
 * 
 * @author Wanderson Henrique Camargo Rosa
 */
public class RemoteServer implements Runnable
{
    /**
     * Adaptador da Conexão
     */
    private ConnectionAdapter adapter;

    /**
     * Configuração do Adaptador de Conexão
     * @param adapter Elemento para Configuração
     * @return Próprio Objeto para Encadeamento
     */
    public RemoteServer setAdapter(ConnectionAdapter adapter)
    {
        this.adapter = adapter;
        return this;
    }

    /**
     * Informação do Adaptador de Conexão
     * @return Elemento de Informação
     */
    public ConnectionAdapter getAdapter()
    {
        return this.adapter;
    }

    /**
     * Execução Principal do Servidor de Mensagens
     * Utiliza o adaptador de conexão para receber as informações transferidas
     * do dispositivo remoto e fornece estes dados para o interpretador.
     */
    public void run()
    {
        
    }
}
