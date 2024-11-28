<?php
include 'produtos_controller.php';

//Prepara pa gerenciar a sessão
session_start();

// Verifica se o usuário está registrado na sessão (logado)
if (!isset($_SESSION['email'])) {
    header("Location: index.php");
    exit();
}

// Armazena informações do usuário
$nome = $_SESSION['nome'];
$email = $_SESSION['email'];

// Função para lidar com o logout
if (isset($_POST['logout'])) {
    session_unset();
    session_destroy();
    header("Location: index.php");
    exit();
}
//Pega todos os produtos para preencher os dados da tabela
$prods = getProds();

//Variável que guarda o ID do produtos que será editado
$prodToEdit = null;

// Verifica se existe o parâmetro edit pelo método GET
// e sé há um ID para edição de produtos
if (isset($_GET['edit'])) {
    $prodToEdit = getProd($_GET['edit']);
}
?>
<?php include 'header.php'; ?>
<!DOCTYPE html>
<html lang="pt-BR">
<head>
<meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.6.2/dist/css/bootstrap.min.css">
  <script src="https://cdn.jsdelivr.net/npm/jquery@3.7.1/dist/jquery.slim.min.js"></script>
  <script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.1/dist/umd/popper.min.js"></script>
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.6.2/dist/js/bootstrap.bundle.min.js"></script>
</head>
<body>
    <script src="js/main.js"></script>
    <div class="container-fluid">
    <h2 style="text-align:center">Cadastro de Produtos</h2>
    <form method="POST" action="">
        <input type="hidden" id="id" name="id" value="<?php echo $prodToEdit['id'] ?? ''; ?>">
        <div class="form-group row">
        <div class="form-group row" style="width:50%; text-align:center">
        <label for="nome" class="col-sm-2 col-form-label">Nome:</label>
            <div class="col-sm-10">
            <input class="form-control" type="text" id="nome" name="nome" value="<?php echo $prodToEdit['nome'] ?? ''; ?>" required>
            </div>
        </div>
        <div class="form-group row" style="width:50%; text-align:center">
        <label for="descricao" class="col-sm-2 col-form-label">Descrição:</label>
            <div class="col-sm-10">
            <input class="form-control" type="text" id="descricao" name="descricao" value="<?php echo $prodToEdit['descricao'] ?? ''; ?>" required>
            </div>
        </div>
        <div class="form-group row" style="width:50%; text-align:center">
        <label for="marca" class="col-sm-2 col-form-label">Marca:</label>
            <div class="col-sm-10">
            <input class="form-control" type="text" id="marca" name="marca" value="<?php echo $prodToEdit['marca'] ?? ''; ?>" required>
            </div>
        </div>
        <div class="form-group row" style="width:50%; text-align:center">
        <label for="modelo" class="col-sm-2 col-form-label">Modelo:</label>
            <div class="col-sm-10">
            <input class="form-control" type="text" id="modelo" name="modelo" value="<?php echo $prodToEdit['modelo'] ?? ''; ?>" required>
            </div>
        </div>
        </div>
        <div class="form-group row">
        <div class="form-group row" style="width:50%; text-align:center">
        <label for="valorUnitario" class="col-sm-2 col-form-label">Valor Unitario:</label>
            <div class="col-sm-10">
            <input class="form-control" type="double" id="valorUnitario" name="valorUnitario" value="<?php echo $prodToEdit['valorunitario'] ?? ''; ?>" required>
            </div>    
        </div>
        <div class="form-group row" style="width:50%; text-align:center; item-align:right">
        <label for="categoria" class="col-sm-2 col-form-label">Categoria:</label>
            <div class="col-sm-10">
            <input class="form-control" type="text" id="categoria" name="categoria" value="<?php echo $prodToEdit['categoria'] ?? ''; ?>" required>
            </div>
        </div>
        <div class="form-group row" style="width:50%; text-align:center; item-align:right">
        <label for="url_img" class="col-sm-2 col-form-label">Url da Imagem:</label>
            <div class="col-sm-10">
            <input class="form-control" type="text" id="url_img" name="url_img" value="<?php echo $prodToEdit['url_img'] ?? ''; ?>" required>
            </div>
        </div>
        <div class="form-group row" style="width:50%; text-align:center; item-align:right">
        <label for="ativo" class="col-sm-2 col-form-label">Ativo:</label>
            <div class="col-sm-10">
            <input class="form-control" type="int" id="ativo" name="ativo" value="<?php echo $prodToEdit['ativo'] ?? ''; ?>">
            </div>
        </div>
        </div>
        <div style="text-align:center">
        <button class="btn btn-outline-primary" type="submit" name="save">Inserir</button>
        <button class="btn btn-outline-primary" type="submit" name="update">Atualizar</button>
        <button class="btn btn-outline-primary" type="button" onclick="clearForm()">Novo</button>
        </div>

    </form>
</div>
    <div class="container-fluid"  style="width: 100%">
    <h2>Produtos Cadastrados</h2>
    <table border="1" class="table table-hover table-dark">
        <tr>
            <th>ID</th>
            <th>Nome</th>
            <th>Descrição</th>
            <th>Marca</th>
            <th>Modelo</th>
            <th>Valor Unitario</th>
            <th>Categoria</th>
            <th>Imagem</th>
            <th>Ativo</th>
        </tr>
        <!--Faz um loop FOR no resultset de usuários e preenche a tabela-->
        <?php foreach ($prods as $prod): ?>
            <tr>
                <td><?php echo $prod['id']; ?></td>
                <td><?php echo $prod['nome']; ?></td>
                <td><?php echo $prod['descricao']; ?></td>
                <td><?php echo $prod['marca']; ?></td>
                <td><?php echo $prod['modelo']; ?></td>
                <td><?php echo $prod['valorunitario']; ?></td>
                <td><?php echo $prod['categoria']; ?></td>
                <td><img src="<?php echo $prod['url_img']; ?>" alt="prod" style="width: 100px;"></td>
                <td><?php echo $prod['ativo']; ?></td>
                <td>
                <a href="?edit=<?php echo $prod['id']; ?>" class="btn btn-success" type="submit" name="save">Editar</a>
                <a href="?delete=<?php echo $prod['id']; ?>" onclick="return confirm('Tem certeza que deseja excluir?');" class="btn btn-danger" type="submit" name="save">Excluir</a>
                </td>
            </tr>
        <?php endforeach; ?>
    </table>
    </div><br><br>
<?php include 'footer.php'; ?>
</body>
</html>