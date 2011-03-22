package br.nom.camargo.wanderson.presenter;

import java.io.IOException;
import java.io.OutputStream;
import java.net.Socket;

import android.app.Activity;
import android.content.Intent;
import android.os.Bundle;
import android.view.Menu;
import android.view.MenuInflater;
import android.view.MenuItem;
import android.view.View;
import android.widget.Button;
import android.widget.EditText;
import android.widget.Toast;
import br.nom.camargo.wanderson.presenter.model.ConfigModel;
import br.nom.camargo.wanderson.presenter.model.DatabaseHelper;

/**
 * Atividade Principal do Aplicativo
 * @author Wanderson Henrique Camargo Rosa
 */
public class MainActivity extends Activity
{
    /**
     * Campo de Mensagens
     */
    private EditText message;

    /**
     * Execução em Tempo de Inicialização
     */
    public void onCreate(Bundle savedInstanceState)
    {
        /*
         * Configurações Padrão
         */
        super.onCreate(savedInstanceState);
        setContentView(R.layout.main);

        /*
         * Captura do Campo de Mensagens
         */
        message = (EditText) findViewById(R.id.message);

        /*
         * Anexo entre Botão de Envio e Comando
         */
        Button send = (Button) findViewById(R.id.send);
        send.setOnClickListener(new View.OnClickListener() {
            public void onClick(View v) {
                send();
            }
        });
    }

    /**
     * Criação do Menu de Opções
     */
    public boolean onCreateOptionsMenu(Menu menu)
    {
        MenuInflater inflater = getMenuInflater();
        inflater.inflate(R.menu.main, menu);
        return true;
    }

    /**
     * Seleção de Elementos do Menu de Opções
     */
    public boolean onOptionsItemSelected(MenuItem item)
    {
        boolean confirm = false;
        Intent intent = null;
        switch (item.getItemId()) {
        case R.id.config:
            /*
             * Atividade de Configurações
             */
            intent = new Intent("br.nom.camargo.wanderson.presenter.ConfigActivity");
            startActivity(intent);
            confirm = true;
            break;
        }
        if (!confirm) {
            confirm = super.onContextItemSelected(item);
        }
        return confirm;
    }

    /**
     * Envio da Mensagem Informada em Campo Especializado
     * @return Próprio Objeto para Encadeamento
     */
    public MainActivity send()
    {
        /*
         * Solicitação do Ponteiro ao Banco de Dados
         */
        PresenterApplication application =
            (PresenterApplication) getApplication();
        DatabaseHelper database = application.getDatabase();
        ConfigModel model = new ConfigModel(database);

        /*
         * Informação de Endereço e Porta para Conexão
         */
        String serverAddr = model.getServerAddr();
        String port = model.getPort();

        try {
            /*
             * Abertura de Socket
             */
            Socket socket = new Socket(serverAddr, Integer.parseInt(port));
            OutputStream out = socket.getOutputStream();
            byte buffer[] = message.getText().toString().getBytes();
            out.write(buffer.length);
            out.write(buffer);
            socket.close();
            Toast.makeText(this, "Ok!", Toast.LENGTH_SHORT).show();
        } catch (IOException e) {
            /*
             * Impossível Envio de Informações
             */
            Toast.makeText(this, "Socket Error", Toast.LENGTH_LONG).show();
        }

        return this;
    }
}
