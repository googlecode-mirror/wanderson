package br.nom.camargo.wanderson.presenter;

import android.app.Application;

/**
 * Aplicativo Android
 * 
 * Centralização de referências para o aplicativo. Trabalha como um Singleton do
 * aplicativo recebendo as configurações de banco de dados e serviço de conexão
 * externo.
 * 
 * @author Wanderson Henrique Camargo Rosa
 */
public class PresenterApplication extends Application
{
    /**
     * Manipulador do Banco de Dados
     */
    private static DatabaseHelper database;

    /**
     * Acesso ao Manipulador do Banco de Dados
     * @return Elemento de Informação
     */
    public DatabaseHelper getDatabase()
    {
        if (database == null) {
            database = new DatabaseHelper(this);
        }
        return database;
    }
}
