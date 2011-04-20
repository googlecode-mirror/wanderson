package br.nom.camargo.wanderson.presenter;

import android.database.SQLException;

/**
 * Arquitetura MVC
 * Modelo para Banco de Dados
 * 
 * @author Wanderson Henrique Camargo Rosa
 */
public abstract class DatabaseModel
{
    /**
     * Manipulador do Banco de Dados
     */
    private DatabaseHelper database;

    /**
     * Construtor
     * @param database Manipulador do Banco de Dados
     */
    public DatabaseModel(DatabaseHelper database)
    {
        setDatabaseHelper(database);
    }

    /**
     * Configura o Manipulador do Banco de Dados
     * @param database Elemento para Configuração
     * @return Próprio Objeto para Encadeamento
     */
    private DatabaseModel setDatabaseHelper(DatabaseHelper database)
    {
        this.database = database;
        return this;
    }

    /**
     * Informa o Manipulador do Banco de Dados
     * @return Elemento de Informação
     */
    public DatabaseHelper getDatabase()
    {
        return database;
    }

    /**
     * CRUD Stereotype Create
     * Manutenir Objetos Criar
     * @param o Objeto para Criação no Banco de Dados
     * @return Próprio Objeto para Encadeamento
     * @throws SQLException Erro de Execução
     */
    public abstract DatabaseHelper create(Object o) throws SQLException;

    /**
     * CRUD Stereotype Update
     * Manuternir Objetos Atualizar
     * @param o Objeto para Atualização no Banco de Dados
     * @return Próprio Objeto para Encadeamento
     * @throws SQLException Erro de Execução
     */
    public abstract DatabaseHelper update(Object o) throws SQLException;

    /**
     * CRUD Stereotype Delete
     * Manutenir Objetos Remover
     * @param o Objeto para Remoção do Banco de Dados
     * @return Próprio Objeto para Encadeamento
     * @throws SQLException Erro de Execução
     */
    public abstract DatabaseHelper delete(Object o) throws SQLException;

    /**
     * CRUD Stereotype Retrieve
     * Manutenir Objetos Recuperar
     * @param o Objeto para Recuperação do Banco de Dados
     * @return Próprio Objeto para Encadeamento
     * @throws SQLException Erro de Execução
     */
    public abstract DatabaseHelper retrieve(Object o) throws SQLException;

    /**
     * CRUD Stereotype Retrieve Complete List
     * Manutenir Objetos Recuperar Lista Completa
     * @return Conjunto de Todos Elementos Cadastrados
     * @throws SQLException Erro de Execução
     */
    public abstract Object[] retrieve() throws SQLException;
}
