<?php

session_start();
header("Cache-Control: no-cache, must-revalidate");
header("Pragma: no-cache");

include'config.php';



if ($_SERVER["REQUEST_METHOD"] == "POST") {
    if (isset($_POST['id_evento']) && isset($_SESSION['id_usuario'])) {
        $id_evento = $_POST['id_evento'];
        $id_usuario = $_SESSION['id_usuario'];

        $sql_check = "SELECT * FROM evento WHERE id_usuario = ? AND id_evento = ?";
        $stmt_check = $conn->prepare($sql_check);
        $stmt_check->bind_param("ii", $id_usuario, $id_evento);
        $stmt_check->execute();
        $result = $stmt_check->get_result();

        if ($result->num_rows == 0) {
            $sql_insert = "INSERT INTO evento (id_evento, id_usuario) VALUES (?,?) ";
            $stmt_insert = $conn->prepare($sql_insert);
            $stmt_insert->bind_param("ii", $id_evento, $id_usuario);

            $sql = " SELECT id_evento, id_ongs, data_evento, descricao, rua,bairro, estado, titulo, horas FROM registrar_eventos WHERE id_evento = ?";
            $stmt = $conn->prepare($sql);
            $stmt->bind_param("i", $id_evento);
            $stmt->execute();
            $result = $stmt->get_result();

            if ($stmt_insert->execute()) {
                ?>
                <!DOCTYPE html>
                <html lang="pt-br">

                <head>
                    <meta charset="UTF-8">
                    <meta name="viewport" content="width=device-width, initial-scale=1.0">
                    <title>Participando</title>
                    <link rel="icon" href="imgtcc/pet.jpeg">
                      <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
 
                    <link rel="stylesheet" href="tccestilo/estiloParticipacao.css">
                </head>
<body>
        <img src="imgtcc/pet.jpeg" alt="foto do pet">
                 
              
                   <div class="container">
                        <div class="Box1">
                            <h1>Parabéns você está participando desse evento a partir de agora</h1>
                        </div>
                        <div class="Box2">
                            <?php
                            if ($result->num_rows > 0) {
                                while ($row = $result->fetch_assoc()) {
                                    echo '<div class="Acima">';
                                    echo '<h2>' . $row["titulo"] . '</h2>';
                                    echo ' </div>';
                                    echo '<div class="Abaixo">';
                                    echo '<ul>';
                                    echo '<li><b>Descrição: ' . $row["descricao"] . ' </b>';
                                    echo '<p></p>';
                                    echo '</li>';
                                    echo '<li><b>Rua:</b>' . $row["rua"] . '  </li>';
                                    echo '<li><b>Bairro:</b>' . $row["bairro"] . '  </li>';
                                    echo '<li><b>Estado:</b>' . $row["estado"] . '  </li>';
                                    echo '<li><b>Data:</b>' . $row["data_evento"] . '  </li>';
                                    echo '<li><b>Horas:</b>' . $row["horas"] . '  </li>';
                                  
                                    echo '&nbsp;';
                                    ?>
                                    </ul>
                                      <div style="
    height: auto;
    display: flex;
    align-items: center;
    justify-content: center;">
                                <form action="comentarios.php" method="POST">
                                    <?php
                                echo '<input type="hidden" name="id_evento" value="' . $row['id_evento'] . '">';
                                ?>
                                <button class="comentarios" type="submit"><i class="bi bi-chat-dots-fill"></i></button> 
                                </form>
                                </div>
                                </div>
                            </div>
                            </div>
                            <form action="telaUser.php" method="post">
                             <?php
                                echo '<input type="hidden" name="id_usuario" value="' .$_SESSION['id_usuario'].  '">';
                                ?>
                              <button type="submit" class="sair">Voltar tela inicial</button>
                              </form>
                  </body>

                        </html>
                        <?php

                                }
                            } else {
                                header('Location: telaUser.php');
                            }

            } else {
                header('Location: telaUser.php');
            }
        } else {

            $sql = " SELECT id_evento, id_ongs, data_evento, descricao, rua,bairro, estado, titulo,horas FROM registrar_eventos WHERE id_evento = ?";
            $stmt = $conn->prepare($sql);
            $stmt->bind_param("i", $id_evento);
            $stmt->execute();
            $result = $stmt->get_result();
            ?>
            <!DOCTYPE html>
            <html lang="pt-br">

            <head>
                <meta charset="UTF-8">
                <meta name="viewport" content="width=device-width, initial-scale=1.0">
                <title>Participando</title>
                <link rel="icon" href="imgtcc/pet.jpeg">
                  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
 
                <link rel="stylesheet" href="tccestilo/estiloParticipacao.css">
            </head>

            <body>
                <img src="imgtcc/pet.jpeg" alt="foto do pet">
                <div class="container">
                    <div class="Box1">
                        <h1>Você já participa deste evento</h1>
                    </div>
                    <div class="Box2">
                        <?php
                        if ($result->num_rows > 0) {
                            while ($row = $result->fetch_assoc()) {
                                echo '<div class="Acima">';
                                echo '<h2>' . $row["titulo"] . '</h2>';
                                echo ' </div>';
                                echo '<div class="Abaixo">';
                                echo '<ul>';
                                echo '<li><b>Descrição: ' . $row["descricao"] . ' </b>';
                                echo '<p></p>';
                                echo '</li>';
                                echo '<li><b>Rua:</b>' . $row["rua"] . '  </li>';
                                echo '<li><b>Bairro:</b>' . $row["bairro"] . '  </li>';
                                echo '<li><b>Estado:</b>' . $row["estado"] . '  </li>';
                                echo '<li><b>Data:</b>' . $row["data_evento"] . '  </li>';
                                echo '<li><b>Horas:</b>' . $row["horas"] . '  </li>';
                                echo '&nbsp;';
                                ?>
                                </ul>
                                       <div style="
    height: auto;
    display: flex;
    align-items: center;
    justify-content: center;">
                                <form action="comentarios.php" method="POST">
                                    <?php
                                echo '<input type="hidden" name="id_evento" value="' . $row['id_evento'] . '">';
                                ?>
                                <button class="comentarios" type="submit"><i class="bi bi-chat-dots-fill"></i></button> 
                                </form>
                                </div>
                            </div>
                        </div>
                        </div>
                    <form action="telaUser.php" method="post">
                             <?php
                                echo '<input type="hidden" name="id_usuario" value="' .$_SESSION['id_usuario'].  '">';
                                ?>
                              <button type="submit" class="sair">Voltar tela inicial</button>
                              </form>
                    </body>

                    </html>
                    <?php
                            }
                        } else {

                            $sql = " SELECT id_evento, id_ongs, data_evento, descricao, rua,bairro, estado, titulo,horas FROM registrar_eventos WHERE id_evento = ?";
                            $stmt = $conn->prepare($sql);
                            $stmt->bind_param("i", $id_evento);
                            $stmt->execute();
                            $result = $stmt->get_result();
                            ?>


                <!DOCTYPE html>
                <html lang="pt-br">

                <head>
                    <meta charset="UTF-8">
                    <meta name="viewport" content="width=device-width, initial-scale=1.0">
                    <title>Participando</title>
                    <link rel="icon" href="imgtcc/pet.jpeg">
                    <link rel="stylesheet" href="tccestilo/estiloParticipacao.css">
                </head>

                <body>
                    <img src="imgtcc/pet.jpeg" alt="foto do pet">
                    <div class="container">
                        <div class="Box1">
                            <h1>ERRO ao conectar</h1>
       <form action="login.html">
                            <button class="sair" type="submit" >Voltar tela inicial</button>
               </form>
                </body>

                </html>
            <?php
                        }
        }
    }
}

$conn->close();
?>