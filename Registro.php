<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Registros</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f0f0f0;
            display: flex;
            justify-content: center;
            align-items: center;
            flex-direction: column;
            margin: 0;
            padding: 20px;
        }

        h2 {
            color: #333;
            margin-bottom: 20px;
        }

        /* Botão de voltar */
        .buttoninicial {
            color: #fff;
            background-color: #007bff;
            padding: 10px 20px;
            text-decoration: none;
            border-radius: 5px;
            margin-bottom: 20px;
            display: inline-block;
        }

        /* Mensagem de status */
        .message {
            padding: 10px;
            margin-bottom: 20px;
            border: 1px solid #ccc;
            background-color: #e7f3fe;
            color: #31708f;
            border-radius: 5px;
        }

        /* Formulário de cadastro */
        form {
            background-color: #fff;
            padding: 20px;
            border-radius: 8px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
            margin-bottom: 20px;
            width: 100%;
            max-width: 400px;
        }

        form label {
            display: block;
            margin-bottom: 5px;
            font-weight: bold;
            color: #333;
        }

        form input {
            width: 100%;
            padding: 8px;
            margin-bottom: 15px;
            border: 1px solid #ccc;
            border-radius: 4px;
        }

        form button {
            background-color: #28a745;
            color: #fff;
            border: none;
            padding: 10px 20px;
            border-radius: 4px;
            cursor: pointer;
            font-size: 16px;
            transition: background-color 0.3s;
        }

        form button:hover {
            background-color: #218838;
        }

        /* Tabela de registros */
        table {
            width: 100%;
            max-width: 800px;
            background-color: #fff;
            border-collapse: collapse;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
            margin-bottom: 20px;
        }

        table th, table td {
            padding: 10px;
            text-align: left;
            border-bottom: 1px solid #ddd;
        }

        table th {
            background-color: #007bff;
            color: #fff;
        }

        table tr:hover {
            background-color: #f1f1f1;
        }

        .actions button {
            background-color: #ffc107;
            border: none;
            padding: 5px 10px;
            border-radius: 4px;
            cursor: pointer;
            color: #333;
            transition: background-color 0.3s;
        }

        .actions button:hover {
            background-color: #e0a800;
        }

        /* Modal de edição */
        .modal {
            display: none;
            position: fixed;
            z-index: 1;
            left: 0;
            top: 0;
            width: 100%;
            height: 100%;
            overflow: auto;
            background-color: rgba(0, 0, 0, 0.5);
            padding-top: 60px;
        }

        .modal-content {
            background-color: #fff;
            margin: 5% auto;
            padding: 20px;
            border: 1px solid #888;
            width: 90%;
            max-width: 400px;
            border-radius: 8px;
        }

        .modal-content h3 {
            margin-top: 0;
            color: #333;
        }

        .close {
            color: #aaa;
            float: right;
            font-size: 28px;
            font-weight: bold;
            cursor: pointer;
        }

        .close:hover {
            color: #000;
        }
    </style>
</head>
<body>
<h2>Cadastro de Registros</h2>
<a href="index.html" class="buttoninicial">Tela inicial</a>

<?php if (!empty($message)): ?>
    <div class="message"><?= htmlspecialchars($message) ?></div>
<?php endif; ?>

<form method="POST">
    <label for="registro_cod">Código:</label>
    <input type="number" id="registro_cod" name="registro_cod" required>

    <label for="registro_data">Data:</label>
    <input type="date" id="registro_data" name="registro_data" required>

    <label for="funcionario_cod">Código Funcionário:</label>
    <input type="number" id="funcionario_cod" name="funcionario_cod" required>

    <label for="registro_hora">Horário:</label>
    <input type="time" id="registro_hora" name="registro_hora" required>

    <button type="submit" name="add_registro">Cadastrar</button>
</form>

<table>
    <thead>
        <tr>
            <th>ID</th>
            <th>Data</th>
            <th>Código Funcionário</th>
            <th>Horário</th>
            <th>Ações</th>
        </tr>
    </thead>
    <tbody>
        <?php while ($usuario = $usuarios->fetch_assoc()): ?>
            <tr>
                <td><?= htmlspecialchars($usuario['registro_cod']) ?></td>
                <td><?= htmlspecialchars($usuario['registro_data']) ?></td>
                <td><?= htmlspecialchars($usuario['funcionario_cod']) ?></td>
                <td><?= htmlspecialchars($usuario['registro_hora']) ?></td>
                <td class="actions">
                    <button onclick="openModal(<?= htmlspecialchars($usuario['registro_cod']) ?>, '<?= htmlspecialchars($usuario['registro_data']) ?>', '<?= htmlspecialchars($usuario['funcionario_cod']) ?>', '<?= htmlspecialchars($usuario['registro_hora']) ?>')">Editar</button>

                    <form method="POST" style="display:inline;">
                        <input type="hidden" name="registro_cod" value="<?= htmlspecialchars($usuario['registro_cod']) ?>">
                        <button type="submit" name="delete_registro">Excluir</button>
                    </form>
                </td>
            </tr>
        <?php endwhile; ?>
    </tbody>
</table>

<div id="editModal" class="modal">
    <div class="modal-content">
        <span class="close" onclick="closeModal()">&times;</span>
        <h3>Editar Registro</h3>
        <form method="POST">
            <input type="hidden" id="edit_registro_cod" name="registro_cod">
            <label for="edit_registro_data">Data:</label>
            <input type="date" id="edit_registro_data" name="registro_data" required>

            <label for="edit_funcionario_cod">Código Funcionário:</label>
            <input type="number" id="edit_funcionario_cod" name="funcionario_cod" required>

            <label for="edit_registro_hora">Horário:</label>
            <input type="time" id="edit_registro_hora" name="registro_hora" required>

            <button type="submit" name="edit_registro">Salvar Alterações</button>
        </form>
    </div>
</div>

<script>
function openModal(cod, data, funcionario_cod, hora) {
    document.getElementById('edit_registro_cod').value = cod;
    document.getElementById('edit_registro_data').value = data;
    document.getElementById('edit_funcionario_cod').value = funcionario_cod;
    document.getElementById('edit_registro_hora').value = hora;
    document.getElementById('editModal').style.display = 'block';
}

function closeModal() {
    document.getElementById('editModal').style.display = 'none';
}

window.onclick = function(event) {
    if (event.target == document.getElementById('editModal')) {
        closeModal();
    }
}
</script>
</body>
</html>

