<?php

function getAllPacientes()
{
  $pdo = getConnection();
  try {
    $sql = "select * from paciente";
    $stmt = $pdo->query($sql);

    $pacientes = $stmt->fetchAll(PDO::FETCH_ASSOC);
    header('Content-Type: application/json');
    echo json_encode($pacientes);
  } catch (PDOException $e) {
    echo "Erro na consulta" . $e->getMessage();
  }
}

function getPacienteById($id)
{
  $pdo = getConnection();
  try {
    $sql = "select * from paciente where id=:id";
    $stmt = $pdo->prepare($sql);
    $stmt->bindParam(':id', $id);
    $stmt->execute();
    $pacientes = $stmt->fetchAll(PDO::FETCH_ASSOC);
    header('Content-Type: application/json');
    echo json_encode($pacientes);
  } catch (PDOException $e) {
    echo "Erro na consulta" . $e->getMessage();
  }
}

function createPaciente($data)
{
  $pdo = getConnection();

  if (!$data['nome']) {
    echo "Eh preciso passar o nome do paciente";
    return;
  }

  if (!$data['endereco']) {
    echo "Eh preciso passar o endereco do paciente";
    return;
  }

  try {
    $sql = "INSERT INTO paciente(nome, endereco) values(:nome, :endereco)";
    $stmt = $pdo->prepare($sql);
    $stmt->bindParam(':nome', $data['nome']);
    $stmt->bindParam(':endereco', $data['endereco']);

    if ($stmt->execute()) {
      echo json_encode(['message' => 'Paciente criado']);
    } else {
      echo json_encode(['message' => 'Erro ao criar paciente']);
    }
  } catch (PDOException $e) {
    echo "Erro na consulta" . $e->getMessage();
  }
}

function deletePaciente($id)
{
  $pdo = getConnection();
  try {
    $sql = "delete from paciente where id = :id";
    $stmt = $pdo->prepare($sql);

    if ($stmt->execute(['id' => $id])) {
      echo json_encode(['message' => 'Paciente excluido']);
    } else {
      echo json_encode(['message' => 'Erro ao excluir paciente']);
    }
  } catch (PDOException $e) {
    echo "Erro na consulta" . $e->getMessage();
  }
}

function updatePaciente($data, $id)
{
  $pdo = getConnection();
  if (!$data['nome']) {
    echo "Eh preciso passar o nome do paciente";
    return;
  }

  if (!$id) {
    echo "Eh preciso enviar o id do cliente";
    return;
  }

  if (!$data['endereco']) {
    echo "Eh preciso passar o endereco do paciente";
    return;
  }
  try {
    $sql = "UPDATE paciente set endereco=:endereco, nome=:nome where id=:id";
    $stmt = $pdo->prepare($sql);
    $stmt->bindParam(':nome', $data['nome']);
    $stmt->bindParam(':endereco', $data['endereco']);
    $stmt->bindParam(':id', $id);

    if ($stmt->execute()) {
      echo json_encode(['message' => 'Paciente atualizado']);
    } else {
      echo json_encode(['message' => 'Erro ao atualizar paciente']);
    }
  } catch (PDOException $e) {
    echo "Erro na consulta" . $e->getMessage();
  }
}
