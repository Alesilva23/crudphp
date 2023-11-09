<?php
    require_once 'classe-pessoa.php';
    $p = new Pessoa ("crudpdo","localhost","root","");
?>
<!DOCTYPE html>aler
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="style.css">
    <title>Cadastrar</title>
</head>
<body id="body">
    <?php
    if(isset($_POST['nome']))
    //clicou no botão cadastrar ou editar
    {
        //--------------------EDITAR----------------------
        if(isset($_GET['id_up']) && !empty($_GET['id_up']))
        {
             $id_upd = addslashes($_GET['id_up']);
             $nome = addslashes($_POST['nome']);
             $telefone = addslashes($_POST['telefone']);
             $email = addslashes($_POST['email']);
             if(!empty($nome) && !empty($telefone) && !empty($email))
             {
                //EDITAR
                $p->atualizarDados($id_upd, $nome, $telefone, $email);
                header("location: index.php");
             }
             else
             {
                ?>
                <div class="aviso">
                    <img src="aviso.png">
                    <h4>Preencha todos os campos!</h4>
                </div>
                <?php
             }
        }
        //-------------------CADASTRAR---------------------------
        else
        {
            $nome = addslashes($_POST['nome']);
            $telefone = addslashes($_POST['telefone']);
            $email = addslashes($_POST['email']);

            if(!empty($nome) && !empty($telefone) && !empty($email))
            {
                //CADASTRAR
                if(!$p->cadastrarPessoa($nome, $telefone, $email))
                {
                    ?>
                    <div class="aviso">
                        <img src="alerta.png">
                        <h4>E-mail já está cadastrado!</h4>
                    </div>
                    <?php
                }
                else
                {
                    ?>
                    <div class="aviso">
                        <img src="joinha.webp">
                        <h4>cadastrado com sucesso!</h4>
                    </div>
                    <?php
                }
            }
        }
    }
    ?>
    <?php
    if(isset($_GET['id_up']))//SE A PESSOA CLICOU EM EDITAR
    {
        $id_update = addslashes($_GET['id_up']);
        $res = $p->buscarDadosPessoa($id_update);
    }
    ?>
    <section id="esquerda">
        <form method="POST">
            <h2>CADASTRO DE ALUNOS</h2>
            <label for="nome">Nome:</label>
            <input type="text" name="nome" id="nome" value="<?php if(isset($res['nome'])){echo $res['nome'];}?>" required>
            <label for="telefone">Telefone:</label>
            <input type="text" name="telefone"  id="telefone" value="<?php if(isset($res['telefone'])){echo $res['telefone'];}?>" required>
            <label for="email">E-mail:</label>
            <input type="text" name="email"  id="email" value="<?php if(isset($res['email'])){echo $res['email'];}?>" required>
            <input type="submit" value="<?php if(isset($res)){echo "ATUALIZAR";}else{echo "CADASTRAR";} ?>">
        </form>
    </section>
    <section id="direita">
        <table>
            <tr id="titulo">
                <td>NOME</td>
                <td>TELEFONE</td>   
                <td colspan="2">EMAIL</td>
            </tr>
            <?php
        $dados = $p->buscarDados();
        if(count($dados) > 0)//TEM PESSOAS CADASTRADAS NO BANCO
        {
            for($i=0; $i < count($dados); $i++)
            {
                echo "<tr>";
                foreach ($dados[$i] as $k => $v)
                {
                    if($k != "id")
                    {
                        echo "<td>".$v."</td>";
                    }
                }
                ?>
                <td>
                    <a href="index.php?id_up=<?php echo $dados[$i]['id'];?>">Editar</a>
                    <a href="index.php?id=<?php echo $dados[$i]['id'];?>">Excluir</a>
                </td>
                <?php
                echo "</tr>";
            }
        }
        else//O BANCO DE DADOS ESTA VAZIO
        {
            ?>
         </table>
           <div class="aviso">
            <h4>Ainda não há pessoas cadastradas!</h4>
            <img src="">
           </div>
           <?php
        }
        ?>        
    </section>
</body>
</html>
<?php
if(isset($_GET['id']))
{
    $id_pessoa = addslashes($_GET['id']);
    $p->excluirPessoa($id_pessoa);
    header("location: index.php");
}
?>