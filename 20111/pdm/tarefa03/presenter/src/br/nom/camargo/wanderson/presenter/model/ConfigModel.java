package br.nom.camargo.wanderson.presenter.model;

import android.content.ContentValues;
import android.database.Cursor;

/**
 * Camada de Modelo para Configurações
 * @author Wanderson Henrique Camargo Rosa
 */
public class ConfigModel
{
    /**
     * Banco de Dados
     */
    private DatabaseHelper database;

    /**
     * Construtor Padrão
     * @param database Banco de Dados
     */
    public ConfigModel(DatabaseHelper database)
    {
        this.database = database;
    }

    /**
     * Informação sobre Endereço do Servidor
     * @return Elemento Solicitado
     */
    public String getServerAddr()
    {
        Cursor c = database.getReadableDatabase()
            .rawQuery("SELECT name AS _id, value FROM config WHERE _id = ?", new String[] {"server"});
        c.moveToFirst();
        return c.getString(1);
    }

    /**
     * Configuração do Endereço do Servidor
     * @param serverAddr Elemento Informado
     * @return Próprio Objeto para Encadeamento
     */
    public ConfigModel setServerAddr(String serverAddr)
    {
        ContentValues values = new ContentValues();
        values.put("value", serverAddr);
        database.getWritableDatabase()
            .update("config", values, "name = ?", new String[]{"server"});
        return this;
    }

    /**
     * Informação sobre a Porta de Conexão no Servidor
     * @return Elemento Solicitado
     */
    public String getPort()
    {
        Cursor c = database.getReadableDatabase()
            .rawQuery("SELECT name AS _id, value FROM config WHERE _id = ?", new String[]{"port"});
        c.moveToFirst();
        return c.getString(1);
    }

    /**
     * Configuração da Porta de Conexão no Servidor
     * @param port Elemento Informado
     * @return Próprio Objeto para Encadeamento
     */
    public ConfigModel setPort(String port)
    {
        ContentValues values = new ContentValues();
        values.put("value", port);
        database.getWritableDatabase()
            .update("config", values, "name = ?", new String[]{"port"});
        return this;
    }
}
