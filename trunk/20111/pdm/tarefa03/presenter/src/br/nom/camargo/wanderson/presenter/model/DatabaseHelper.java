package br.nom.camargo.wanderson.presenter.model;

import android.content.Context;
import android.database.sqlite.SQLiteDatabase;
import android.database.sqlite.SQLiteOpenHelper;

/**
 * Auxiliar para Banco de Dados
 * @author Wanderson Henrique Camargo Rosa
 */
public class DatabaseHelper extends SQLiteOpenHelper
{
    /**
     * Arquivo do Banco de Dados
     */
    private static final String DATABASE_NAME = "presenter.db";

    /**
     * Construtor Padrão
     * @param context Contexto para Referência
     */
    public DatabaseHelper(Context context)
    {
        super(context, DATABASE_NAME, null, 1);
    }

    /**
     * Criação do Banco de Dados
     */
    public void onCreate(SQLiteDatabase db)
    {
        db.execSQL("CREATE TABLE config(name TEXT, value TEXT, type TEXT)");
        db.execSQL("INSERT INTO config VALUES (\"server\", \"127.0.0.1\", \"text\")");
        db.execSQL("INSERT INTO config VALUES (\"port\", \"5000\", \"integer\")");
    }

    /**
     * Atualização do Banco de Dados
     */
    public void onUpgrade(SQLiteDatabase db, int oldVersion, int newVersion)
    {
        
    }
}
