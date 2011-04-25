package br.nom.camargo.wanderson.presenter;

import android.os.Bundle;
import android.preference.Preference;
import android.preference.Preference.OnPreferenceClickListener;
import android.preference.PreferenceActivity;

/**
 * Configurações do Aplicativo
 * 
 * Conforme especificação do trabalho, esta atividade controla as preferências
 * de utilização do aplicativo. Devemos fornecer a possibilidade de execução do
 * aplicativo em tela cheia, redução do brilho do dispositivo e escolha para
 * evitar que o dispositivo mantenha a exibição da tela.
 * 
 * @author Wanderson Henrique Camargo Rosa
 */
public class ConfigActivity extends PreferenceActivity
    implements OnPreferenceClickListener
{
    /**
     * Aplicativo em Tela Cheia
     */
    private Preference fullscreen;

    /**
     * Manter Exibição de Tela
     */
    private Preference keepalive;

    /**
     * Reduzir Brilho
     */
    private Preference brightness;

    /*
     * Tempo de Criação da Atividade
     */
    public void onCreate(Bundle state)
    {
        super.onCreate(state);
        addPreferencesFromResource(R.xml.config);

        /* Habilitar Fullscreen */
        fullscreen = findPreference("config_fullscreen");
        fullscreen.setOnPreferenceClickListener(this);

        /* Manter Exibição de Tela */
        keepalive = findPreference("config_keepalive");
        keepalive.setOnPreferenceClickListener(this);

        /* Reduzir o Brilho da Tela */
        brightness = findPreference("config_brightness");
        brightness.setOnPreferenceClickListener(this);
    }

    /*
     * Escolha de Preferência
     */
    public boolean onPreferenceClick(Preference preference)
    {
        /** TODO Tratamento de Escolha */
        return true;
    }
}
