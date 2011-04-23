package br.nom.camargo.wanderson.presenter;

import java.util.ArrayList;

import android.content.ContentValues;
import android.content.Context;
import android.database.Cursor;
import android.database.sqlite.SQLiteDatabase;
import android.database.sqlite.SQLiteOpenHelper;

/**
 * Auxiliar de Banco de Dados
 * 
 * Gerencia o objeto de banco de dados conforme necessidade, construindo um
 * pequeno versionamento para atualização de aplicativos e estrutura de
 * armazenamento de dados.
 * 
 * @author Wanderson Henrique Camargo Rosa
 */
public class DatabaseHelper extends SQLiteOpenHelper
{
    /**
     * Nome do Banco de Dados
     */
    private static final String DATABASE_NAME = "presenter.db";

    /**
     * Versão Atual da Estrutura
     */
    private static final int DATABASE_VERSION = 1;

    /**
     * Construtor
     * @param context Contexto de Aplicativo
     */
    public DatabaseHelper(Context context)
    {
        /* Construtor Fixo para Banco de Dados */
        super(context, DATABASE_NAME, null, DATABASE_VERSION);
    }

    public void onCreate(SQLiteDatabase db)
    {
        db.execSQL(
            "CREATE TABLE device (" +
            "    name TEXT," +
            "    type TEXT," +
            "    updated TEXT," +
            "    address TEXT," +
            "    port TEXT," +
            "    PRIMARY KEY(name,type)," +
            "    CHECK(type IN('Bluetooth','Ethernet'))" +
            ")"
        );
    }

    public void onUpgrade(SQLiteDatabase db, int oldVersion, int newVersion)
    {
        /* Primeira Versão */
    }

    /**
     * Recupera os Dispositivos do Banco
     * @return Conjunto de Dispositivos
     */
    public ArrayList<DeviceElement> getDevices()
    {
        Cursor c = getReadableDatabase()
            .rawQuery("SELECT name,type,updated,address,port FROM device ORDER BY updated DESC", new String[]{});
        ArrayList<DeviceElement> devices = new ArrayList<DeviceElement>();
        if (c.moveToFirst()) {
            DeviceElement element;
            do {
                element = new DeviceElement();
                element.setName(c.getString(0))
                       .setType(DeviceElement.Type.valueOf(c.getString(1)))
                       .setAddress(c.getString(3))
                       .setPort(c.getString(4));
                devices.add(element);
            } while (c.moveToNext());
        }
        return devices;
    }

    /**
     * Remove um Dispositivo do Banco
     * @param device Elemento para Remoção
     * @return Próprio Objeto para Encadeamento
     */
    public DatabaseHelper remove(DeviceElement device)
    {
        ContentValues content = device.getContentValues();
        getWritableDatabase().delete("device", "name = ? AND type = ?",
            new String[]{content.getAsString("name"), content.getAsString("type")});
        return this;
    }

    /**
     * Insere um Dispositivo no Banco
     * @param device Elemento para Inclusão
     * @return Próprio Objeto para Encadeamento
     */
    public DatabaseHelper insert(DeviceElement device)
    {
        getWritableDatabase().insert("device", null, device.getContentValues());
        return this;
    }

}
