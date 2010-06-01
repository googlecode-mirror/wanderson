package br.unisinos.mraeder;

import java.io.*;

@SuppressWarnings("serial")
public class PacoteTCP implements Serializable{

    private String portaOrigem, portaDestino;
    private int numSequencia;
    private int numAck;
    private String tamanhoCabecalho;
    private String naoUsado;
    private int urg, ack, psh, rst, syn, fin;
    private int tamanhoJanela;
    private String checksum;
    private String ponteiroUrgencia;
    private String dados;

    public PacoteTCP(){
    } 
    
    public void setPortaOrigem(String portaOrigem){
        this.portaOrigem = portaOrigem;
    }
    
    public void setPortaDestino(String portaDestino){
        this.portaDestino = portaDestino;
    }
    
    public void setNumSequencia(int numSequencia){
        this.numSequencia = numSequencia;
    }
    
    public void setNumAck(int numAck){
        this.numAck = numAck;
    }
    
    public void setTamanhoCabecalho(String tamanhoCabecalho){
        this.tamanhoCabecalho = tamanhoCabecalho;
    }
    
    public void setNaoUsado(String naoUsado){
        this.naoUsado = naoUsado;
    }
    
    public void setUrg(int urg){
        this.urg = urg;
    }
    
    public void setAck(int ack){
        this.ack = ack;
    }
    
    public void setPsh(int psh){
        this.psh = psh;
    }
    
    public void setRst(int rst){
        this.rst = rst;
    }
    
    public void setSyn(int syn){
        this.syn = syn;
    }
    
    public void setFin(int fin){
        this.fin = fin;
    }
    
    public void setTamanhoJanela(int tamanhoJanela){
        this.tamanhoJanela = tamanhoJanela;
    }
    
    public void setCheksum(String checksum){
        this.checksum = checksum;
    }
    
    public void setPonteiroUrgencia(String ponteiroUrgencia){
        this.ponteiroUrgencia = ponteiroUrgencia;
    }
    
    public void setDados(String dados){
        this.dados = dados;
    }

    public String getPortaOrigem(){
        return portaOrigem;
    }
    
    public String getPortaDestino(){
        return portaDestino;
    }
    
    public int getNumSequencia(){
        return numSequencia;
    }
    
    public int getNumAck(){
        return numAck;
    }
    
    public String getTamanhoCabecalho(){
        return tamanhoCabecalho;
    }
    
    public String getNaoUsado(){
        return naoUsado;
    }
    
    public int getUrg(){
        return urg;
    }
    
    public int getAck(){
        return ack;
    }
    
    public int getPsh(){
        return psh;
    }
    
    public int getRst(){
        return rst;
    }
    
    public int getSyn(){
        return syn;
    }
    
    public int getFin(){
        return fin;
    }
    
    public int getTamanhoJanela(){
        return tamanhoJanela;
    }
    
    public String getChecksum(){
        return checksum;
    }
    
    public String getPonteiroUrgencia(){
        return ponteiroUrgencia;
    }
    
    public String getDados(){
        return dados;
    }
    
    public String toString(){
        return ""+
               getPortaOrigem()+""+getPortaDestino()+""+
               getNumSequencia()+""+
               getNumAck()+""+
               getTamanhoCabecalho()+""+getNaoUsado()+""+
               getUrg()+""+getAck()+""+getPsh()+""+getRst()+""+getSyn()+""+getFin()+""+
               getTamanhoJanela()+""+
               getChecksum()+""+
               getPonteiroUrgencia()+""+
               getDados()+"";
    }
}