package br.nom.camargo.wanderson.presenter;

import android.content.Context;
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
            "CREATE TABLE " + DeviceModel.TABLE_NAME + " (" +
                DeviceModel.NAME    + " TEXT," +
                DeviceModel.TYPE    + " TEXT" +
                DeviceModel.UPDATED + " TEXT" +
                DeviceModel.ADDRESS + " TEXT" +
                DeviceModel.PORT    + " TEXT" +
            "   PRIMARY KEY(" + DeviceModel.NAME + ","+ DeviceModel.TYPE +")," +
            "   CHECK("+ DeviceModel.TYPE +" IN('Bluetooth','Ethernet')" +
            ");"
        );
    }

    public void onUpgrade(SQLiteDatabase db, int oldVersion, int newVersion)
    {
        /* Primeira Versão */
    }

}
