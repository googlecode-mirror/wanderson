<?php
// Requisição de Configurações
require_once dirname(__FILE__) . '/../config.php';

// Camada de Modelo
$mMusics = new \Model\Musics();
$config  = \Pokeflute\Multiton::getInstance('Pokeflute\\Config');

// Ação Apresentada?
if (!empty($_GET['a']) && !empty($_GET['id'])) {
    // Identificador
    $id = (int) $_GET['id'];
    // Bloco Condicional
    switch ($_GET['a']) {
        case 'enable':
            $mMusics->setEnabled($id, true);
            break;
        case 'disable':
            $mMusics->setEnabled($id, false);
            break;
    }
    // Apresentar Resultados
    header('Content-Type: application/json');
    echo json_encode($mMusics->find($id));
    // Finalização
    exit(0);
}

// Consulta
$elements = $mMusics->fetchAll();

?>
<html>
    <head>
        <title>Pokeflute Shoutcast Playlist</title>
        <meta http-equiv="Content-Type" content="text/html;charset=UTF-8">
        <script type="text/javascript" src="http://ajax.googleapis.com/ajax/libs/jquery/1.7.1/jquery.min.js"></script>
        <script type="text/javascript">

$(function(){
    $('a.ajax').click(function(e){
        e.preventDefault();
        $.get($(this).attr('href'));
        return false;
    });
});

        </script>
    </head>
    <body>

<ul id="toolbar">
    <li><a href="?a=update">Atualizar Arquivos</a></li>
    <li><a class="ajax" href="<?php echo $config['music.server'] ?>">Próxima Música</a></li>
</ul>

<table>
    <thead>
        <tr>
            <th>Arquivo</th>
            <th>Prioridade</th>
            <th>Contador</th>
            <th>Habilitado?</th>
            <th>Ações</th>
        </tr>
    </thead>
    <tbody>
<?php if (count($elements) > 0) : ?>
<?php foreach ($elements as $element) : ?>
        <tr id="music-<?php echo $element['id'] ?>">
            <td><?php echo $element['filename'] ?></td>
            <td><?php echo $element['priority'] ?></td>
            <td><?php echo $element['counter'] ?></td>
            <td><?php echo $element['enabled'] ? 'Sim' : 'Não' ?></td>
            <td>
                <a class="ajax" href="?id=<?php echo $element['id'] ?>&a=nextsong">Próxima Música</a>
                <a class="ajax" href="?id=<?php echo $element['id'] ?>&a=priorhi">Subir Prioridade</a>
                <a class="ajax" href="?id=<?php echo $element['id'] ?>&a=priorlo">Baixar Prioridade</a>
                <a class="ajax" href="?id=<?php echo $element['id'] ?>&a=enable">Habilitar</a>
                <a class="ajax" href="?id=<?php echo $element['id'] ?>&a=disable">Desabilitar</a>
            </td>
        </tr>
<?php endforeach ?>
<?php else : ?>
        <tr>
            <td colspan="5">Sem Músicas Adicionadas</td>
        </tr>
<?php endif ?>
    </tbody>
</table>

    </body>
</html>
