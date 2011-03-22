package br.nom.camargo.wanderson.presenter;

import br.nom.camargo.wanderson.presenter.model.ConfigModel;
import br.nom.camargo.wanderson.presenter.model.DatabaseHelper;
import android.app.Activity;
import android.os.Bundle;
import android.view.View;
import android.widget.Button;
import android.widget.EditText;

/**
 * Atividade de Configurações do Aplicativo
 * @author Wanderson Henrique Camargo Rosa
 */
public class ConfigActivity extends Activity
{
    /**
     * Campo de Endereço do Servidor
     */
    private EditText serverAddr;

    /**
     * Porta para Conexão no Servidor
     */
    private EditText port;

    /**
     * Camada de Modelo para Configurações
     */
    private ConfigModel model;

    /**
     * Execução em Tempo de Inicialização
     */
    public void onCreate(Bundle savedInstanceState)
    {
        /*
         * Configurações Padrão
         */
        super.onCreate(savedInstanceState);
        setContentView(R.layout.config);

        /*
         * Captura do Ponteiro ao Banco de Dados
         */
        PresenterApplication application =
            (PresenterApplication) this.getApplication();
        DatabaseHelper database = application.getDatabase();
        model = new ConfigModel(database);

        /*
         * Inicialização do Campo de Endereço Servidor
         */
        serverAddr = (EditText) findViewById(R.id.serverAddress);
        serverAddr.setText(model.getServerAddr());

        /*
         * Inicialização do Campo de Porta para Conexão
         */
        port = (EditText) findViewById(R.id.port);
        port.setText(model.getPort());

        /*
         * Anexo entre Botão de Salvar e Finalização da Atividade
         */
        Button save = (Button) findViewById(R.id.save);
        save.setOnClickListener(new View.OnClickListener() {
            public void onClick(View v) {
                finish();
            }
        });
    }

    /**
     * Execução em Tempo de Finalização
     */
    public void onStop()
    {
        /*
         * Ao finalizar a atividade, necessário salvar informações
         */
        model.setServerAddr(serverAddr.getText().toString());
        model.setPort(port.getText().toString());
        /*
         * Método Sobrescrito Necessário
         */
        super.onStop();
    }
}
