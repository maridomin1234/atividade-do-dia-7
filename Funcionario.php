<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Funcionários</title>
    <style>
        /* Estilos Gerais */
        body {
            font-family: Arial, sans-serif;
            background-color: #f4f4f9;
            margin: 0;
            padding: 20px;
            display: flex;
            flex-direction: column;
            align-items: center;
        }
        
        h2 {
            color: #4b0082;
        }

        .buttoninicial {
            background-color: blueviolet;
            color: white;
            padding: 10px 15px;
            border: none;
            border-radius: 4px;
            font-weight: bold;
            text-decoration: none;
            margin-bottom: 20px;
        }

        .buttoninicial:hover {
            background-color: indigo;
        }

        .message {
            background-color: #d4edda;
            color: #155724;
            padding: 10px;
            margin-bottom: 20px;
            border: 1px solid #c3e6cb;
            border-radius: 4px;
            width: 100%;
            max-width: 600px;
            text-align: center;
        }

        /* Formulário */
        form {
            background: #fff;
            padding: 20px;
            margin-bottom: 20px;
            border-radius: 5px;
            box-shadow: 0px 0px 10px rgba(0, 0, 0, 0.1);
            max-width: 600px;
            width: 100%;
        }

        form label {
            display: block;
            margin-bottom: 8px;
            font-weight: bold;
            color: #333;
        }

        form input[type="text"], form input[type="number"], form input[type="submit"] {
            width: 100%;
            padding: 8px;
            margin-bottom: 15px;
            border: 1px solid #ddd;
            border-radius: 4px;
            box-sizing: border-box;
        }

        form button {
            background-color: blueviolet;
            color: white;
            border: none;
            padding: 10px 15px;
            border-radius: 4px;
            cursor: pointer;
            font-weight: bold;
            width: 100%;
        }

        form button:hover {
            background-color: indigo;
        }

        /* Tabela */
        table {
            width: 100%;
            max-width: 600px;
            border-collapse: collapse;
            margin-top: 20px;
        }

        table th, table td {
            padding: 12px;
            border: 1px solid #ddd;
            text-align: left;
        }

        table th {
            background-color: #4b0082;
            color: white;
        }

        .actions button {
            background-color: #6c757d;
            color: white;
            border: none;
            padding: 5px 10px;
            border-radius: 4px;
            cursor: pointer;
            margin-right: 5px;
        }

        .actions form {
            display: inline;
        }

        .actions button:hover {
            background-color: #5a6268;
        }

        /* Modal */
        .modal {
            display: none;
            position: fixed;
            z-index: 1;
            left: 0;
            top: 0;
            width: 100%;
            height: 100%;
            background-color: rgba(0, 0, 0, 0.5);
            justify-content: center;
            align-items: center;
        }

        .modal-content {
            background-color: #fff;
            padding: 20px;
            border-radius: 5px;
            max-width: 400px;
            width: 90%;
            box-shadow: 0px 0px 10px rgba(0, 0, 0, 0.2);
        }

        .close {
            color: #aaa;
            float: right;
            font-size: 24px;
            font-weight: bold;
            cursor: pointer;
        }

        .close:hover {
            color: #000;
        }
    </style>
</head>
<body>
<h2>Cadastro de Funcionários</h2>
<a href="index.html" class="buttoninicial">Tela inicial</a>

<?php if (!empty($message)): ?>
    <div class="message"><?= htmlspecialchars($message) ?></div>
<?php endif; ?>

<form method="POST">
    <label for="funcionario_cod">Código:</label>
    <input type="number" id="funcionario_cod" name="funcionario_cod" required>

    <label for="funcionario_nome">Nome:</label>
    <input type="text" id="funcionario_nome" name="funcionario_nome" required>

    <label for="funcionario_cargo">Cargo:</label>
    <input type="text" id="funcionario_cargo" name="funcionario_cargo" required>

    <button type="submit" name="add_user">Cadastrar</button>
</form>

<table>
    <thead>
        <tr>
            <th>ID</th>
            <th>Nome</th>
            <th>Cargo</th>
            <th>Ações</th>
        </tr>
    </thead>
    <tbody>
        <?php while ($usuario = $usuarios->fetch_assoc()): ?>
            <tr>
                <td><?= htmlspecialchars($usuario['funcionario_cod']) ?></td>
                <td><?= htmlspecialchars($usuario['funcionario_nome']) ?></td>
                <td><?= htmlspecialchars($usuario['funcionario_cargo']) ?></td>
                <td class="actions">
                    <button onclick="openModal(<?= htmlspecialchars($usuario['funcionario_cod']) ?>, '<?= htmlspecialchars($usuario['funcionario_nome']) ?>', '<?= htmlspecialchars($usuario['funcionario_cargo']) ?>')">Editar</button>
                    <form method="POST" style="display:inline;">
                        <input type="hidden" name="usu_cod" value="<?= htmlspecialchars($usuario['funcionario_cod']) ?>">
                        <button type="submit" name="delete_user">Excluir</button>
                    </form>
                </td>
            </tr>
        <?php endwhile; ?>
    </tbody>
</table>

<div id="editModal" class="modal">
    <div class="modal-content">
        <span class="close" onclick="closeModal()">&times;</span>
        <h3>Editar Funcionário</h3>
        <form method="POST">
            <input type="hidden" id="usu_cod" name="usu_cod">
            <label for="edit_nome">Nome:</label>
            <input type="text" id="edit_nome" name="nome" required>

            <label for="edit_cargo">Cargo:</label>
            <input type="text" id="edit_cargo" name="cargo" required>

            <button type="submit" name="edit_user">Salvar Alterações</button>
        </form>
    </div>
</div>

<script>
function openModal(cod, nome, cargo) {
    document.getElementById('usu_cod').value = cod;
    document.getElementById('edit_nome').value = nome;
    document.getElementById('edit_cargo').value = cargo;
    document.getElementById('editModal').style.display = 'flex';
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
