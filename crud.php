<?php

require_once('./connetion.php');

?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <!-- CSS only -->

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-1BmE4kWBq78iYhFldvKuhfTAU6auU8tT94WrHftjDbrCEXSU1oBoqyl2QvZ6jIW3" crossorigin="anonymous">

    <title>Document</title>
</head>

<body>
    <h1>Formulário Aluno</h1>
    <br>
    <h2>Inserção de aluno</h2>

    <?php
    function create($aluno)
    {

        try {

            $con = getConnection();
            #Insert 

            $stmt = $con->prepare("INSERT INTO aluno(nome, idade,telefone) VALUES (:nome , :idade, :telefone)");

            $stmt->bindParam(":nome", $aluno->nome);
            $stmt->bindParam(":idade", $aluno->idade);
            $stmt->bindParam(":telefone", $aluno->telefone);


            if ($stmt->execute()) {
                echo " Aluno Cadastrado com sucesso";
            }
        } catch (PDOException $error) {
            echo "Error ao cadastrar o aluno. Error: {$error->getMessage()}";
        } finally {
            unset($con);
            unset($stmt);
        }
    }

    function get()
    {
        try {
            $con = getConnection();

            $rs = $con->query("SELECT nome, idade, telefone FROM aluno");

            while ($row = $rs->fetch(PDO::FETCH_OBJ)) {
                echo "Nome: " . $row->nome . " <br> idade: ";
                echo $row->idade;
                echo "<br> telefone: " . $row->telefone . "<br><br>";
            }
        } catch (PDOException $error) {
            echo "Erro ao listar aluno. Erro: {$error->getMessage()}";
        } finally {
            unset($con);
            unset($rs);
        }
    }
    ?>
    <?php
    #create teste - 
    $aluno = new stdClass();
    $aluno->nome = "joviscleia";
    $aluno->idade = "16";
    $aluno->telefone = "(66)96660-2892";
    create($aluno);

    echo "<br><br>---<br><br>";

    #create teste - 
    $aluno = new stdClass();
    $aluno->nome = "cladineitivant";
    $aluno->idade = "15";
    $aluno->telefone = "(66)96660-2855";
    create($aluno);

    echo "<br><br>---<br><br>";


    #get teste
    get();


    ?>

    <h2>Procurar Aluno</h2>

    <?php
    function find($nome)
    {
        try {
            $con = getConnection();

            $stmt = $con->prepare("SELECT nome, idade, telefone FROM aluno WHERE nome LIKE :nome");
            # o bindParam recebe os parâmetros por referência.
            # para literais usa bindValue
            $stmt->bindValue(":nome", "%{$nome}%");
            if ($stmt->execute()) {
                if ($stmt->rowCount() > 0) {
                    while ($row = $stmt->fetch(PDO::FETCH_OBJ)) {
                        echo "Nome: " . $row->nome . " <br> idade: ";
                        echo $row->idade;
                        echo "<br> telefone: " . $row->telefone . "<br><br>";
                    }
                }
            }
        } catch (PDOException $error) {
            echo "Erro ao buscar ao aluno '{$nome}'. Erro: {$error->getMessage()}";
        } finally {
            unset($con);
            unset($stmt);
        }
    }
    ?>
    <?php
    #teste do find
    find("joviscleia");

    ?>

    <h2>Atualizar Aluno</h2>



    <?php
    function update($aluno)
    {
        try {
            $con = getConnection();

            $stmt = $con->prepare("UPDATE aluno SET nome= :nome, idade = :idade, telefone = :telefone WHERE id = :id");

            $stmt->bindParam(":id", $aluno->id);
            $stmt->bindParam(":nome", $aluno->nome);
            $stmt->bindParam(":idade", $aluno->idade);
            $stmt->bindParam(":telefone", $aluno->telefone);

            if ($stmt->execute())
                echo "Aluno atualizado com sucesso <br><br>";
        } catch (PDOException $error) {
            echo "Error When Update the Student. Error: {$error->getMessage()}";
        } finally {
            unset($con);
            unset($stmt);
        }
    }
    ?>

    <?php
    #teste upgrade - Retirado aluno
    $aluno = new stdClass();
    $aluno->nome = "clauvineia";
    $aluno->idade = "15";
    $aluno->telefone = "(66)95764-4576";
    $aluno->id = 1;

    update($aluno);

    get();


    ?>

    <h2>Deletar aluno</h2>D
    <?php
    function delete($id)
    {
        try {
            $con = getConnection();

            $stmt = $con->prepare("DELETE FROM aluno WHERE id = ?");
            $stmt->bindParam(1, $id);

            if ($stmt->execute())
                echo "Aluno deletado com sucesso";
        } catch (PDOException $error) {
            echo "Erro ao deletar aluno. Erro: {$error->getMessage()}";
        } finally {
            unset($con);
            unset($stmt);
        }
    }

    ?>

    <?php
    #delete teste
    echo "<br><br>---<br><br>";
    delete(1); #deletado aluno
    echo "<br><br>---<br><br>";
    get();
    ?>
    <!-- JavaScript Bundle with Popper -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-ka7Sk0Gln4gmtz2MlQnikT1wXgYsOg+OMhuP+IlRH9sENBO0LRn5q+8nbTov4+1p" crossorigin="anonymous"></script>
</body>

</html>