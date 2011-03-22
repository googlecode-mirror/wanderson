package br.nom.camargo.wanderson.presenter;

import br.nom.camargo.wanderson.presenter.model.DatabaseHelper;
import android.app.Application;

/**
 * Representação do Aplicativo
 * @author Wanderson Henrique Camargo Rosa
 */
public class PresenterApplication extends Application
{
    /**
     * Banco de Dados do Aplicativo
     */
    private DatabaseHelper database;

    /**
     * Execução em Tempo de Inicialização
     */
    public void onCreate()
    {
        super.onCreate();
        database = new DatabaseHelper(this);
    }

    /**
     * Informação sobre o Banco de Dados
     * @return Elemento Solicitado
     */
    public DatabaseHelper getDatabase()
    {
        return database;
    }
}
