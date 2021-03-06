package br.nom.camargo.wanderson.presenter;

import android.app.Activity;
import android.os.Bundle;
import android.view.KeyEvent;
import android.view.Menu;
import android.view.MenuItem;
import android.webkit.WebView;
import android.webkit.WebViewClient;

/**
 * Atividade de Auxilio
 * 
 * Possui uma descrição de como utilizar o aplicativo, demonstrando aos usuários
 * como deve ser instalado o servidor na máquina e como deve ser feita a conexão
 * remota. Possui referências para acesso a informações do autor. Utiliza um
 * componente de visualização de páginas HTML, controlando as âncoras internas.
 * 
 * @author Wanderson Henrique Camargo Rosa
 */
public class AboutActivity extends Activity
{
    /**
     * Visualização de Páginas
     */
    private WebView about;

    /*
     * Tempo de Inicialização
     */
    public void onCreate(Bundle savedInstanceState)
    {
        super.onCreate(savedInstanceState);
        setContentView(R.layout.about);

        /* Visualização */
        about = (WebView) findViewById(R.id.about_view);
        /* Javascript Desnecessário */
        about.getSettings().setJavaScriptEnabled(false);
        about.setWebViewClient(new AboutClient());
        /* Página Inicial */
        about.loadUrl("file:///android_asset/index.html");
    }

    /*
     * Criação do Menu de Opções
     */
    public boolean onCreateOptionsMenu(Menu menu)
    {
        getMenuInflater().inflate(R.menu.about, menu);
        return true;
    }

    /*
     * Seleção de Elemento do Menu de Opções
     */
    public boolean onOptionsItemSelected(MenuItem item)
    {
        /* Resultado Esperado */
        boolean result = false;
        /* Blocos Condicionais */
        switch (item.getItemId()) {
        case R.id.about_home:
            /* Página Inicial */
            about.loadUrl("file:///android_asset/index.html");
            result = true;
            break;
        case R.id.about_back:
            /* Voltar Navegação */
            if (about.canGoBack()) about.goBack();
            result = true;
            break;
        case R.id.about_close:
            /* Finalizar Atividade */
            finish();
            break;
        }
        return result;
    }

    /*
     * Tratamento de Teclas
     */
    public boolean onKeyDown(int keycode, KeyEvent event)
    {
        /* Tratamento do Navegador */
        if ((keycode == KeyEvent.KEYCODE_BACK) && about.canGoBack()) {
            about.goBack();
            return true;
        }
        /* Tabela de Conteúdo */
        if ((keycode == KeyEvent.KEYCODE_SEARCH)) {
            about.loadUrl("file:///android_asset/contents.html");
            return true;
        }
        return super.onKeyDown(keycode, event);
    }

    /**
     * Cliente de Navegação
     * 
     * Evita que o navegador de páginas envie uma intensão para o sistema
     * solicitando abertura do conteúdo no navegador padrão.
     * 
     * @author Wanderson Henrique Camargo Rosa
     */
    private class AboutClient extends WebViewClient
    {
        public boolean shouldOverrideUrlLoading(WebView view, String url)
        {
            /* Evita Intensão Externa */
            view.loadUrl(url);
            return true;
        }
    }
}
