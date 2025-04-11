<?php
namespace Componentes;

use Usuario\Usuario;

class ListaUsuarios {
    private const CLASSES = [
        'container' => 'overflow-x-auto',
        'table' => 'table-auto w-full border-collapse border border-gray-300',
        'header_row' => 'bg-gray-200',
        'header_cell' => 'border border-gray-300 px-4 py-2',
        'row' => 'hover:bg-gray-100',
        'cell' => 'border border-gray-300 px-4 py-2',
        'action_container' => 'flex space-x-2 sm:flex-row sm:space-x-2 sm:block',
        'edit_button' => 'bg-yellow-500 text-white px-4 py-2 rounded hover:bg-yellow-600 block sm:inline-block',
        'delete_button' => 'bg-red-500 text-white px-4 py-2 rounded hover:bg-red-600 block sm:inline-block',
        'pagination' => 'pagination mt-6 flex justify-center space-x-2',
        'page_button' => 'bg-gray-300 px-4 py-2 rounded hover:bg-gray-400'
    ];
    
    private int $usuariosPorPagina = 15;

    private function gerarCabecalhoTabela(): string {
        $colunas = ['ID', 'Login', 'Permissão', 'Ações'];
        
        $cabecalho = "<thead><tr class='" . self::CLASSES['header_row'] . "'>";
        
        foreach ($colunas as $coluna) {
            $cabecalho .= "<th class='" . self::CLASSES['header_cell'] . "'>{$coluna}</th>";
        }
        
        $cabecalho .= "</tr></thead>";
        
        return $cabecalho;
    }

    private function gerarLinhaUsuario(Usuario $usuario): string {
        return "<tr class='" . self::CLASSES['row'] . "'>
            <td class='" . self::CLASSES['cell'] . "'>" . htmlspecialchars($usuario->getId()) . "</td>
            <td class='" . self::CLASSES['cell'] . "'>" . htmlspecialchars($usuario->getLogin()) . "</td>
            <td class='" . self::CLASSES['cell'] . "'>" . htmlspecialchars($usuario->getPermissao()) . "</td>
            <td class='" . self::CLASSES['cell'] . "'>
                <div class='" . self::CLASSES['action_container'] . "'>
                    <a href='usuarios/edicao.php?id=" . htmlspecialchars($usuario->getId()) . "' 
                       class='" . self::CLASSES['edit_button'] . "'>
                       Editar
                    </a>
                    <a href='usuarios/confirmaExclusao.php?id=" . htmlspecialchars($usuario->getId()) . "' 
                       class='" . self::CLASSES['delete_button'] . "'>
                       Excluir
                    </a>
                </div>
            </td>
        </tr>";
    }

    private function gerarMensagemVazia(): string {
        return "<tr class='" . self::CLASSES['row'] . "'>
            <td class='" . self::CLASSES['cell'] . "' colspan='4'>Nenhum usuário encontrado!</td>
        </tr>";
    }

    private function gerarPaginacao(int $paginaAtual, int $totalPaginas): string {
        $paginacao = "<div class='" . self::CLASSES['pagination'] . "'>";
        
        // Página anterior
        if ($paginaAtual > 1) {
            $paginacao .= "<a href='?pagina=" . ($paginaAtual - 1) . "' class='" . self::CLASSES['page_button'] . "'>Anterior</a>";
        }
        
        // Páginas numéricas
        for ($i = 1; $i <= $totalPaginas; $i++) {
            $paginacao .= "<a href='?pagina=$i' class='" . self::CLASSES['page_button'] . "'>" . $i . "</a>";
        }
        
        // Próxima página
        if ($paginaAtual < $totalPaginas) {
            $paginacao .= "<a href='?pagina=" . ($paginaAtual + 1) . "' class='" . self::CLASSES['page_button'] . "'>Próxima</a>";
        }
        
        $paginacao .= "</div>";
        
        return $paginacao;
    }

    public function gerarListaUsuarios(array $usuarios): string {
        $paginaAtual = isset($_GET['pagina']) ? (int)$_GET['pagina'] : 1;
        $inicio = ($paginaAtual - 1) * $this->usuariosPorPagina;
        $usuariosExibidos = array_slice($usuarios, $inicio, $this->usuariosPorPagina);
        
        $tabela = "<div class='" . self::CLASSES['container'] . "'>
            <table class='" . self::CLASSES['table'] . "'>
                " . $this->gerarCabecalhoTabela() . "
                <tbody>";
        
        if (!empty($usuariosExibidos)) {
            foreach ($usuariosExibidos as $usuario) {
                $tabela .= $this->gerarLinhaUsuario($usuario);
            }
        } else {
            $tabela .= $this->gerarMensagemVazia();
        }
        
        $tabela .= "</tbody>
            </table>
        </div>";
        
        // Calcula o total de páginas
        $totalUsuarios = count($usuarios);
        $totalPaginas = ceil($totalUsuarios / $this->usuariosPorPagina);
        
        // Adiciona a paginação
        $tabela .= $this->gerarPaginacao($paginaAtual, $totalPaginas);
        
        return $tabela;
    }
}

/* Código original
namespace Componentes;

use Usuario\Usuario;

class ListaUsuarios {
    private int $usuariosPorPagina = 15;

    public function gerarListaUsuarios(array $usuarios): string {
        $paginaAtual = isset($_GET['pagina']) ? (int)$_GET['pagina'] : 1;
        $inicio = ($paginaAtual - 1) * $this->usuariosPorPagina;
        $usuariosExibidos = array_slice($usuarios, $inicio, $this->usuariosPorPagina);

        $tabela = "
        <div class='overflow-x-auto'>
        <table class='table-auto w-full border-collapse border border-gray-300'>
            <thead>
                <tr class='bg-gray-200'>
                    <th class='border border-gray-300 px-4 py-2'>ID</th>
                    <th class='border border-gray-300 px-4 py-2'>Login</th>
                    <th class='border border-gray-300 px-4 py-2'>Permissão</th>
                    <th class='border border-gray-300 px-4 py-2'>Ações</th>
                </tr>
            </thead>
            <tbody>";

        if ($usuariosExibidos != []) {
            foreach ($usuariosExibidos as $usuario) {
                $tabela .= "
                    <tr class='hover:bg-gray-100'>
                        <td class='border border-gray-300 px-4 py-2'>" . htmlspecialchars($usuario->getId()) . "</td>
                        <td class='border border-gray-300 px-4 py-2'>" . htmlspecialchars($usuario->getLogin()) . "</td>
                        <td class='border border-gray-300 px-4 py-2'>" . htmlspecialchars($usuario->getPermissao()) . "</td>
                        <td class='border border-gray-300 px-4 py-2'>
                            <div class='flex space-x-2 sm:flex-row sm:space-x-2 sm:block'>
                                <a href='usuarios/edicao.php?id=" . htmlspecialchars($usuario->getId()) . "' 
                                class='bg-yellow-500 text-white px-4 py-2 rounded hover:bg-yellow-600 block sm:inline-block'>
                                Editar
                                </a>
                                <a href='usuarios/confirmaExclusao.php?id=" . htmlspecialchars($usuario->getId()) . "' 
                                class='bg-red-500 text-white px-4 py-2 rounded hover:bg-red-600 block sm:inline-block'>
                                Excluir
                                </a>
                            </div>
                        </td>
                    </tr>";
            }
        } else {
            $tabela .= "
                    <tr class='hover:bg-gray-100'>
                        <td class='border border-gray-300 px-4 py-2' colspan='4'>Nenhum usuário encontrado!</td>
                    </tr>";
        }

        $tabela .= "
            </tbody>
        </table>
        </div>";

        // Calcula o total de páginas
        $totalUsuarios = count($usuarios);
        $totalPaginas = ceil($totalUsuarios / $this->usuariosPorPagina);

        // Exibe os links de navegação entre as páginas
        $tabela .= "<div class='pagination mt-6 flex justify-center space-x-2'>";  // Flexbox para centralizar e espaçar os botões

        // Página anterior
        if ($paginaAtual > 1) {
            $tabela .= "<a href='?pagina=" . ($paginaAtual - 1) . "' class='bg-gray-300 px-4 py-2 rounded hover:bg-gray-400'>Anterior</a>";
        }

        // Páginas numéricas
        for ($i = 1; $i <= $totalPaginas; $i++) {
            $tabela .= "<a href='?pagina=$i' class='bg-gray-300 px-4 py-2 rounded hover:bg-gray-400'>" . $i . "</a>";
        }

        // Próxima página
        if ($paginaAtual < $totalPaginas) {
            $tabela .= "<a href='?pagina=" . ($paginaAtual + 1) . "' class='bg-gray-300 px-4 py-2 rounded hover:bg-gray-400'>Próxima</a>";
        }

        $tabela .= "</div>";

        return $tabela;
    }
}
*/