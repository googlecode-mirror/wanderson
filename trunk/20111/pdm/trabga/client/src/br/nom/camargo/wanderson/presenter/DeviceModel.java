package br.nom.camargo.wanderson.presenter;

import android.content.ContentValues;
import android.database.SQLException;

/**
 * Arquitetura MVC
 * Modelo de Banco de Dados para Dispositivos
 * 
 * @author Wanderson Henrique Camargo Rosa
 */
public class DeviceModel extends DatabaseModel
{
    /**
     * Nome da Tabela no Banco de Dados
     */
    public static final String TABLE_NAME = "device";

    /**
     * Nome do Dispositivo
     */
    public static final String NAME = "name";

    /**
     * Tipo do Dispositivo
     */
    public static final String TYPE = "type";

    /**
     * Última Atualização
     */
    public static final String UPDATED = "updated";

    /**
     * Endereço para Conexão
     */
    public static final String ADDRESS = "address";

    /**
     * Porta para Conexão
     */
    public static final String PORT = "port";

    /**
     * Construtor
     * @param database Manipulador do Banco de Dados
     */
    public DeviceModel(DatabaseHelper database)
    {
        super(database);
    }

    public DatabaseModel create(Object o) throws SQLException
    {
        /* Casting de Objeto */
        DeviceElement element = (DeviceElement) o;
        ContentValues values = new ContentValues();
        /* Inclusão de Elementos */
        values.put(NAME, element.getName());
        values.put(TYPE, element.getType().toString());
        values.put(UPDATED, 0);
        values.put(ADDRESS, element.getAddress());
        values.put(PORT, element.getPort());
        /* Cadastro no Banco de Dados */
        getDatabase().getWritableDatabase()
            .insert(DeviceModel.TABLE_NAME, null, values);
        return this;
    }

    public DatabaseModel update(Object o) throws SQLException
    {
        return this;
    }

    public DatabaseModel delete(Object o) throws SQLException
    {
        return this;
    }

    public DatabaseModel retrieve(Object o) throws SQLException
    {
        return null;
    }

    public Object[] retrieve() throws SQLException
    {
        return null;
    }

}
