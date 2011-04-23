package br.nom.camargo.wanderson.presenter;

import android.app.Activity;
import android.os.Bundle;
import android.view.Menu;
import android.view.MenuItem;
import android.widget.TextView;
import br.nom.camargo.wanderson.presenter.DeviceElement.Type;

/**
 * Cadastro de Dispositivos Ethernet
 * 
 * Utiliza o banco de dados para cadastrar elementos do tipo Ethernet para
 * conexão do apresentador de slides. Formulário para cadastro e atualização dos
 * dados do dispositivo. Deve verificar se o dispositivo é realmente do tipo
 * Ethernet.
 * 
 * @author Wanderson Henrique Camargo Rosa
 */
public class EthernetActivity extends Activity
{
    /**
     * Nome do Dispositivo de Ethernet
     */
    private DeviceElement device;

    /**
     * Campo Nome do Dispositivo
     */
    private TextView name;

    /**
     * Campo Endereço de Conexão
     */
    private TextView address;

    /**
     * Campo Porta de Conexão Ethernet
     */
    private TextView port;

    public void onCreate(Bundle savedInstanceState)
    {
        super.onCreate(savedInstanceState);
        setContentView(R.layout.ethernet);

        /* Captura de Elementos de Visualização */
        name    = (TextView) findViewById(R.id.ethernet_name);
        address = (TextView) findViewById(R.id.ethernet_address);
        port    = (TextView) findViewById(R.id.ethernet_port);

        /* Nome do Dispositivo para População */
        String identifier = getIntent().getStringExtra("name");
        if (identifier != null) {
            device = ((PresenterApplication) getApplication())
                .getDatabase().retrieve(identifier, Type.Ethernet);
            /* Dispositivo Encontrado */
            if (device != null) {
                /* População dos Campos */
                name.setText(device.getName());
                address.setText(device.getAddress());
                port.setText(device.getPort());
            }
        }

    }

    public boolean onCreateOptionsMenu(Menu menu)
    {
        getMenuInflater().inflate(R.menu.save, menu);
        return true;
    }

    public boolean onOptionsItemSelected(MenuItem item)
    {
        boolean result;
        switch (item.getItemId()) {
        case R.id.menu_device_add:
            save();
            finish();
            result = true;
            break;
        case R.id.menu_device_cancel:
            finish();
            result = true;
            break;
        default:
            result = super.onOptionsItemSelected(item);
        }
        return result;
    }

    /**
     * Salva as Alterações do Dispositivo
     * Insere ou Atualiza os Dados Informados
     * @return Próprio Objeto para Encadeamento
     */
    public EthernetActivity save()
    {
        if (device == null) {
            /* Criar Novo Dispositivo */
            device =
                new DeviceElement(name.getText().toString(), Type.Ethernet);
            device.setAddress(address.getText().toString());
            device.setPort(port.getText().toString());
            ((PresenterApplication) getApplication())
                .getDatabase().insert(device);
        } else {
            /* Atualizar Dispositivo Existente */
            String dname = device.getName();
            device.setName(name.getText().toString())
                  .setAddress(address.getText().toString())
                  .setPort(port.getText().toString());
            ((PresenterApplication) getApplication())
                .getDatabase().update(device, dname, Type.Ethernet);
        }

        return this;
    }
}
