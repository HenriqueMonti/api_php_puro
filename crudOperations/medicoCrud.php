<?php

require_once 'db.php';

function getAllMedicos()
{
  $pdo = getConnection();
  try {
    $sql = "select * from medico";
    $stmt = $pdo->query($sql);

    $medico = $stmt->fetchAll(PDO::FETCH_ASSOC);
    header('Content-Type: application/json');
    echo json_encode($medico);
  } catch (PDOException $e) {
    echo "Erro na consulta" . $e->getMessage();
  }
}

function getMedicoById($id)
{
  $pdo = getConnection();
  try {
    $sql = "select * from medico where id=:id";
    $stmt = $pdo->prepare($sql);
    $stmt->bindParam(':id', $id);

    $stmt->execute();

    $medico = $stmt->fetchAll(PDO::FETCH_ASSOC);
    header('Content-Type: application/json');
    echo json_encode($medico);
  } catch (PDOException $e) {
    echo "Erro na consulta" . $e->getMessage();
  }
}

function getEspecialidades()
{
  $pdo = getConnection();
  try {
    $sql = "select * from especialidade";
    $stmt = $pdo->query($sql);

    $especialidade = $stmt->fetchAll(PDO::FETCH_ASSOC);
    header('Content-Type: application/json');
    echo json_encode($especialidade);
  } catch (PDOException $e) {
    echo "Erro na consulta" . $e->getMessage();
  }
}


function getEspecialidadeById($id)
{
  $pdo = getConnection();
  try {
    $sql = "select * from especialidade where id=:id";

    $stmt = $pdo->prepare($sql);

    $stmt->bindParam(':id', $id);

    $stmt->execute();

    $especialidade = $stmt->fetchAll(PDO::FETCH_ASSOC);
    header('Content-Type: application/json');
    echo json_encode($especialidade);
  } catch (PDOException $e) {
    echo "Erro na consulta" . $e->getMessage();
  }
}

function createMedico($data)
{
  $pdo = getConnection();

  if (!$data['nome']) {
    echo "Eh preciso passar o nome do medico";
    return;
  }

  if (!$data['crm']) {
    echo "Eh preciso passar a crm";
    return;
  }

  if (!$data['especialidade']) {
    echo "Eh preciso passar a especialidade do medico";
    return;
  }

  try {
    $sql = "INSERT INTO medico(nome, crm, especialidadeId) values(:nome, :crm, :especialidadeId)";
    $stmt = $pdo->prepare($sql);
    $stmt->bindParam(':nome', $data['nome']);
    $stmt->bindParam(':crm', $data['crm']);
    $stmt->bindParam(':especialidadeId', $data['especialidade']);

    if ($stmt->execute()) {
      echo json_encode(['message' => 'Medico criado']);
    } else {
      echo json_encode(['message' => 'Erro ao criar medico']);
    }
  } catch (PDOException $e) {
    echo "Erro na consulta" . $e->getMessage();
  }
}

function deleteMedico($id)
{
  $pdo = getConnection();
  try {
    $sql = "delete from medico where id = :id";
    $stmt = $pdo->prepare($sql);

    if ($stmt->execute(['id' => $id])) {
      echo json_encode(['message' => 'Medico excluido']);
    } else {
      echo json_encode(['message' => 'Erro ao excluir Medico']);
    }
  } catch (PDOException $e) {
    echo "Erro na consulta" . $e->getMessage();
  }
}

function updateMedico($data, $id)
{
  $pdo = getConnection();
  if (!$data['nome']) {
    echo "Eh preciso passar o nome do medico";
    return;
  }

  if (!$id) {
    echo "Eh preciso enviar o id do medico";
    return;
  }

  if (!$data['crm']) {
    echo "Eh preciso passar a crm do medico";
    return;
  }

  if (!$data['especialidade']) {
    echo "Eh preciso passar a especialidade do medico";
    return;
  }

  try {
    $sql = "UPDATE paciente set crm=:crm, nome=:nome, especialidadeId=:especialidadeId where id=:id";
    $stmt = $pdo->prepare($sql);
    $stmt->bindParam(':nome', $data['nome']);
    $stmt->bindParam(':crm', $data['crm']);
    $stmt->bindParam(':especialidadeId', $data['especilidade']);
    $stmt->bindParam(':id', $id);

    if ($stmt->execute()) {
      echo json_encode(['message' => 'Medico atualizado']);
    } else {
      echo json_encode(['message' => 'Erro ao atualizar medico']);
    }
  } catch (PDOException $e) {
    echo "Erro na consulta" . $e->getMessage();
  }
}

function createEspecialidade($data)
{
  $pdo = getConnection();

  if (!$data['nome']) {
    echo "Eh preciso passar o nome do medico";
    return;
  }

  try {
    $sql = "INSERT INTO especialidade(name) values(:nome)";
    $stmt = $pdo->prepare($sql);
    $stmt->bindParam(':nome', $data['nome']);

    if ($stmt->execute()) {
      echo json_encode(['message' => 'Consulta criada']);
    } else {
      echo json_encode(['message' => 'Erro ao criar consulta']);
    }
  } catch (PDOException $e) {
    echo "Erro na consulta" . $e->getMessage();
  }
}
